<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;

class RoleController extends Controller
{
  public function index(Request $req) {
    if($req->user()->role == 2) {
      $data = [
        [
          'id' => 7,
          'icon' => 'fa-user-friends',
          'color' => 'success',
          'name' => 'Beneficiaries',
          'count' => Person::with('user')->whereNotNull('client_id')->count(),
          'top' => Person::with('user')
            ->whereNotNull('client_id')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get(),
        ],
        [
          'id' => 6,
          'icon' => 'fa-child',
          'color' => 'success',
          'name' => 'Client',
          'count' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 6);
            })
            ->count(),
          'top' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 6);
            })
            ->orderBy('created_at', 'DESC')
            ->get(),
        ],
        [
          'id' => 5,
          'icon' => 'fa-user-edit',
          'color' => 'info',
          'name' => 'Staff',
          'count' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 5);
            })
            ->count(),
          'top' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 5);
            })
            ->orderBy('created_at', 'DESC')
            ->get(),
        ],
        [
          'id' => 4,
          'icon' => 'fa-handshake',
          'color' => 'purple',
          'name' => 'Agent',
          'count' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 4);
            })
            ->count(),
          'top' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 4);
            })
            ->orderBy('created_at', 'DESC')
            ->get(),
        ],
        [
          'id' => 2,
          'icon' => 'fa-crown',
          'color' => 'warning',
          'name' => 'Admin',
          'count' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 2);
            })
            ->count(),
          'top' => Person::with('user')
            ->whereHas('user', function($q) {
              $q->where('role', 2);
            })
            ->orderBy('created_at', 'DESC')
            ->get(),
        ],
      ];

      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
    }
    return $this->G_UnauthorizedResponse();
  }
}
