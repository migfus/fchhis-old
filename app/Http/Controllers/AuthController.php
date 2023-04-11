<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
  private function ReturnDefault($role = null) {
    return ['status' => true, 'message' => 'success', 'role' => $role];
  }

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
      ...$this->returnDefault($user->role), 'data' => [
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

    return response()->json([...$this->returnDefault($req->user()->role), 'data' => true]);
  }

  private function ValidationErrorResponse($data = '') {
    return response()->json(['status' => false, 'message' => 'Invalid Input', 'data' => $data], 401);
  }

  public function ChangeAvatar(Request $req) {
    $validator = Validator::make($req->all(), [
      'file' => 'required'
    ]);

    if($validator->fails()) {
      response()->json(['status' => false, 'message' => 'Invalid Input']);
    }
    $image = $req->file;
    list($type, $image) = explode(';', $image);
    list(, $image) = explode(',', $image);

    $image = base64_decode($image);
    $imageName = time(). '.jpg';
    $location = '/uploads/'.$imageName;
    file_put_contents('uploads/'.$imageName, $image);

    $user = User::find($req->user()->id);
    $user->avatar =  $location;
    $user->save();

    return response()->json([...$this->ReturnDefault($req->user()->role), 'file' => $location]);
  }
}
