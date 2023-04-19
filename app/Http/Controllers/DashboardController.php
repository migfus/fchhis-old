<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
  private function RolesData() {
    $data = [
      [
        'id' => 6,
        'icon' => 'fa-child',
        'color' => 'success',
        'name' => 'Client',
        'count' => User::where('role', 6)->count(),
      ],
      [
        'id' => 5,
        'icon' => 'fa-user-edit',
        'color' => 'info',
        'name' => 'Staff',
        'count' => User::where('role', 5)->count(),
      ],
      [
        'id' => 4,
        'icon' => 'fa-handshake',
        'color' => 'purple',
        'name' => 'Agent',
        'count' => User::where('role', 4)->count(),
      ],
      [
        'id' => 3,
        'icon' => 'fa-tasks',
        'color' => 'orange',
        'name' => 'Manager',
        'count' => User::where('role', 3)->count(),
      ],
      [
        'id' => 2,
        'icon' => 'fa-crown',
        'color' => 'warning',
        'name' => 'Admin',
        'count' => User::where('role', 2)->count(),
      ],
      [
        'id' => 1,
        'icon' => 'fa-ban',
        'color' => 'danger',
        'name' => 'Banned',
        'count' => User::where('role', 1)->count(),
      ],
      [
        'id' => 0,
        'icon' => 'fa-moon',
        'color' => 'secondary',
        'name' => 'Inactive',
        'count' => User::where('role', 0)->count(),
      ],
    ];

    return $data;
  }

  public function index(Request $req)
  {
    if($req->user()->role == 2) {
      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => [
          'usersCount' => User::count(),
          'transactionCount' => 10000,
          'newUsers' => User::orderBy('id', 'DESC')->limit(5)->get(),
          'rolesChart' => $this->RolesData(),
        ]
      ], 200);
    }

    return $this->G_UnauthorizedResponse();
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
