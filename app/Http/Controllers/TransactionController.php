<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Info;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    // SECTION INDEX
    public function index(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            if($req->id)
                return $this->AdminIDIndex($req);
            if($req->print)
                return $this->AdminPrintIndex($req);

                return $this->AdminIndex($req);
        }
        else if($req->user()->hasRole('agent')) {
            return $this->AgentIndex($req);
        }
        else if($req->user()->hasRole('staff')) {
            if($req->id)
                return $this->StaffIDIndex($req);
            if($req->print)
                return $this->StaffPrintIndex($req);

                return $this->StaffIndex($req);
        }
        else if($req->user()->hasRole('client')) {
            return $this->ClientIndex($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function ClientIndex(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'search' => '',
                'sort' => 'required'
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $data = Transaction::where('client_id', $req->user()->id)
                ->with(['plan', 'pay_type', 'client', 'staff'])
                ->whereHas('plan', function($q) use($req) {
                    $q->where('name', 'LIKE', '%' . $req->search. '%');
                })
                ->orderBy('created_at', $req->sort)
                ->paginate(10);

            $sum = Transaction::where('client_id', $req->user()->id)->sum('amount');

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data,
                'sum'  => $sum,
            ]);
        }

        private function AgentIndex(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'search' => '',
                'start' => 'required',
                'end' => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if($req->print) {
                $data = Transaction::where('agent_id', $req->user()->id)
                    ->with(['plan', 'pay_type', 'client', 'staff'])
                    ->where('created_at', '>=', $req->start)
                    ->where('created_at', '<=', $req->end)
                    ->orderBy('created_at', 'DESC')
                    ->get();

                $sum = Transaction::where('agent_id', $req->user()->id)->sum('amount');

                return response()->json([
                    ...$this->G_ReturnDefault($req),
                    'data' => $data,
                    'sum'  => $sum,
                ]);
            }
            else {
                $data = Transaction::where('agent_id', $req->user()->id)
                    ->with(['plan', 'pay_type', 'client', 'staff'])
                    ->whereHas('client', function($q) use($req) {
                        $q->where('name', 'LIKE', '%' . $req->search. '%');
                    })
                    ->where('created_at', '>=', $req->start)
                    ->where('created_at', '<=', $req->end)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

                $sum = Transaction::where('agent_id', $req->user()->peinforson->id)->sum('amount');

                return response()->json([
                    ...$this->G_ReturnDefault($req),
                    'data' => $data,
                    'sum'  => $sum,
                ]);
            }
        }

        private function StaffIndex(Request $req) : JsonResponse {
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
                'client',
                'client' => function($q) {
                    $q->withSum('client_transactions','amount');
                },
                'staff',
                'agent'
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

                    $sum = Transaction::where('agent_id', $req->user()->id)->sum('amount');

                    return response()->json([
                        ...$this->G_ReturnDefault($req),
                        'data' => $data->orderBy('created_at', 'DESC')->paginate($req->limit),
                        'sum'  => $sum,
                    ]);
            }
        }

        private function StaffIDIndex(Request $req) : JsonResponse {
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

        private function StaffPrintIndex(Request $req) : JsonResponse {
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

            $sum = Transaction::where('agent_id', $req->user()->info->id)->sum('amount');

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data->orderBy('created_at', 'DESC')->get(),
                'sum'  => $sum,
            ]);
        }

        private function AdminIndex(Request $req) : JsonResponse {
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



                $sum = Transaction::where('agent_id', $req->user()->info->id)->sum('amount');

                return response()->json([
                    ...$this->G_ReturnDefault($req),
                    'data' => $data->orderBy('created_at', 'DESC')->paginate($req->limit),
                    'sum'  => $sum,
                ]);
            }
        }

        private function AdminIDIndex(Request $req) : JsonResponse {
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

        private function AdminPrintIndex(Request $req) : JsonResponse {
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

            $sum = Transaction::where('agent_id', $req->user()->info->id)->sum('amount');

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data->orderBy('created_at', 'DESC')->get(),
                'sum'  => $sum,
            ]);
        }

    // SECTION STORE
    public function store(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminStore($req);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffStore($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffStore(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                // 'agent.id' => 'required',
                'userId' => 'required',
                'amount' => 'required',
                'or' => 'required',
                'pay_type_id' => 'required',
                'plan_id' => 'required',
                'or',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $client = User::where('id', $req->userId)->role('client')->with('info.agent')->first();

            // return response()->json(['data' => $client]);

            Transaction::create([
                'or' => $req->or,
                'agent_id' => $client->info->agent->id,
                'staff_id' => $req->user()->id,
                'client_id' => $req->userId,
                'pay_type_id' => $req->pay_type_id,
                'plan_id' => $req->plan_id,
                'amount' => $req->amount,
            ]);

            $due = Info::where('user_id', $req->userId)->first()->due_at;

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

            Info::where('user_id', $req->userId)->update(['due_at' => $due]);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => true]);
        }

        private function AdminStore(Request $req) : JsonResponse {
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
                'staff_id' => $req->user()->info->id,
                'client_id' => $req->client['id'],
                'pay_type_id' => $req->pay_type_id,
                'plan_id' => $req->plan['id'],
                'amount' => $req->amount,
            ]);

            $due = Info::where('id', $req->client['id'])->first()->due_at;

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

            Info::where('id', $req->client['id'])->update(['due_at' => $due]);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => true]);
        }

    // SECTION UPDATE
    public function update(Request $req, int $id) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminUpdate($req, $id);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffUpdate($req, $id);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffUpdate(Request $req, int $id) : JsonResponse {
            $val = Validator::make($req->all(), [
                'agent_id' => 'required',
                'client_id' => 'required',
                'amount' => 'required',
                'or' => 'required',
                'pay_type_id' => 'required',
                'plan_id' => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $trans = Transaction::where('id', $id)
                // NOTE in the future for restrictions
                // ->where('staff_id', $req->user()->id)
                ->update([
                    'or' => $req->or,
                    'agent_id' => $req->agent_id,
                    'client_id' => $req->client_id,
                    'pay_type_id' => $req->pay_type_id,
                    'plan_id' => $req->plan_id,
                    'amount' => $req->amount,
                ]);

            if(!$trans) {
                return $this->G_UnauthorizedResponse();
            }

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $trans]);
        }

        private function AdminUpdate(Request $req, int $id) : JsonResponse {
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
                ->where('staff_id', $req->user()->info->id)
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

    // SECTION DESTROY
    public function destroy(int $id, Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return AdminDestroy($req, $id);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function AdminDestroy(Request $req, int $id) : JsonResponse {
            Transaction::where('id', $id)->delete();
            return response()->json([...$this->G_ReturnDefault($req), 'data' => true]);
        }

    // SECTION OTHERS
    private function Print(Request $req) : JsonResponse {
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
                'client.info',
                'client' => function ($q) {
                    $q->withSum('client_transactions', 'amount');
                },
                'staff',
                'agent.info',
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

    public function dashboard(Request $req): JsonResponse {
        if($req->user()->hasRole('staff')) {
            return $this->StaffDashboard($req);
        }
    }
        private function StaffDashboard(Request $req) : JsonResponse {
            $data = Transaction::with(['client', 'agent'])->orderBy('created_at', 'DESC')->limit(10)->get();

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data,
            ]);
        }
}
