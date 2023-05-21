<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMailer;
use Carbon\Carbon;

class AuthController extends Controller
{
  public function Login(Request $req) {
    $val = Validator::make($req->all(), [
      'email' => 'required',
      'password' => 'required|min:8',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $user = User::where('email', $req->email)->orWhere('username', $req->email)->with('person')->first();
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

    return response()->json([...$this->G_ReturnDefault($req), 'file' => $user->avatar]);
  }

  public function ORCheck(Request $req) {
    $val = Validator::make($req->all(), [
      'or' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $user = Person::where('or', $req->or)->whereNull('bday')->first();
    if($user) {
      return response()->json(['data' => $user]);
    }
    else {
      return response()->json(['data' => false], 401);

    }
  }

  public function Register(Request $req) {
    $val = Validator::make($req->all(), [
      'or' => 'required',
      'avatar' => '',
      'email' => 'required|email|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required|min:8',

      'address' => 'required',
      'address_id' => 'required',
      'bday' => 'required',
      'bplace_id' => 'required',
      'name' => 'required',
      'sex' => 'required',
      'id' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if(Person::where('or', $req->or)->whereNull('bday')->first()) {
      $person = Person::where('id', $req->id)->update([
        'name'      => $req->name,
        'bday'      => $req->bday,
        'bplace_id' => $req->bplace_id,
        'sex'       => $req->sex,
        'address_id'=> $req->address_id,
        'address'   => $req->address,
      ]);

      $avatar = null;

      if($req->avatar != '') {
        $avatar = $this->G_AvatarUpload($req->avatar);
      }

      $user = User::where('person_id', Person::where('id', $req->id)->first()->id)->update([
        'username' => $req->username,
        'email'    => $req->email,
        'password' => Hash::make($req->password),
        'avatar'   => $avatar,
      ]);

      return response()->json([...$this->G_ReturnDefault(), 'data' => 'success']);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function Profile(Request $req) {
    return response()->json([
      'data' => User::where('id', $req->user()->id)->with('person')->first(),
    ], 200);
  }

  public function Recovery(Request $req) {
    if(User::where('email', $req->email)->first()) {
      $code = rand(00000,99999);

      User::where('email', $req->email)->update([
        'remember_token' => $code
      ]);

      $data = [
        'link' => 'http://127.0.0.1:8000/forgot/fill?code='.$code,
        // 'link' => 'https://fchhis.migfus20.com/forgot/fill?code='.$code,
        'code' => $code
      ];
      Mail::to($req->email)->send(new ForgotPasswordMailer($data));

      return response()->json(['data' => 'success']);
    }

    return response()->json(['data' => 'error']);
  }

  public function ConfirmRecovery(Request $req) {
    if(User::where('remember_token', $req->code)->first()) {
      return response()->json(['data' => true]);
    }

    return response()->json(['data' => false]);
  }

  public function ChangePasswordRecovery(Request $req) {
    $val = Validator::make($req->all(), [
      'newPassword' => 'required',
      'code' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    User::where('remember_token', $req->code)
      ->update([
        'password' => Hash::make($req->newPassword),
        'remember_token' => null
      ]);

    return response()->json(['data' => true]);
  }

  // SECTION OVERDUE
  public function Overdue(Request $req) {
    switch($req->user()->role) {
      case 5:
        return $this->StaffOverdue($req);
      case 2:
        return $this->StaffOverdue($req);
      default:
        return $this->G_UnauthorizedResponse();
    }
  }

  private function StaffOverdue($req) {
    $grace = Person::whereNotNull('due_at')->where('due_at', '<=', Carbon::now())->count();
    $overdue = Person::whereNotNull('due_at')->where('due_at', '<=', Carbon::now()->subMonth(2))->count();

    return response()->json([...$this->G_ReturnDefault($req), 'data' => ['grace' => $grace, 'overdue' => $overdue]]);
  }
}
