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
      'search' => '',
      'start' => '',
      'end' => '',
      'filter' => '',
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
      $trans = Transaction::select('*');

      if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
        if((bool)strtotime($req->start)) {
          $trans->where('created_at', '>=', $req->start);
        }
        if((bool)strtotime($req->end)) {
          $trans->where('created_at', '<=', $req->end);
        }
      }

      $trans->with([
        'client.person',
        'staff.person',
        'agent.person',
        'plan',
        'pay_type'
      ]);

      switch($req->filter) {
        case 'email':
          $trans->whereHas('client', function($q) use($req) {
            $q->where('email', 'LIKE', '%'.$req->search.'%');
          });
          break;
        case 'address':
          $trans->whereHas('client.person', function($q) use($req) {
            $q->where('address', 'LIKE', '%'.$req->search.'%');
          });
          break;
        case 'plans':
          $trans->whereHas('plan', function($q) use($req) {
            $q->where('name', 'LIKE', '%'.$req->search.'%');
          });
          break;
        default:
          $trans->whereHas('client.person', function($q) use($req) {
            $q->where('lastName', 'LIKE', '%'.$req->search.'%')
              ->orWhere('firstName', 'LIKE', '%'.$req->search.'%');
          });
      }

      $data = $trans->orderBy('created_at', 'DESC')
      ->paginate(10);

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data,
      ]);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function store(Request $req) {
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

  public function update(Request $req, string $id) {
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

      Transaction::where('id', $id)
        ->where('staff_id', $req->user()->id)
        ->update([
          'agent_id' => $req->agent['person']['id'],
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
