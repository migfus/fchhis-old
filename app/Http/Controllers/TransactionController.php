<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
{
  // SECTION INDEX
  public function index(Request $req) {
    switch($req->user()->role) {
      case 4:
        return $this->AgentIndex($req);
      case 5:
        if($req->id)
          return $this->StaffIDIndex($req);
        if($req->print)
          return $this->StaffPrintIndex($req);

        return $this->StaffIndex($req);
      case 6:
        return $this->ClientIndex($req);
      default:
        return $this->G_UnauthorizedResponse();
    }
  }

  private function ClientIndex($req) {
    $val = Validator::make($req->all(), [
      'search' => '',
      'sort' => 'required'
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $data = Transaction::where('client_id', $req->user()->person->id)
      ->with(['plan', 'pay_type', 'client', 'staff'])
      ->whereHas('plan', function($q) use($req) {
        $q->where('name', 'LIKE', '%' . $req->search. '%');
      })
      ->orderBy('created_at', $req->sort)
      ->paginate(10);

    $sum = Transaction::where('client_id', $req->user()->person->id)->sum('amount');

    return response()->json([
      ...$this->G_ReturnDefault($req),
      'data' => $data,
      'sum'  => $sum,
    ]);
  }

  private function AgentIndex($req) {
    $val = Validator::make($req->all(), [
      'search' => '',
      'start' => 'required',
      'end' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if($req->print) {
      $data = Transaction::where('agent_id', $req->user()->person->id)
        ->with(['plan', 'pay_type', 'client', 'staff'])
        ->where('created_at', '>=', $req->start)
        ->where('created_at', '<=', $req->end)
        ->orderBy('created_at', 'DESC')
        ->get();

      $sum = Transaction::where('agent_id', $req->user()->person->id)->sum('amount');

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data,
        'sum'  => $sum,
      ]);
    }
    else {
      $data = Transaction::where('agent_id', $req->user()->person->id)
        ->with(['plan', 'pay_type', 'client', 'staff'])
        ->whereHas('client', function($q) use($req) {
          $q->where('name', 'LIKE', '%' . $req->search. '%');
        })
        ->where('created_at', '>=', $req->start)
        ->where('created_at', '<=', $req->end)
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

      $sum = Transaction::where('agent_id', $req->user()->person->id)->sum('amount');

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data,
        'sum'  => $sum,
      ]);
    }
  }

  private function StaffIndex($req) {
    $val = Validator::make($req->all(), [
      'search' => '',
      'start' => '',
      'end' => '',
      'filter'
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $data = Transaction::select('*');

    if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
      if((bool)strtotime($req->start)) {
        $data->where('created_at', '>=', $req->start);
      }
      if((bool)strtotime($req->end)) {
        $data->where('created_at', '<=', $req->end);
      }
    }

    $data = Transaction::with([
      'plan',
      'pay_type',
      'client.user',
      'client' => function($q) {
        $q->withSum('client_transactions','amount');
      },
      'staff.user',
      'agent.user'
    ]);

    switch($req->filter) {
      case 'or':
        $data->where('or', 'LIKE', '%' . $req->search. '%');
        break;
      case 'email':
        $data->whereHas('client.user', function($q) use($req) {
          $q->where('email', 'LIKE', '%' . $req->search. '%');
        });
        break;
      case 'address':
        $data->whereHas('client', function($q) use($req) {
          $q->where('address', 'LIKE', '%' . $req->search. '%');
        });
        break;
      case 'plans':
        $data->whereHas('plan', function($q) use($req) {
          $q->where('name', 'LIKE', '%' . $req->search. '%');
        });
        break;
      default:
        $data->whereHas('client', function($q) use($req) {
          $q->where('name', 'LIKE', '%' . $req->search. '%');
        });



      $sum = Transaction::where('agent_id', $req->user()->person->id)->sum('amount');

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data->orderBy('created_at', 'DESC')->paginate($req->limit),
        'sum'  => $sum,
      ]);
    }
  }

  private function StaffIDIndex($req) {
    $val = Validator::make($req->all(), [
      'search' => '',
      'start' => '',
      'end' => '',
      'filter'
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $data = Transaction::with([
      'plan',
      'pay_type',
      'client.user',
      'client' => function($q) {
        $q->withSum('client_transactions','amount');
      },
      'staff.user',
      'agent.user'
    ])
    ->where('client_id', $req->id)
    ->whereHas('plan', function($q) use($req) {
      $q->where('name', 'LIKE', '%' . $req->search. '%');
    })
    ->orderBy('created_at', 'DESC')
    ->paginate($req->limit);

    return response()->json([
      ...$this->G_ReturnDefault($req),
      'data' => $data,
    ]);
  }

  private function StaffPrintIndex($req) {
    $data = Transaction::select('*');

      if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
        if((bool)strtotime($req->start)) {
          $data->where('created_at', '>=', $req->start);
        }
        if((bool)strtotime($req->end)) {
          $data->where('created_at', '<=', $req->end);
        }
      }

      $data = Transaction::with([
        'plan',
        'pay_type',
        'client.user',
        'client' => function($q) {
          $q->withSum('client_transactions','amount');
        },
        'staff.user',
        'agent.user'
      ]);

      $sum = Transaction::where('agent_id', $req->user()->person->id)->sum('amount');

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data->orderBy('created_at', 'DESC')->get(),
        'sum'  => $sum,
      ]);
  }

  // SECTION STORE
  public function store(Request $req) {
    switch($req->user()->role) {
      case 5:
        return $this->StaffStore($req);
      default:
        return $this->G_UnauthorizedResponse();
    }
  }

  private function StaffStore($req) {
    $val = Validator::make($req->all(), [
      'agent.id' => 'required',
      'client.id' => 'required',
      'amount' => 'required',
      'or' => 'required',
      'pay_type_id' => 'required',
      'plan.id' => 'required',
      'or',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    Transaction::create([
      'or' => $req->or,
      'agent_id' => $req->agent['id'],
      'staff_id' => $req->user()->person->id,
      'client_id' => $req->client['id'],
      'pay_type_id' => $req->pay_type_id,
      'plan_id' => $req->plan['id'],
      'amount' => $req->amount,
    ]);

    $due = Person::where('id', $req->client['id'])->first()->due_at;

    switch($req->pay_type_id) {
      case 2:
        $due = Carbon::create($due)->addMonth(3);
      case 3:
        $due = Carbon::create($due)->addMonth(6);
      case 4:
        $due = Carbon::create($due)->addMonth(12);
      case 5:
        $due = null;
      case 6:
        $due = null;
      default:
        $due = Carbon::create($due)->addMonth(1);
    }

    Person::where('id', $req->client['id'])->update(['due_at' => $due]);

    return response()->json([...$this->G_ReturnDefault($req), 'data' => true]);

  }

  // SECTION UPDATE
  public function update(Request $req, string $id) {
    switch($req->user()->role) {
      case 5:
        return $this->StaffUpdate($req, $id);
      default:
        return $this->G_UnauthorizedResponse();
    }
  }

  private function StaffUpdate($req, $id){
    $val = Validator::make($req->all(), [
      'agent.id' => 'required',
      'client.id' => 'required',
      'amount' => 'required',
      'or' => 'required',
      'pay_type_id' => 'required',
      'plan.id' => 'required',
      'or'
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    Transaction::where('id', $id)
      ->where('staff_id', $req->user()->person->id)
      ->update([
        'or' => $req->or,
        'agent_id' => $req->agent['id'],
        'client_id' => $req->client['id'],
        'pay_type_id' => $req->pay_type_id,
        'plan_id' => $req->plan['id'],
        'amount' => $req->amount,
    ]);

    return response()->json([...$this->G_ReturnDefault($req), 'data' => true]);
  }



  // SECTION OTHERS


  public function show(string $id) {
      //
  }

  public function destroy(string $id) {
      //
  }

  private function Print($req) {
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
        'client' => function ($q) {
          $q->withSum('client_transactions', 'amount');
        },
        'staff.person',
        'agent.person',
        'plan',
        'pay_type'
      ]);

      $data = $trans->orderBy('created_at', 'DESC')->get();

      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => $data,
      ]);
    }

    return $this->G_UnauthorizedResponse();
  }
}
