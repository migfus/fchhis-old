<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Http\JsonResponse;

// DEBUG REORGANIZE BY ROLE for CONSISTENCY FOR OTHER CONTROLLERS
class DashboardController extends Controller
{
    public function index(Request $req) : JsonResponse {
        // NOTE ADMIN
        if($req->user()->haRole('admin') == 2) {
            return $this->AdminIndex($req);
        }
        else if ($req->user()->hasRole('agent')) {
            return $this->AgentIndex($req);
        }
        else if ($req->user()->hasRole('staff')) {
            return $this->StaffIndex($req);
        }
        else if ($req->user()->hasRole('client')) {
            return $this->ClientIndex($req);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function AdminIndex(Request $req) : JsonResponse {
            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => [
                    'usersCount' => User::count(),
                    'transactionCount' => $this->GetMonthlyIncome(),
                    'newUsers' => User::orderBy('id', 'DESC')->limit(5)->get(),
                    'rolesChart' => $this->RolesData(),
                    'currentSemiAnnual' => $this->GetSemiAnnualIncome(),
                    'pastSemiAnnual' => $this->GetSemiAnnualIncome('past'),
                    'semiAnnualTotalIncome' => $this->GetSemiAnnualTotalIncome(),
                    'annualIncome' => $this->GetAnnualIncome(),
                    'topPerformer' => $this->TopPerformer(),
                ]
            ], 200);
        }

            private function GetMonthlyIncome() : number {
                return Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
                    ->where('created_at', '<=', Carbon::now())
                    ->sum('amount');
            }

            private function GetSemiAnnualIncome(bool $past = false) : array {
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

            private function GetSemiAnnualTotalIncome() : object {
                return [
                    'current' => Transaction::where('created_at', '<=', Carbon::now()->endOfMonth())
                    ->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(6))->sum('amount'),
                    'past' => Transaction::where('created_at', '<=', Carbon::now()->endOfMonth()->subYears(1))
                    ->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(6)->subYears(1))->sum('amount'),
                ];
            }

            private function GetAnnualIncome() : array {
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

            private function GetTopPerformer() : array {
                return User::with(['info'])
                    ->withSum('agent_transactions', 'amount')
                    ->withCount('agent_transactions')
                    ->orderBy('agent_transactions_sum_amount', 'DESC')
                    ->limit(6)
                    ->get();
            }

        private function AgentIndex(Request $req) : JsonResponse {
            $transactions = Transaction::where('client_id', $req->user()->id)
                ->with(['client.info', 'staff', 'plan', 'pay_type'])
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

        private function StaffIndex(Request $req) : JsonResponse {
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

        private function ClientIndex(Request $req) : JsonResponse {
            $transactions = Transaction::where('client_id', $req->user()->id)
                ->with(['client.info', 'staff', 'plan', 'pay_type'])
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
}
