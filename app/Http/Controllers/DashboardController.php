<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
  private function returnDefault($role) {
    return ['status' => true, 'message' => 'success', 'role' => $role];
  }

  public function index(Request $req)
  {
    if($req->user()->role) {
      return response()->json([...$this->returnDefault($req->user()->role), 'users' => User::count()], 200);
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

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }
}
