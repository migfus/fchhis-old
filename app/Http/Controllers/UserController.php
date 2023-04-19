<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  private function getCount($req) {
    if($req->user()->role == 2) {
      $count = [
        'all'     => User::count(),
        'clients' => User::where('role', 6)->count(),
        'staff'   => User::where('role', 5)->count(),
        'agent'   => User::where('role', 4)->count(),
        'manager' => User::where('role', 3)->count(),
        'admin'   => User::where('role', 2)->count(),
        'inactive'=> User::where('role', 0)->count(),
        'banned'  => User::where('role', 1)->count(),
      ];

      $data = [
        ['name' => 'All',     'count' => $count['all'],     'color' => 'info',    'icon' => 'fa-users'],
        ['name' => 'Clients', 'count' => $count['clients'], 'color' => 'success', 'icon' => 'fa-child'],
        ['name' => 'Staff',   'count' => $count['staff'],   'color' => 'info',    'icon' => 'fa-user-edit'],
        ['name' => 'Agent',   'count' => $count['agent'],   'color' => 'purple',  'icon' => 'fa-handshake'],
        ['name' => 'Manager', 'count' => $count['manager'], 'color' => 'orange',  'icon' => 'fa-tasks'],
        ['name' => 'Admin',   'count' => $count['admin'],   'color' => 'warning', 'icon' => 'fa-crown'],
        ['name' => 'Inactive','count' => $count['inactive'],'color' => 'secondary','icon'=> 'fa-moon'],
        ['name' => 'Banned',  'count' => $count['banned'],  'color' => 'danger',  'icon' => 'fa-ban'],
      ];

      return response()->json(['status' => true, 'message' => 'success', 'data' => $data], 200);
    }
    return $this->G_UnauthorizedResponse();
  }

  public function index(Request $req) {
    if($req->count)
      return $this->getCount($req);

    $val = Validator::make($req->all(), [
      'role' => 'required|numeric',
      'search' => '',
      'start' => '',
      'end' => '',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $user = User::select('*');

    if($req->user()->role == 2) {
      // NOTE ROLE FITLER
      if($req->role < 7) {
        $user->where('role', $req->role);
      }

      // NOTE DATE RANGE FILTER
      if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
        if((bool)strtotime($req->start)) {
          $user->where('created_at', '>=', $req->start);
        }
        if((bool)strtotime($req->end)) {
          $user->where('created_at', '<=', $req->end);
        }
        $user->with(['person.user', 'plan']);
      }
      else {
        // NOTE SEARCH FILTER
        switch($req->filter) {
          case 'email':
            $user->where('email', 'LIKE', '%'.$req->search.'%')->with(['person.user', 'plan']); // OK No whereRelation
            break;
          case 'address':
            $user->with(['person.user', 'plan'])
              ->whereHas('person.user', function($q) use ($req) {
                $q->where('address', 'LIKE', '%'.$req->search.'%');
              });
            break;
          case 'plans':
            $user->with(['person.user', 'plan'])
              ->whereHas('plan', function($q) use ($req) {
                $q->where('name', 'LIKE', '%'.$req->search.'%');
              });
            break;
          default:
            $user->with(['person.user', 'plan'])
              ->whereHas('person.user', function($q) use ($req) {
                $q->where('lastName', 'LIKE', '%'.$req->search.'%')
                  ->orWhere('firstName', 'LIKE', '%'.$req->search.'%')
                  ->orWhere('midName', 'LIKE', '%'.$req->search.'%');
              });
        }
      }

      $data = $user->orderBy('created_at', 'desc')->paginate(10);

      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function store(Request $req) {
    if($req->user()->role == 2) {

      $val = Validator::make($req->all(), [
        'avatar'   => '',
        'username' => 'required|unique:users',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:8',
        'mobile'   => 'required',
        'notifyMobile' => 'required',
        'role'     => 'required',
        'plan'     => 'required',

        'lastName' => 'required',
        'firstName'=> 'required',
        'midName'  => '',
        'extName'  => '',
        'sex'      => 'required',
        'bday'     => 'required',
        'bplaceID' => 'required',
        'addressID'=> 'required',
        'address'  => 'required',
      ]);

      if($val->fails()) {
        return $this->G_ValidatorFailResponse($val);
      }

      $person = Person::create([
        'created_by_user_id' => $req->user()->id,
        'lastName'  => $req->lastName,
        'firstName' => $req->firstName,
        'midName'   => $req->midName,
        'extName'   => $req->extName,
        'bday'      => $req->bday,
        'bplace_id' => $req->bplaceID,
        'sex'       => $req->sex,
        'address_id'=> $req->bplaceID,
        'address'   => $req->address,
        'mobile'    => $req->mobile,
      ]);

      $avatar = null;

      if($req->avatar != '') {
        $avatar = $this->AvatarUpload($req);
      }

      $user = User::create([
        'person_id'=> $person->id,
        'plan_id'  => $req->plan,
        'username' => $req->username,
        'email'    => $req->email,
        'password' => Hash::make($req->password),
        'avatar'   => $avatar,
        'role'     => $req->role,
        'notify_mobile' => $req->notifyMobile,
      ]);

      return response()->json([...$this->G_ReturnDefault($req)]);
    }

    return $this->G_UnauthorizedResponse();
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
      //
  }

  public function update(Request $req, string $id) {
    if($req->user()->role == 2) {

      $val = Validator::make($req->all(), [
        'avatar'   => '',
        'username' => ['required', Rule::unique('users', 'username')->ignore($req->id)],
        'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($req->id)],
        'password' => '',
        'person.mobile' => 'required',
        'notify_mobile' => 'required',
        'role'     => 'required',
        'plan_id'  => 'required',

        'person.lastName'  => 'required',
        'person.firstName' => 'required',
        'person.midName'   => '',
        'person.extName'   => '',
        'person.sex'       => 'required',
        'person.bday'      => 'required',
        'person.bplace_id' => 'required',
        'person.address_id'=> 'required',
        'person.address'   => 'required',
      ]);

      if($val->fails()) {
        return $this->G_ValidatorFailReponse($val);
      }

      $person = Person::where('id', $req->person_id)->update([
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

      $user = User::where('id', $id)->update([
        'plan_id'  => $req->plan_id,
        'username' => $req->username,
        'email'    => $req->email,
        'role'     => $req->role,
        'notify_mobile' => $req->notify_mobile,
      ]);

      if($req->password) {
        User::where('id', $id)->update(['password' => Hash::make($req->password)]);
      }

      if(!User::where('id', $id)->where('avatar', $req->avatar)->first()) {
        User::where('id', $id)->update(['avatar' => $this->G_AvatarUpload($req->avatar)]);
      }

      return response()->json([...$this->G_ReturnDefault($req),]);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function destroy(string $id, Request $req) {
    if($req->user()->role == 2) {
      User::find($id)->delete();
      return response()->json([...$this->G_ReturnDefault($req)], 200);
    }

    return $this->G_UnauthorizedResponse();
  }
}
