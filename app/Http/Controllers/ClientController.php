<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index(Request $req) : JsonResponse {
        $val = Validator::make($req->all(), [
            'limit' => 'required|numeric|min:1|max:10',
        ]);

        if($val->fails()) {
            return $this->G_ValidatorFailResponse($val);
        }

        if($req->user()->hasRole('staff')) {
            $data = User::limit($req->limit)
                ->with([
                    'info.agent',
                    'info.staff',
                    'plan',
                ])
                ->withSum('client_transactions', 'amount')
                ->orderBy('created_at', 'DESC')
                ->get();
            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        return $this->G_UnauthorizedResponse();
    }
}
