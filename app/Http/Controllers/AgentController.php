<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AgentController extends Controller
{
    /** NOTE
     * Testing Purposes
     * n/a
     * **/
    public function index(Request $req) : JsonResponse {
        // SECTION AGENT & STAFF
        if($req->user()->hasRole('admin') || $req->user()->hasRole('staff')) {

        return response()->json([
            ...$this->G_ReturnDefault(),
                'data' => User::role('agent')->get()
            ]);
        }

        return $this->G_UnauthorizedResponse();
    }
}
