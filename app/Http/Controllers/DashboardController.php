<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Beneficiary;

// DEBUG REORGANIZE BY ROLE for CONSISTENCY FOR OTHER CONTROLLERS
class DashboardController extends Controller
{
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
            return User::with(['info'])
                ->withSum('agent_transactions', 'amount')
                ->withCount('agent_transactions')
                ->orderBy('agent_transactions_sum_amount', 'DESC')
                ->limit(6)
                ->get();
        }

    public function index(Request $req) {
        // NOTE ADMIN
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

        // NOTE AGENT
        if($req->user()->role == 4) {
            return $this->Agent($req);
        }

        // NOTE STAFF
        if($req->user()->role == 5) {
            return $this->Staff($req);
        }

        // NOTE CLIENT
        if($req->user()->role == 6) {
            return $this->Client($req);
        }

        return $this->G_UnauthorizedResponse();
    }

    public function Agent(Request $req) {
        $transactions = Transaction::where('client_id', $req->user()->id)
            ->with(['client.info', 'staff.info', 'plan', 'pay_type'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $start = Carbon::parse(Transaction::where('client_id', $req->user()->id)->orderBy('created_at', 'ASC')->first()->created_at)->startOfYear()->format('Ym');

        $summaryTransaction = [];
        $count = 0;
        while(Carbon::now()->subMonths($count)->format('Ym') >= $start) {
            $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')] [] = [
                Carbon::now()->subMonths($count)->startOfMonth(),
                Transaction::where('client_id', $req->user()->id)
                    ->where('created_at', '>=', Carbon::now()->subMonths($count)->startOfMonth())
                    ->where('created_at', '<=', Carbon::now()->subMonths($count)->endOfMonth())
                    ->sum('amount'),
                ];
            $count++;
        }


        // NOTE AGENT PART
        $clients = User::with('info')->paginate(10);
        $tansCurrent = User::with('info')
            ->whereHas('info', function($q) use($req) { $q->where('agent_id', $req->user()->id); } )
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->where('created_at', '<=', Carbon::now()->endOfMonth())
            ->count();
        $transPast = User::with('info')
            ->whereHas('info', function($q) use($req) { $q->where('agent_id', $req->user()->id); } )
            ->where('created_at', '>=', Carbon::now()->subMonths(1)->startOfMonth())
            ->where('created_at', '<=', Carbon::now()->subMonths(1)->endOfMonth())
            ->count();

        return response()->json([
        ...$this->G_ReturnDefault($req),
            'data' => [
                'transactions' => $transactions,
                'summaryTransaction' => $summaryTransaction,
                'sumTransactions' => Transaction::where('client_id', $req->user()->id)->sum('amount'),
                'agent' => [
                    'transactions' => '',
                    'clients' => $clients,
                ],
                'counts' => [
                    'clients' => User::with(['info'])
                        ->whereHas('info', function($q) use($req) { $q->where('agent_id', $req->user()->id); })->count(),
                    'transactions' => Transaction::where('agent_id', $req->user()->id)->count(),
                    'inactive' => User::whereNotNull('OR')->whereNull('email')->count(),
                    'current' => (($tansCurrent OR 1/ $transPast OR 1) * 100)
                ]
            ]
        ]);
    }

    public function Client(Request $req) {
        $transactions = Transaction::where('client_id', $req->user()->id)
            ->with(['client.info', 'staff.info', 'plan', 'pay_type'])
            ->orderBy('created_at', 'DESC')
            ->get();

        // return Transaction::where('client_id', $req->user()->id)->get();
        $start = Carbon::parse(Transaction::where('client_id', $req->user()->id)->orderBy('created_at', 'ASC')->first()->created_at)->startOfYear()->format('Ym');

        $summaryTransaction = [];
        $count = 0;
        while(Carbon::now()->subMonths($count)->format('Ym') >= $start) {
            $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')] []= [
                Carbon::now()->subMonths($count)->startOfMonth(),
                Transaction::where('client_id', $req->user()->id)
                    ->where('created_at', '>=', Carbon::now()->subMonths($count)->startOfMonth())
                    ->where('created_at', '<=', Carbon::now()->subMonths($count)->endOfMonth())
                    // ->orderBy('created_at', 'DESC')
                    ->sum('amount'),
                ];
            // $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')]
            $count++;
        }





        return response()->json([
            ...$this->G_ReturnDefault($req),
            'data' => [
                'transactions' => $transactions,
                'summaryTransaction' => $summaryTransaction,
                'sumTransactions' => Transaction::where('client_id', $req->user()->id)->sum('amount'),
            ]
        ]);
    }

        private function Staff(Request $req) {
            $data = [
                'total' => User::where('role', 6)->count(),
                'clients' => User::where('role', 6)
                    ->whereHas('info', function($q) use($req){
                        $q->where('staff_id', $req->user()->id);
                    })
                    ->count(),
                'inactive' => 0
            ];

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }
}
