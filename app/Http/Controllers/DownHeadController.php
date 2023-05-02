<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DownHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req) {
      // SECTION AGENT
      if($req->user()->role == 4) {
        $data = User::with([
            'plan',
            'person',
            'pay_type',
          ])
          ->where('created_at', '>=', $req->start)
          ->where('created_at', '<=', $req->end)
          ->withSum('client_transactions', 'amount')
          ->whereHas('person', function($q) use($req){
            $q->where('agent_id', $req->user()->id)
              ->where('lastName', 'LIKE', '%'.$req->search.'%');
          })
          ->get();
        return response()->json([...$this->G_ReturnDefault(), 'data' => $data]);
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
