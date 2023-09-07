<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Branch;
use App\Models\Region;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function G_ReturnDefault($req = null) {
        if($req) {
            $auth = User::where('id', $req->user()->id)->with(['info', 'branch', 'region'])->first();

            return [
                'status' => true,
                'message' => 'success',
                'auth' => [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'auth' => $auth,
                    'permissions' => $req->user()->getAllPermissions()->pluck('name'),
                    'role' => $this->G_GetEncryptedRole($req->user()->roles()->pluck('name')->first()),
                    'branch' => Branch::where('id', $auth->branch_id),
                    'region' => Region::where('id', $auth->region_id),
                ],
            ];
        }
        else {
            return [
                'status' => true,
                'message' => 'success',
            ];
        }
    }

    public function G_UnauthorizedResponse(string $message = 'Logout') : JsonResponse {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 401);
    }

    public function G_ValidatorFailResponse($val) : JsonResponse {
        return response()->json([
            'status' => false,
            'message' => 'Invalid Input',
            'errors' => $val->errors()
        ], 401);
    }


    public function G_AvatarUpload($image, string $path = '') : string {
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);

        $image = base64_decode($image);
        $imageName = time(). '.jpg';
        $location = '/uploads/'.$path.$imageName;
        file_put_contents('uploads/'.$path.$imageName, $image);

        return $location;
    }

    public function G_GetEncryptedRole($role) : string  {
        if($role == 'admin') {
            return env('VUE_APP_ROLE_ADMIN ');
        }
        else if($role == 'regional_manager') {
            return env('VUE_APP_ROLE_REGIONAL_MANAGER');
        }
        else if($role == 'branch_manager') {
            return env('VUE_APP_ROLE_BRANCH_MANAGER');
        }
        else if($role == 'staff') {
            return env('VUE_APP_ROLE_STAFF');
        }
        else if($role == 'agent') {
            return env('VUE_APP_ROLE_AGENT');
        }
        else if($role = 'client') {
            return env('VUE_APP_ROLE_CLIENT');
        }

        return 1;
    }
}
