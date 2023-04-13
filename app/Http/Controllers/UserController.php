<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  private function ReturnDefault($role) {
    return ['status' => true, 'message' => 'success', 'role' => $role];
  }

  private function ValidateErrorResponse($data = '') {
    return response()->json(['status' => false, 'message' => 'Invalid Input', 'data' => $data], 401);
  }

  public function index(Request $req) {
    $val = Validator::make($req->all(), [
      'role' => 'required|numeric',
      'search' => '',
      'start' => '',
      'end' => '',
    ]);

    if($val->fails()) {
      return $this->ValidateErrorResponse();
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
          $user->where('created_at', '>=', $req->start)->with('person');
        }
        if((bool)strtotime($req->end)) {
          $user->where('created_at', '<=', $req->end)->with('person');
        }
      }
      else {
        // NOTE SEARCH FILTER
        switch($req->filter) {
          case 'name':
            $user->with('person')
              ->whereRelation('person', 'firstName', 'LIKE', '%'.$req->search.'%')
              ->orWhereRelation('person', 'lastName', 'LIKE', '%'.$req->search.'%')
              ->orWhereRelation('person', 'midName', 'LIKE', '%'.$req->search.'%');
            break;
          case 'email':
            $user->where('email', 'LIKE', '%'.$req->search.'%');
            break;
          case 'address':
            $user->with('person')
              ->whereRelation('person', 'address', 'LIKE', '%'.$req->search.'%');
            break;
          default:
            $user->orWhere('email',    'LIKE', '%'.$req->search.'%')
              ->orWhere('username', 'LIKE', '%'.$req->search.'%')
              ->orwhereRelation('person', 'firstName','LIKE', '%'.$req->search.'%')
              ->orWhereRelation('person', 'lastName', 'LIKE', '%'.$req->search.'%')
              ->orWhereRelation('person', 'midName',  'LIKE', '%'.$req->search.'%');
        }
      }

      $data = $user->orderBy('created_at', 'desc')->paginate(10);

      return response()->json([...$this->ReturnDefault($req->user()->role), 'data' => $data], 200);
    }
    return response()->json(['status' => false, 'message' => 'Logout'], 401);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
      //
  }

  public function destroy(string $id, Request $req) {
    if($req->user()->role == 2) {
      User::find($id)->delete();
      return response()->json([...$this->ReturnDefault($req->user()->role)], 200);
    }

    return response()->json(['status' => false, 'message' => 'Logout'], 401);
  }
}
