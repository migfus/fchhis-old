<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;

class StatisticController extends Controller
{
  // SECTION INDEX
  public function index(Request $req) {
    switch($req->user()->role) {
      default:
      return $this->Client($req);
    }

    return $this->G_UnauthorizedResponse();
  }

  private function Client($req) {
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
}
