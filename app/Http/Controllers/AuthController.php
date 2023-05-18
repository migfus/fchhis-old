<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Person;

class AuthController extends Controller
{
  public function Login(Request $req) {
    $val = Validator::make($req->all(), [
      'email' => 'required',
      'password' => 'required|min:8',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse();
    }

    $user = User::where('email', $req->email)->orWhere('username', $req->email)->first();
    if(!$user || !Hash::check($req->password, $user->password)) {
      return response()->json(['status' => false, 'message' => 'Invalid Credential!'], 401);
    }

    return response()->json([
      ...$this->G_ReturnDefault(), 'data' => [
        'auth' => $user,
        'ip'   => $_SERVER['REMOTE_ADDR'],
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
      return response()->json(['data' => 'Incorrect Password'], 401);
    }

    $user = User::find($req->user()->id)->update(['password' => Hash::make($req->newPassword)]);

    return response()->json([...$this->G_ReturnDefault($req), 'data' => $user]);
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

    return response()->json([...$this->G_ReturnDefault($req), 'file' => true]);
  }

  public function ORCheck(Request $req) {
    $val = Validator::make($req->all(), [
      'or' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $user = User::where('OR', $req->or)->where('username', null)->with('person')->first();
    if($user) {
      return response()->json(['data' => $user]);
    }
    else {
      return response()->json(['data' => false]);

    }
  }

  public function Register(Request $req) {
    $val = Validator::make($req->all(), [
      'or' => 'required',
      'avatar' => '',
      'email' => 'required|email|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required|min:8',

      'person.address' => 'required',
      'person.address_id' => 'required',
      'person.bday' => 'required',
      'person.bplace_id' => 'required',
      'person.extName' => '',
      'person.name' => 'required',
      'person.sex' => 'required',
      'person.id' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if(User::where('OR', $req->OR)->where('username', null)->first()) {
      $person = Person::where('id', $req->person['id'])->update([
        'lastName'  => $req->person['lastName'],
        'firstName' => $req->person['firstName'],
        'midName'   => $req->person['midName'],
        'extName'   => $req->person['extName'],
        'bday'      => $req->person['bday'],
        'bplace_id' => $req->person['bplace_id'],
        'sex'       => $req->person['sex'],
        'address_id'=> $req->person['address_id'],
        'address'   => $req->person['address'],
        'mobile'    => $req->person['mobile'],
      ]);

      $avatar = null;

      if($req->avatar != '') {
        $avatar = $this->G_AvatarUpload($req->avatar);
      }

      $user = User::where('OR', $req->OR)->update([
        'username' => $req->username,
        'email'    => $req->email,
        'password' => Hash::make($req->password),
        'avatar'   => $avatar,
        'notify_mobile' => $req->notifyMobile,
      ]);

      return response()->json([...$this->G_ReturnDefault($req), 'data' => $user]);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function Profile(Request $req) {
    return response()->json([
      'data' => User::where('id', $req->user()->id)->with('person')->first(),
    ], 200);
  }
}
