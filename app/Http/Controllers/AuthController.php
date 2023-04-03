<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
  protected $returnDefault = ['status' => true, 'message' => 'success'];

  public function Login(Request $req) {
    $val = Validator::make($req->all(), [
      'email' => 'required|email',
      'password' => 'required|min:8',
    ]);

    if($val->fails()) {
      return $this->ValidationErrorResponse();
    }

    $user = User::where('email', $req->email)->first();
    if(!$user || !Hash::check($req->password, $user->password)) {
      return response()->json(['status' => false, 'message' => 'Invalid Credential!'], 401);
    }

    return response()->json([
      ...$this->returnDefault, 'data' => [
        'auth' => $user,
        'token' => $user->createToken('token idk')->plainTextToken],
    ], 200);
  }

  public function ChangePassword(Request $req) {
    $val = Validator::make($req->all(), [
      'newPassword' => 'required|min:8',
      'currentPassword' => 'required|min:8'
    ]);

    if($val->fails()) {
      return $this->ValidationErrorResponse();
    }

    $user = User::find($req->user()->id)->first();
    if(!$user || !Hash::check($req->currentPassword, $user->password)) {
      return response()->json(['status' => false, 'message' => 'Invalid Credential!'], 401);
    }

    $user = User::find($req->user()->id)->update(['password' => Hash::make($req->newPassword)]);

    return response()->json([...$this->returnDefault, 'data' => true]);
  }

  private function ValidationErrorResponse($data = '') {
    return response()->json(['status' => false, 'message' => 'Invalid Input', 'data' => $data], 401);
  }
}
