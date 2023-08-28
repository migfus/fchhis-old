<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function G_ReturnDefault($req = null) {
        if($req) {
            $auth = User::where('id', $req->user()->id)->with('info')->first();

            return [
                'status' => true,
                'message' => 'success',
                'auth' => [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'auth' => $auth,
                    'permissions' => $req->user()->getAllPermissions()->pluck('name'),
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

    public function G_GetEncryptedRole($req) : string  {
        if($req->user()->hasRole('admin')) {
            return 'jklsdfgjkl;asdrtiopuert'
        }
    }
}
