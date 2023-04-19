<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
  public function index(Request $req) {
    if($req->user()->role == 2) {
      $data = [
        [
          'id' => 6,
          'icon' => 'fa-child',
          'color' => 'success',
          'name' => 'Client',
          'count' => User::where('role', 6)->count(),
          'top' => User::where('role', 6)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
        [
          'id' => 5,
          'icon' => 'fa-user-edit',
          'color' => 'info',
          'name' => 'Staff',
          'count' => User::where('role', 5)->count(),
          'top' => User::where('role', 5)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
        [
          'id' => 4,
          'icon' => 'fa-handshake',
          'color' => 'purple',
          'name' => 'Agent',
          'count' => User::where('role', 4)->count(),
          'top' => User::where('role', 4)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
        [
          'id' => 3,
          'icon' => 'fa-tasks',
          'color' => 'orange',
          'name' => 'Manager',
          'count' => User::where('role', 3)->count(),
          'top' => User::where('role', 3)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
        [
          'id' => 2,
          'icon' => 'fa-crown',
          'color' => 'warning',
          'name' => 'Admin',
          'count' => User::where('role', 2)->count(),
          'top' => User::where('role', 2)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
        [
          'id' => 1,
          'icon' => 'fa-ban',
          'color' => 'danger',
          'name' => 'Banned',
          'count' => User::where('role', 1)->count(),
          'top' => User::where('role', 1)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
        [
          'id' => 0,
          'icon' => 'fa-moon',
          'color' => 'secondary',
          'name' => 'Inactive',
          'count' => User::where('role', 0)->count(),
          'top' => User::where('role', 0)->orderBy('id', 'DESC')->limit(5)->get(),
        ],
      ];

      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
    }
    return $this->G_UnauthorizedResponse();
  }
}
