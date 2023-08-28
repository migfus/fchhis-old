<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Info;
use App\Models\Beneficiary;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function index(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            $data = [
                [
                    'id' => 7,
                    'icon' => 'fa-user-friends',
                    'color' => 'success',
                    'name' => 'Beneficiaries',
                    'count' => Beneficiary::whereNotNull('client_id')->count(),
                    'top' => Beneficiary::whereNotNull('client_id')
                        ->orderBy('created_at', 'DESC')
                        ->limit(5)
                        ->get(),
                ],
                [
                    'id' => 6,
                    'icon' => 'fa-child',
                    'color' => 'success',
                    'name' => 'Client',
                    'count' => User::hasRole('client')->count(),
                    'top' => User::hasRole('client')->orderBy('created_at', 'DESC')->get(),
                ],
                [
                    'id' => 5,
                    'icon' => 'fa-user-edit',
                    'color' => 'info',
                    'name' => 'Staff',
                    'count' => User::hasRole('staff')->count(),
                    'top' => User::hasRole('staff')->orderBy('created_at', 'DESC')->get(),
                ],
                [
                    'id' => 4,
                    'icon' => 'fa-handshake',
                    'color' => 'purple',
                    'name' => 'Agent',
                    'count' => User::hasRole('agent')->count(),
                    'top' => User::hasRole('agent')->orderBy('created_at', 'DESC')->get(),
                ],
                [
                    'id' => 2,
                    'icon' => 'fa-crown',
                    'color' => 'warning',
                    'name' => 'Admin',
                    'count' => User::hasRole('admin')->count(),
                    'top' => User::hasRole('admin')->orderBy('created_at', 'DESC')->get(),
                ],
            ];

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }
        return $this->G_UnauthorizedResponse();
    }
}
