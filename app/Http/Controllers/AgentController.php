<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AgentController extends Controller
{
  public function index(Request $req){
    // SECTION AGENT & STAFF
    if($req->user()->role == 2 || $req->user()->role == 5) {

      return response()->json([
        ...$this->G_ReturnDefault(),
        'data' => User::where('role', 4)
          ->with([
            'person' => function ($q) {
              $q->orderBy('lastName', 'DESC');
            }
          ])
          ->get()
      ]);
    }

    return $this->G_UnauthorizedResponse();
  }
}
