<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

  public function index(Request $req) {
    // SECTION VALIDATION
    $val = Validator::make($req->all(), [
      'limit' => 'required|numeric|min:1|max:10',
      'search' => ''
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    // SECTION ADMIN
    if($req->user()->role == 2) {
      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => Transaction::with(['client.person', 'staff.person', 'agent.person', 'plan'])->paginate(10),
      ]);
    }

    // SECTION AGENT
    if($req->user()->role == 4) {
      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => Transaction::with(['client.person', 'staff.person', 'agent.person', 'plan', 'pay_type'])
          ->where('created_at', '>=', $req->start)
          ->where('created_at', '<=', $req->end)
          ->where('agent_id', $req->user()->id)
          ->whereHas('client.person', function($q) use($req) {
            $q->where('lastName', 'LIKE', '%'.$req->search.'%');
          })
          ->orderBy('created_at', 'DESC')
          ->paginate($req->limit),
      ]);
    }

    // SECTION STAFF
    if($req->user()->role == 5) {
      $data = Transaction::with(['plan', 'client.person'])
        ->limit($req->limit)
        ->orderBy('created_at', 'DESC')
        ->get();

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data
      ]);
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
