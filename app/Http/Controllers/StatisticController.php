<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Info;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    // SECTION INDEX
    public function index(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminIndex($req);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffIndex($req);
        }
        else if($req->user()->hasRole('agent')) {
            return $this->AgentIndex($req);
        }
        else if($req->user()->hasRole('client')) {
            return $this->ClientIndex($req);
        }

        return $this->G_UnauthorizedResponse();
    }
        // DONE
        private function ClientIndex(Request $req) : JsonResponse {
            // return response()->json(['_test', $req->user()->id]);
            // return response()->json(['_test' => Transaction::where('client_id', $req->user()->id)->get()]);

            if(Transaction::where('client_id', $req->user()->id)->count() > 0) {
                $start = Carbon::parse(
                    Transaction::where('client_id', $req->user()->id)
                        ->orderBy('created_at', 'ASC')
                        ->first()
                        ->created_at
                )->startOfYear()->format('Ym');

                $summaryTransaction = [];
                $count = 0;
                while(Carbon::now()->subMonths($count)->format('Ym') >= $start) {
                    $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')] [] = [
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

                return response()->json([...$this->G_ReturnDefault($req), 'data' => $summaryTransaction]);
            }
            else {
                return response()->json([...$this->G_ReturnDefault($req), 'data' => null]);
            }

        }

        private function AgentIndex(Request $req) : JsonResponse {
            return response()->json([
            ...$this->G_ReturnDefault($req),
            'data' => [
                'clients' => User::where('agent_id', $req->user()->id)->count(),
            ]
            ]);
        }

        // DONE
        private function StaffIndex(Request $req) : JsonResponse {
            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => [
                    'deceased' => [
                        'current' => User::where('created_at', '>=', Carbon::now()->startOfMonth())
                            ->where('created_at', '<=', Carbon::now()->endOfMonth())->role(['deceased', 'claimed'])->count(),
                        'total'   => User::role(['deceased', 'claimed'])->count(),
                    ],
                    'transactions' => [
                        'current' => Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->sum('amount'),
                        'total'   => Transaction::sum('amount')
                    ],
                    'clients' => [
                        'current' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->role('client')->count(),
                        'total'   => User::role('client')->count(),
                    ],
                    'total' => [
                        'current' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->role('client')->role('client')->count(),
                        'total'   => User::role('client')->count(),
                    ],
                    'agents' => [
                        'current' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->role('agent')->count(),
                        'total'   => User::role('agent')->count(),
                    ],
                    'beneficiaries' => [
                        'current' => Beneficiary::where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->count(),
                        'total'  => Beneficiary::count(),
                    ]

                ]
            ]);
        }

        private function AdminIndex(Request $req) : JsonResponse {
            $userCount = User::count();

            $monthlyIncome = Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
                ->where('created_at', '<=', Carbon::now())
                ->sum('amount');

            $newUsers = User::where('created_at', '>=', Carbon::now()->startOfMonth())
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get();

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => [
                    'userList' => $this->GetUserList(),

                    'newUsers' => $newUsers,
                    'semiAnnualTotalIncome' => $this->GetSemiAnnualTotalIncome(),
                    'annualIncome' => $this->GetAnnualIncome(),
                    'currentSemiAnnual' => $this->GetSemiAnnualIncome(),
                    'pastSemiAnnual' => $this->GetSemiAnnualIncome('past'),

                    'topPerformer' => $this->GetTopPerformer(),
                    'usersCount' => $userCount,
                    'transactionCount' => $monthlyIncome,
                ]
            ], 200);
        }

                // SECTION FUNCTIONS
            private function GetUserList() : array {
                $grace = Info::whereNotNull('due_at')->where('due_at', '<=', Carbon::now())->count();
                $overdue = Info::whereNotNull('due_at')->where('due_at', '<=', Carbon::now()->subMonth(2))->count();

                $data = [
                    [
                        'id' => 7,
                        'icon' => 'fa-user-friends',
                        'color' => 'orange',
                        'name' => 'Beneficiaries',
                        'count' => Beneficiary::count(),
                    ],
                    [
                        'id' => 6,
                        'icon' => 'fa-child',
                        'color' => 'success',
                        'name' => 'Client',
                        'count' => User::hasRole('client')->count(),
                    ],
                    [
                        'id' => 5,
                        'icon' => 'fa-user-edit',
                        'color' => 'info',
                        'name' => 'Staff',
                        'count' => User::hasRole('staff')->count(),
                    ],
                    [
                        'id' => 4,
                        'icon' => 'fa-handshake',
                        'color' => 'purple',
                        'name' => 'Agent',
                        'count' => User::hasRole('agent')->count(),
                    ],
                    [
                        'id' => 3,
                        'icon' => 'fa-crown',
                        'color' => 'warning',
                        'name' => 'Admin',
                        'count' => User::hasRole('admin')->count(),
                    ],
                    [
                        'id' => 2,
                        'icon' => 'fa-check-circle',
                        'color' => 'secondary',
                        'name' => 'Claimed',
                        'count' => User::hasRole('collected')->count(),
                    ],
                    [
                        'id' => 1,
                        'icon' => 'fa-calendar',
                        'color' => 'warning',
                        'name' => 'Grace',
                        'count' => $grace - $overdue,
                    ],
                    [
                        'id' => 1,
                        'icon' => 'fa-calendar-times',
                        'color' => 'danger',
                        'name' => 'Overdue',
                        'count' => $overdue,
                    ],
                ];

                return $data;
            }

            private function GetSemiAnnualIncome(bool $past = false) {
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

            private function GetSemiAnnualTotalIncome() {
                return [
                    'current' => Transaction::where('created_at', '<=', Carbon::now()->endOfMonth())
                        ->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(6))->sum('amount'),
                    'past' => Transaction::where('created_at', '<=', Carbon::now()->endOfMonth()->subYears(1))
                        ->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonths(6)->subYears(1))->sum('amount'),
                ];
            }

            private function GetAnnualIncome() {
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

            private function GetTopPerformer() {
                $data = Info::select(DB::raw('SUM(transactions.amount) AS total'))
                    ->join('transactions', 'transactions.agent_id', '=', 'infos.id')
                    ->join('users', 'users.id', '=', 'infos.user_id')
                    ->where('users.role', 4)
                    ->groupBy('name')
                    ->orderBy('total')
                    ->limit(4)
                    ->get();

                return $data;
            }
}
