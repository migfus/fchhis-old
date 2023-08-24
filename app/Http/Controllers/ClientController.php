<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
  public function index(Request $req) {
    $val = Validator::make($req->all(), [
      'limit' => 'required|numeric|min:1|max:10',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if($req->user()->role == 5) {
      $data = User::limit($req->limit)
        ->with([
          'info.agent.info',
          'info.staff.info',
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
