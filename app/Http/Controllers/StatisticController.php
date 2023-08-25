<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Info;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    // SECTION INDEX
    public function index(Request $req) {
        switch($req->user()->role) {
        case 2:
            return $this->AdminIndex($req);
        case 4:
            return $this->AgentIndex($req);
        case 5:
            return $this->StaffIndex($req);
        case 6:
            return $this->ClientIndex($req);
        default:
            return $this->G_UnauthorizedResponse();
        }
    }
        // NOTE DONE
        private function ClientIndex($req) {
            $start = Carbon::parse(
                Transaction::where('client_id', $req->user()->info->id)
                    ->orderBy('created_at', 'ASC')
                    ->first()
                    ->created_at
            )->startOfYear()->format('Ym');

            $summaryTransaction = [];
            $count = 0;
            while(Carbon::now()->subMonths($count)->format('Ym') >= $start) {
                $summaryTransaction [Carbon::now()->subMonths($count)->format('Y')] [] = [
                    Carbon::now()->subMonths($count)->startOfMonth(),
                    Transaction::where('client_id', $req->user()->info->id)
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
                'clients' => User::where('agent_id', $req->user()->info->id)->count(),
            ]
            ]);
        }

        // NOTE PROGRESS
        private function StaffIndex($req) {

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => [
                    'deceased' => User::role(['deceased', 'claimed'])->count(),
                    'transactions' => Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
                        ->where('created_at', '<=', Carbon::now()->endOfMonth())
                        ->sum('amount'),
                    'clients' => User::with(['info'])
                        ->where('created_at', '>=', Carbon::now()->startOfMonth())
                        ->where('created_at', '<=', Carbon::now()->endOfMonth())
                        ->role('client')
                        // ->whereHas('user', function($q) {
                        //     $q->where('role', 6);
                        // })
                        ->count(),
                    'total' => User::with(['info'])
                        ->role('client')
                        // ->whereHas('user', function($q) {
                        //     $q->where('role', 6);
                        // })
                        ->count(),
                    'agents' => User::with(['info'])
                        ->role('agent')
                        // ->whereHas('user', function($q) {
                        //     $q->where('role', 4);
                        // })
                        ->count(),
                    'beneficiaries' => Beneficiary::count(),
                ]
            ]);
        }

        private function AdminIndex($req) {
            $userCount = Info::whereNull('client_id')->count();

            $monthlyIncome = Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
                ->where('created_at', '<=', Carbon::now())
                ->sum('amount');

            $newUsers = Info::with('user')
                ->whereNull('client_id')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get();

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => [
                    'userList' => $this->UserList(),

                    'newUsers' => $newUsers,
                    'semiAnnualTotalIncome' => $this->SemiAnnualTotalIncome(),
                    'annualIncome' => $this->AnnualIncome(),
                    'currentSemiAnnual' => $this->SemiAnnualIncome(),
                    'pastSemiAnnual' => $this->SemiAnnualIncome('past'),

                    'topPerformer' => $this->TopPerformer(),
                    'usersCount' => $userCount,
                    'transactionCount' => $monthlyIncome,
                ]
            ], 200);
        }

        // SECTION FUNCTIONS
    private function UserList() {
        $grace = Info::whereNotNull('due_at')->where('due_at', '<=', Carbon::now())->count();
        $overdue = Info::whereNotNull('due_at')->where('due_at', '<=', Carbon::now()->subMonth(2))->count();

        $data = [
            [
                'id' => 7,
                'icon' => 'fa-user-friends',
                'color' => 'orange',
                'name' => 'Beneficiaries',
                'count' => Info::with('user')->whereNotNull('client_id')->count(),
            ],
            [
                'id' => 6,
                'icon' => 'fa-child',
                'color' => 'success',
                'name' => 'Client',
                'count' => Info::with('user')
                ->whereHas('user', function($q) {
                    $q->where('role', 6);
                })
                ->whereNull('client_id')->count(),
            ],
            [
                'id' => 5,
                'icon' => 'fa-user-edit',
                'color' => 'info',
                'name' => 'Staff',
                'count' => Info::with('user')
                ->whereHas('user', function($q) {
                    $q->where('role', 5);
                })
                ->whereNull('client_id')->count(),
            ],
            [
                'id' => 4,
                'icon' => 'fa-handshake',
                'color' => 'purple',
                'name' => 'Agent',
                'count' => Info::with('user')
                ->whereHas('user', function($q) {
                    $q->where('role', 4);
                })
                ->whereNull('client_id')->count(),
            ],
            [
                'id' => 3,
                'icon' => 'fa-crown',
                'color' => 'warning',
                'name' => 'Admin',
                'count' => Info::with('user')
                ->whereHas('user', function($q) {
                    $q->where('role', 2);
                })
                ->whereNull('client_id')->count(),
            ],
            [
                'id' => 2,
                'icon' => 'fa-check-circle',
                'color' => 'secondary',
                'name' => 'Claimed',
                'count' => Info::with('user')
                ->whereHas('user', function($q) {
                    $q->where('role', 6);
                })
                ->whereNotNull('fulfilled_at')->count(),
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
