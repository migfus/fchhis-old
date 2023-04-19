<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
  public function Login(Request $req) {
    $val = Validator::make($req->all(), [
      'email' => 'required|email',
      'password' => 'required|min:8',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse();
    }

    $user = User::where('email', $req->email)->first();
    if(!$user || !Hash::check($req->password, $user->password)) {
      return response()->json(['status' => false, 'message' => 'Invalid Credential!'], 401);
    }

    return response()->json([
      ...$this->G_ReturnDefault(), 'data' => [
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
      return $this->G_ValidatorFailResponse($val);
    }

    $user = User::find($req->user()->id)->first();
    if(!$user || !Hash::check($req->currentPassword, $user->password)) {
      return $this->G_UnauthorizedResponse('Invalid Password');
    }

    $user = User::find($req->user()->id)->update(['password' => Hash::make($req->newPassword)]);

    return $this->G_UnauthorizedResponse();
  }

  public function ChangeAvatar(Request $req) {
    $val = Validator::make($req->all(), [
      'file' => 'required'
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $user = User::find($req->user()->id);
    $user->avatar =  $this->G_AvatarUpload($req->file);
    $user->save();

    return response()->json([...$this->G_ReturnDefault($req), 'file' => $location]);
  }
}
