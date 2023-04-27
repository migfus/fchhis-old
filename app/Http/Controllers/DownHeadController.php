<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class DownHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req) {
      if($req->user()->role == 4) {
        $data = Person::where('agent_id', $req->user()->id)
          ->where(function($q) use($req){
            $q->where('lastName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('firstName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('midName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('extName', 'LIKE', '%'.$req->search.'%');
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
