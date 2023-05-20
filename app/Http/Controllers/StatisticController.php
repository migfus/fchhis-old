<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Person;

class StatisticController extends Controller
{
  // SECTION INDEX
  public function index(Request $req) {
    switch($req->user()->role) {
      case 4:
        return $this->AgentIndex($req);
      case 5:
        return $this->StaffIndex($req);
      case 6:
        return $this->CientIndex($req);
      default:
        return $this->G_UnauthorizedResponse();
    }
  }

  private function ClientIndex($req) {
    $start = Carbon::parse(
      Transaction::where('client_id', $req->user()->person->id)
        ->orderBy('created_at', 'ASC')
        ->first()
        ->created_at
    )->startOfYear()->format('Ym');

    $summaryTransaction = [];
    $count = 0;
    while(Carbon::now()->subMonths($count)->format('Ym') >= $start) {
      $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')] []= [
          Carbon::now()->subMonths($count)->startOfMonth(),
        Transaction::where('client_id', $req->user()->person->id)
          ->where('created_at', '>=', Carbon::now()->subMonths($count)->startOfMonth())
          ->where('created_at', '<=', Carbon::now()->subMonths($count)->endOfMonth())
          // ->orderBy('created_at', 'DESC')
            ->sum('amount'),
        ];
      // $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')]
      $count++;
    }

    return response()->json([...$this->G_ReturnDefault($req), 'data' => $summaryTransaction]);
  }

  private function AgentIndex($req) {
    return response()->json([
      ...$this->G_ReturnDefault($req),
      'data' => [
        'clients' => Person::where('agent_id', $req->user()->person->id)->count(),
      ]
    ]);
  }

  private function StaffIndex($req) {

    return response()->json([
      ...$this->G_ReturnDefault($req),
      'data' => [
        'deceased' => Person::whereNotNull('fulfilled_at')->count(),
        'transactions' => Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
          ->where('created_at', '<=', Carbon::now()->endOfMonth())
          ->sum('amount'),
        'clients' => Person::with(['user'])
          ->where('created_at', '>=', Carbon::now()->startOfMonth())
          ->where('created_at', '<=', Carbon::now()->endOfMonth())
          ->whereHas('user', function($q) {
            $q->where('role', 6);
          })
          ->count(),
        'total' => Person::with(['user'])
          ->whereHas('user', function($q) {
            $q->where('role', 6);
          })
          ->count(),
        'agents' => Person::with(['user'])
          ->whereHas('user', function($q) {
            $q->where('role', 4);
          })
          ->count(),
        'beneficiaries' => Person::with(['user'])
          ->whereNotNull('client_id')
          ->count(),
      ]
    ]);
  }
}
