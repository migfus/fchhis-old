<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
  private function RolesData() {
    $data = [
      [
        'id' => 6,
        'icon' => 'fa-child',
        'color' => 'success',
        'name' => 'Client',
        'count' => User::where('role', 6)->count(),
      ],
      [
        'id' => 5,
        'icon' => 'fa-user-edit',
        'color' => 'info',
        'name' => 'Staff',
        'count' => User::where('role', 5)->count(),
      ],
      [
        'id' => 4,
        'icon' => 'fa-handshake',
        'color' => 'purple',
        'name' => 'Agent',
        'count' => User::where('role', 4)->count(),
      ],
      [
        'id' => 3,
        'icon' => 'fa-tasks',
        'color' => 'orange',
        'name' => 'Manager',
        'count' => User::where('role', 3)->count(),
      ],
      [
        'id' => 2,
        'icon' => 'fa-crown',
        'color' => 'warning',
        'name' => 'Admin',
        'count' => User::where('role', 2)->count(),
      ],
      [
        'id' => 1,
        'icon' => 'fa-ban',
        'color' => 'danger',
        'name' => 'Banned',
        'count' => User::where('role', 1)->count(),
      ],
      [
        'id' => 0,
        'icon' => 'fa-moon',
        'color' => 'secondary',
        'name' => 'Inactive',
        'count' => User::where('role', 0)->count(),
      ],
    ];

    return $data;
  }

  private function MonthlyIncome() {
    return Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
      ->where('created_at', '<=', Carbon::now())
      ->sum('amount');
  }

  private function SemiAnnualIncome($past = false) {
    $data = [];
    for($i = 0; $i < 6; $i++) {
      if($past) {
        $data[] = [
          'date' => Carbon::now()->subMonths($i)->subYears(1)->format('F'),
          'amount' => Transaction::where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths($i)->subYears(1))
            ->where('created_at', '<=', Carbon::now()->endOfMonth()->subMonths($i)->subYears(1))
            ->sum('amount'),
        ];
      }
      else {
        $data[] = [
          'date' => Carbon::now()->subMonths($i)->format('F'),
          'amount' => Transaction::where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths($i))
            ->where('created_at', '<=', Carbon::now()->endOfMonth()->subMonths($i))
            ->sum('amount'),
        ];
      }
    }
    return $data;
  }

  private function SemiAnnualTotalIncome() {
    return [
      'current' => Transaction::where('created_at', '<=', Carbon::now()->endOfMonth())
      ->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(6))->sum('amount'),
      'past' => Transaction::where('created_at', '<=', Carbon::now()->endOfMonth()->subYears(1))
      ->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(6)->subYears(1))->sum('amount'),
    ];
  }

  private function AnnualIncome() {
    for($i = 0; $i < 12; $i++) {
      $data[] = [
        'date' => Carbon::now()->subMonths($i)->format('F'),
        'amount' => Transaction::where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths($i))
          ->where('created_at', '<=', Carbon::now()->endOfMonth()->subMonths($i))
          ->sum('amount'),
      ];
    }
    return $data;
  }

  private function TopPerformer() {
    return User::with(['person'])
      ->withSum('agent_transactions', 'amount')
      ->withCount('agent_transactions')
      ->orderBy('agent_transactions_sum_amount', 'DESC')
      ->limit(6)
      ->get();
  }

  public function index(Request $req)
  {
    if($req->user()->role == 2) {
      return response()->json([
        ...$this->G_ReturnDefault($req),
        'data' => [
          'usersCount' => User::count(),
          'transactionCount' => $this->MonthlyIncome(),
          'newUsers' => User::orderBy('id', 'DESC')->limit(5)->get(),
          'rolesChart' => $this->RolesData(),
          'currentSemiAnnual' => $this->SemiAnnualIncome(),
          'pastSemiAnnual' => $this->SemiAnnualIncome('past'),
          'semiAnnualTotalIncome' => $this->SemiAnnualTotalIncome(),
          'annualIncome' => $this->AnnualIncome(),
          'topPerformer' => $this->TopPerformer(),
        ]
      ], 200);
    }

    if($req->user()->role == 6) {
      return response()->json(['test' => 'test']);
    }

    return $this->G_UnauthorizedResponse();
  }
}
