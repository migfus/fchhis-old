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
      'search' => ''
    ]);

    if($val->fails()) {
      return $this->ValidateErrorResponse();
    }

    if($req->user()->role == 2) {
      $data;
      if($req->role < 7) {
        $data = User::where('role', $req->role)->where('email', 'LIKE', '%'.$req->search.'%')
          ->orderBy('created_at', 'desc')->paginate(10);
      }
      else {
        $data = User::orderBy('created_at', 'desc')->where('email', 'LIKE', '%'.$req->search.'%')->paginate(10);
      }
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
