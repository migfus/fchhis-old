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
      return 'test';
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
      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => Transaction::with([
            'client.person',
            'staff.person',
            'agent.person',
            'plan',
            'pay_type'
          ])
          ->orderBy('created_at', 'DESC')
          ->paginate(10),
      ]);
    }

    return $this->G_UnauthorizedResponse();
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
      $val = Validator::make($req->all(), [
        'agent.person.id' => 'required',
        'client.person.id' => 'required',
        'amount' => 'required',
        'or' => 'required',
        'pay_type_id' => 'required',
        'plan.id' => 'required',
      ]);

      if($val->fails()) {
        return $this->G_ValidatorFailResponse($val);
      }

      if($req->user()->role == 5) {
        // return $req->client['person']['id'];

        Transaction::create([
          'agent_id' => $req->agent['person']['id'],
          'staff_id' => $req->user()->id,
          'client_id' => $req->client['person']['id'],
          'pay_type_id' => $req->pay_type_id,
          'plan_id' => $req->plan['id'],
          'amount' => $req->amount,
        ]);

        return response()->json([...$this->G_ReturnDefault($req), 'data' => true]);
      }

      return $this->G_UnauthorizedResponse();
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
