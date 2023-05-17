<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
  public function index(Request $req) {
    $val = Validator::make($req->all(), [
      'limit' => 'required|numeric|min:1|max:10',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if($req->user()->role == 5) {
      $data = User::limit($req->limit)
        ->with([
          'person.agent.person',
          'person.staff.person',
          'plan',
        ])
        ->withSum('client_transactions', 'amount')
        ->orderBy('created_at', 'DESC')
        ->get();
      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
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
