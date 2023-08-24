<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Info;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Phone;

class UserController extends Controller
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



        if($req->count)
            return $this->getCount($req);
        if($req->print)
            return $this->Print($req);

        $val = Validator::make($req->all(), [
            'role' => 'required|numeric',
            'search' => '',
            'start' => '',
            'end' => '',
        ]);

        if($val->fails()) {
            return $this->G_ValidatorFailResponse($val);
        }

        // SECTION ADMIN
        if($req->user()->role == 2) {
            $user = User::select('*');

            // NOTE ROLE FITLER
            if($req->role < 7) {
                $user->where('role', $req->role);
            }

            // NOTE DATE RANGE FILTER

            else {
                // NOTE SEARCH FILTER
                switch($req->filter) {
                    case 'email':
                        $user->where('email', 'LIKE', '%'.$req->search.'%')->with(['info.user', 'plan', 'pay_type', 'info.referred'])
                            ->withSum('client_transactions', 'amount'); // OK No whereRelation
                        break;
                    case 'address':
                        $user->with(['info.user', 'plan', 'pay_type', 'info.referred'])
                            ->withSum('client_transactions', 'amount')
                            ->whereHas('info.user', function($q) use ($req) {
                                $q->where('address', 'LIKE', '%'.$req->search.'%');
                            });
                        break;
                    case 'plans':
                        $user->with(['info.user', 'plan', 'pay_type', 'info.referred'])
                            ->withSum('client_transactions', 'amount')
                            ->whereHas('plan', function($q) use ($req) {
                                $q->where('name', 'LIKE', '%'.$req->search.'%');
                            });
                        break;
                    default:
                        $user->with(['info.user', 'plan', 'pay_type', 'info.referred.info'])
                            ->withSum('client_transactions', 'amount')
                            ->whereHas('info.user', function($q) use ($req) {
                                $q->where('lastName', 'LIKE', '%'.$req->search.'%')
                                ->orWhere('firstName', 'LIKE', '%'.$req->search.'%')
                                ->orWhere('midName', 'LIKE', '%'.$req->search.'%');
                            });
                }
            }

            $data = $user->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
        }

        // SECTION STAFF
        if($req->user()->role == 5) {
            $user = User::select('*');
            // NOTE ROLE FITLER
            if($req->role == 4) {
                $user->where('role', 4);
            }
            else {
                $user->where('role', 6);
            }

            // NOTE DATE RANGE FILTER
            if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                if((bool)strtotime($req->start)) {
                    $user->where('created_at', '>=', $req->start);
                }
                if((bool)strtotime($req->end)) {
                    $user->where('created_at', '<=', $req->end);
                }
                    $user->with(['info.user', 'plan']);
            }
            else {
                // NOTE SEARCH FILTER
                switch($req->filter) {
                    case 'email':
                        $user->where('email', 'LIKE', '%'.$req->search.'%')
                            ->with([
                                'info.user',
                                'plan',
                                'pay_type',
                                'info.referred',
                                'client_transactions.plan',
                                'client_transactions.pay_type',
                                'info.agent.info',
                                'info.staff.info',
                            ])
                            ->withSum('client_transactions', 'amount'); // OK No whereRelation
                        break;
                    case 'address':
                        $user->with([
                            'info.user',
                            'plan',
                            'pay_type',
                            'info.referred',
                            'client_transactions.plan',
                            'client_transactions.pay_type',
                            'info.agent.info',
                            'info.staff.info',
                        ])
                            ->withSum('client_transactions', 'amount')
                            ->whereHas('info.user', function($q) use ($req) {
                                $q->where('address', 'LIKE', '%'.$req->search.'%');
                            });
                        break;
                    case 'plans':
                        $user->with([
                            'info.user',
                            'plan',
                            'pay_type',
                            'info.referred',
                            'client_transactions.plan',
                            'client_transactions.pay_type',
                            'info.agent.info',
                            'info.staff.info',
                        ])
                            ->withSum('client_transactions', 'amount')
                            ->whereHas('plan', function($q) use ($req) {
                                $q->where('name', 'LIKE', '%'.$req->search.'%');
                            });
                        break;
                    default:
                        $user->with([
                                'info.user',
                                'plan',
                                'pay_type',
                                'info.referred.info',
                                'client_transactions.plan',
                                'client_transactions.pay_type',
                                'info.agent.info',
                                'info.staff.info',
                            ])
                            ->withSum('client_transactions', 'amount')
                            ->whereHas('info.user', function($q) use ($req) {
                                $q->where('lastName', 'LIKE', '%'.$req->search.'%')
                                ->orWhere('firstName', 'LIKE', '%'.$req->search.'%')
                                ->orWhere('midName', 'LIKE', '%'.$req->search.'%');
                            });
                }
            }

            $data = $user->orderBy('created_at', 'desc')->paginate(0);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
        }
    }

        private function ClientIndex($req) {
            $val = Validator::make($req->all(), [
                'sort' => 'required',
                'search' => '',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $data = Info::where('client_id', $req->user()->info->id)
                ->where('name', 'LIKE', '%'.$req->search.'%')
                ->paginate(10);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        private function AgentIndex($req) {
            $val = Validator::make($req->all(), [
                'sort' => 'required',
                'search' => '',
                'start' => '',
                'end' => '',
                'print' => ''
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if($req->print) {
                $data = Info::with(['plan', 'pay_type'])
                    ->withSum('client_transactions', 'amount')
                    ->where('agent_id', $req->user()->info->id)
                    ->where('created_at', '>=', $req->start)
                    ->where('created_at', '<=', $req->end)
                    ->whereNull('client_id')
                    ->orderBy('name', 'ASC')
                    ->get();

                return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
            }
            else {
                $data = Info::with(['plan', 'pay_type'])
                    ->withSum('client_transactions', 'amount')
                    ->where('agent_id', $req->user()->info->id)
                    ->where('name', 'LIKE', '%'.$req->search.'%');


                    if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                        if((bool)strtotime($req->start)) {
                            $data->where('created_at', '>=', $req->start);
                        }
                        if((bool)strtotime($req->end)) {
                            $data->where('created_at', '<=', $req->end);
                        }
                    }

                    $data->whereNull('client_id')->paginate(10);

                return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
            }
        }

        private function StaffIndex($req) {
            $val = Validator::make($req->all(), [
                'sort' => 'required',
                'search' => '',
                'start' => '',
                'end' => '',
                'print' => '',
                'limit' => 'required',
                'filter' => 'required',
                'role' => 'required'
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if($req->overdue) {
                return $this->StaffOverdueIndex($req);
            }

            if($req->print) {
                return $this->StaffPrintIndex($req);
            }

            $data = Info::select('*');

            if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                if((bool)strtotime($req->start)) {
                    $data->where('created_at', '>=', $req->start);
                }
                if((bool)strtotime($req->end)) {
                    $data->where('created_at', '<=', $req->end);
                }
            }

            $data->with(['plan', 'pay_type', 'agent', 'user', 'staff', 'phones']);

            switch($req->filter) {
            case 'plan':
                $data->whereHas('user', function($q) use($req) {
                    $q->where('role', $req->role);
                })
                ->whereHas('plan', function($q) use($req) {
                    $q->where('name', 'LIKE', '%'.$req->search.'%');
                })
                ->withSum('client_transactions', 'amount');
                break;
            case 'address':
                $data->whereHas('user', function($q) use($req) {
                    $q->where('role', $req->role);
                })
                ->withSum('client_transactions', 'amount')
                ->where('address', 'LIKE', '%'.$req->search.'%');
                break;
            case 'email':
                $data->whereHas('user', function($q) use($req) {
                    $q->where('role', $req->role)->where('name', 'LIKE', '%'.$req->search.'%');
                })
                ->withSum('client_transactions', 'amount');
                break;
            default:
                $data->whereHas('user', function($q) use($req) {
                    $q->where('role', $req->role);
                })
                ->withSum('client_transactions', 'amount')
                ->where('name', 'LIKE', '%'.$req->search.'%');

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data->withSum('client_transactions', 'amount')->orderBy('created_at', 'DESC')->paginate($req->limit)
            ]);
            }
        }

        private function StaffPrintIndex($req) {
            $data = Info::with(['plan', 'pay_type'])
                ->withSum('client_transactions', 'amount')
                ->where('agent_id', $req->user()->info->id)
                ->where('created_at', '>=', $req->start)
                ->where('created_at', '<=', $req->end)
                ->orderBy('name', 'ASC')
                ->get();

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        private function StaffOverdueIndex($req) {
            $data = Info::with(['plan', 'pay_type', 'user', 'staff', 'agent'])
                ->withSum('client_transactions', 'amount')
                ->whereNotNull('due_at')
                ->orderBy('due_at', 'ASC')
                ->paginate($req->limit);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        private function AdminIndex($req) {
            $val = Validator::make($req->all(), [
                'sort' => 'required',
                'search' => '',
                'start' => '',
                'end' => '',
                'print' => '',
                'limit' => 'required',
                'filter' => 'required',
                'role' => 'required'
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if($req->overdue) {
                return $this->StaffOverdueIndex($req);
            }

            if($req->print) {
                return $this->StaffPrintIndex($req);
            }

            $data = Info::select('*');

            if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                if((bool)strtotime($req->start)) {
                    $data->where('created_at', '>=', $req->start);
                }
                if((bool)strtotime($req->end)) {
                    $data->where('created_at', '<=', $req->end);
                }
            }

            $data->with(['plan', 'pay_type', 'agent', 'user', 'staff', 'phones']);

            if($req->role > 0) {
                $data->whereHas('user', function($q) use($req) {
                    $q->where('role', $req->role);
                });
            }
            else if($req->role) {
                $data->whereNotNull('client_id')->with(['user']);
            }
            else {
                $data->whereHas('user', function($q){

                });
            }

            switch($req->filter) {
                case 'plan':
                    $data->whereHas('plan', function($q) use($req) {
                            $q->where('name', 'LIKE', '%'.$req->search.'%');
                        })
                        ->withSum('client_transactions', 'amount');
                    break;
                case 'address':
                    $data->withSum('client_transactions', 'amount')
                        ->where('address', 'LIKE', '%'.$req->search.'%');
                    break;
                case 'email':
                    $data->withSum('client_transactions', 'amount');
                    break;
                default:
                    $data->withSum('client_transactions', 'amount')
                        ->where('name', 'LIKE', '%'.$req->search.'%');
                return response()->json([
                    ...$this->G_ReturnDefault($req),
                    'data' => $data->withSum('client_transactions', 'amount')->orderBy('created_at', 'DESC')->paginate($req->limit)
                ]);
            }
        }

    // SECTION STORE
    public function store(Request $req) {
        switch($req->user()->role) {
            case 2:
                return $this->AdminStore($req);
            case 5:
                return $this->StaffStore($req);
            default:
                return $this->G_UnauthorizedResponse();
        }

        if($req->user()->role == 2) {
            if($req->or) {
                if($req->or != '') {
                return $this->ORStore($req);
                }
            }

            $val = Validator::make($req->all(), [
                'avatar'   => '',
                'username' => 'required|unique:users',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:8',
                'mobile'   => 'required',
                'notifyMobile' => 'required',
                'role'     => 'required',
                'plan'     => 'required',

                'lastName' => 'required',
                'firstName'=> 'required',
                'midName'  => '',
                'extName'  => '',
                'sex'      => 'required',
                'bday'     => 'required',
                'bplaceID' => 'required',
                'addressID'=> 'required',
                'address'  => 'required',
                'pay_type_id' => 'required',
                'agent'    => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $avatar = null;

            if($req->avatar != '') {
                $avatar = $this->G_AvatarUpload($req->avatar);
            }

            $user = User::create([
                'plan_id'  => $req->plan,
                'username' => $req->username,
                'email'    => $req->email,
                'password' => Hash::make($req->password),
                'avatar'   => $avatar,
                'role'     => $req->role,
                'notify_mobile' => $req->notifyMobile,
                'pay_type_id' => $req->pay_type_id,
            ]);

            $info = Info::create([
                'user_id'   => $user->id,
                'lastName'  => $req->lastName,
                'firstName' => $req->firstName,
                'midName'   => $req->midName,
                'extName'   => $req->extName,
                'bday'      => $req->bday,
                'bplace_id' => $req->bplaceID,
                'sex'       => $req->sex,
                'address_id'=> $req->bplaceID,
                'address'   => $req->address,
                'mobile'    => $req->mobile,
                'agent_id'  => $req->agent
            ]);

            Transaction::create([
                'agent_id'  => $req->agent,
                'staff_id'  => $req->user()->id,
                'client_id' => $info->id,
                'pay_type_id' => $req->pay_type_id,
                'amount'  =>  $req->transaction,
                'plan_id' => $req->plan,
            ]);

            return response()->json([...$this->G_ReturnDefault($req)]);
        }

        if($req->user()->role == 5) {
            if($req->or) {
                if($req->or != '') {
                    return $this->ORStore($req);
                }
            }
        }

        return $this->G_UnauthorizedResponse();
    }

    private function StaffStore($req) {
        if($req->or) {
        $val = Validator::make($req->all(), [
            'or'   => 'required',
            'plan'     => 'required',
            'pay_type_id' => 'required',
            'transaction' => 'required',
            'agent'  => 'required',
            'name'      => 'required',
        ]);

        if($val->fails()) {
            return $this->G_ValidatorFailResponse($val);
        }

        $user = User::create([
            'role'     => 6, // NOTE client only,
        ]);

        $info = Info::create([
            'user_id'    => $user->id,
            'staff_id'   => $req->user()->info->id,
            'or'         => $req->or,
            'plan_id'    => $req->plan,
            'pay_type_id'=> $req->pay_type_id,
            'agent_id'   => $req->agent,
            'name'       => $req->name,
        ]);

        Transaction::create([
            'or' => $req->or,
            'agent_id'  => $req->agent,
            'staff_id'  => $req->user()->info->id,
            'client_id' => $info->id,
            'pay_type_id' => $req->pay_type_id,
            'amount'  =>  $req->transaction,
            'plan_id' => $req->plan,
        ]);
        }
        else {
        $val = Validator::make($req->all(), [
            'avatar'   => '',
            'username' => 'required|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'mobile'   => 'required',
            'role'     => 'required',
            'plan'     => 'required',
            'agent_id' => 'required',

            'name'      => 'required',
            'sex'       => 'required',
            'bday'      => 'required',
            'bplace_id' => 'required',
            'address_id'=> 'required',
            'address'   => 'required',
            'pay_type_id' => 'required',
            'transaction' => 'required',
        ]);

        if($val->fails()) {
            return $this->G_ValidatorFailResponse($val);
        }

        $due = Carbon::now()->add('months', 1);
        switch($req->pay_type_id) {
            case 2:
            $due = Carbon::now()->add('months', 3);
            break;
            case 3:
            $due = Carbon::now()->add('months', 6);
            break;
            case 4:
            $due = Carbon::now()->add('months', 12);
            break;
            case 5:
            $due = null;
            case 6:
            $due = null;
            break;
        }

        $info = Info::create([
            'staff_id'  => $req->user()->info->id,
            'name'      => $req->name,
            'bday'      => $req->bday,
            'bplace_id' => $req->bplace_id,
            'sex'       => $req->sex,
            'address_id'=> $req->bplace_id,
            'address'   => $req->address,
            'agent_id'  => $req->agent_id,
            'plan_id'   => $req->plan,
            'pay_type_id' => $req->pay_type_id,
            'due_at'    => $due,
        ]);

        $avatar = null;

        if($req->avatar != '') {
            $avatar = $this->G_AvatarUpload($req->avatar);
        }

        $user = User::create([
            'info_id' => $info->id,
            'username' => $req->username,
            'email'    => $req->email,
            'password' => Hash::make($req->password),
            'avatar'   => $avatar,
            'role'     => 6, // NOTE Client Only
        ]);

        Transaction::create([
            'or' => rand(000000, 999999),
            'agent_id'  => $req->agent_id,
            'staff_id'  => $req->user()->person->id,
            'client_id' => $person->id,
            'pay_type_id' => $req->pay_type_id,
            'amount'  =>  $req->transaction,
            'plan_id' => $req->plan,
        ]);

        Phone::create([
            'info_id' => $info->id,
            'phone' => $req->mobile,
        ]);
        }



        return response()->json([...$this->G_ReturnDefault($req)]);
    }

    private function AdminStore($req) {
        if($req->or) {
            $val = Validator::make($req->all(), [
                'or'   => 'required',
                'plan'     => 'required',
                'pay_type_id' => 'required',
                'transaction' => 'required',
                'agent'  => 'required',
                'name'      => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $info = Info::create([
                'staff_id'   => $req->user()->info->id,
                'or'         => $req->or,
                'plan_id'    => $req->plan,
                'pay_type_id'=> $req->pay_type_id,
                'agent_id'   => $req->agent,
                'name'       => $req->name,
            ]);

            $user = User::create([
                'info_id'=> $info->id,
                'role'     => $req->role,
            ]);

            Transaction::create([
                'or' => $req->or,
                'agent_id'  => $req->agent,
                'staff_id'  => $req->user()->info->id,
                'client_id' => $info->id,
                'pay_type_id' => $req->pay_type_id,
                'amount'  =>  $req->transaction,
                'plan_id' => $req->plan,
            ]);
        }
        else {
            $val = Validator::make($req->all(), [
                'avatar'   => '',
                'username' => 'required|unique:users',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:8',
                'mobile'   => 'required',
                'role'     => 'required',
                'plan'     => 'required',
                'agent_id' => 'required',

                'name'      => 'required',
                'sex'       => 'required',
                'bday'      => 'required',
                'bplace_id' => 'required',
                'address_id'=> 'required',
                'address'   => 'required',
                'pay_type_id' => 'required',
                'transaction' => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $due = Carbon::now()->add('months', 1);
            switch($req->pay_type_id) {
                case 2:
                $due = Carbon::now()->add('months', 3);
                break;
                case 3:
                $due = Carbon::now()->add('months', 6);
                break;
                case 4:
                $due = Carbon::now()->add('months', 12);
                break;
                case 5:
                $due = null;
                case 6:
                $due = null;
                break;
            }

            $info = Info::create([
                'staff_id'  => $req->user()->info->id,
                'name'      => $req->name,
                'bday'      => $req->bday,
                'bplace_id' => $req->bplace_id,
                'sex'       => $req->sex,
                'address_id'=> $req->bplace_id,
                'address'   => $req->address,
                'agent_id'  => $req->agent_id,
                'plan_id'   => $req->plan,
                'pay_type_id' => $req->pay_type_id,
                'due_at'    => $due,
            ]);

            $avatar = null;

            if($req->avatar != '') {
                $avatar = $this->G_AvatarUpload($req->avatar);
            }

            $user = User::create([
                'info_id'=> $info->id,
                'username' => $req->username,
                'email'    => $req->email,
                'password' => Hash::make($req->password),
                'avatar'   => $avatar,
                'role'     => 6, // NOTE Client Only
            ]);

            Transaction::create([
                'or' => rand(000000, 999999),
                'agent_id'  => $req->agent_id,
                'staff_id'  => $req->user()->info->id,
                'client_id' => $info->id,
                'pay_type_id' => $req->pay_type_id,
                'amount'  =>  $req->transaction,
                'plan_id' => $req->plan,
            ]);

            Phone::create([
                'info_id' => $info->id,
                'phone' => $req->mobile,
            ]);
        }
        return response()->json([...$this->G_ReturnDefault($req)]);
    }

    // SECTION SHOW
    public function show(string $id, Request $req) {
        switch($req->user()->role) {
            case 2:
                return $this->AdminShow($req, $id);
            case 5:
                return $this->StaffShow($req, $id);
            default:
            return $this->G_UnauthorizedResponse();
        }
    }

        private function StaffShow($req, $id) {
            $data = Info::where('id', $id)
                ->with(['user', 'client_transactions', 'plan', 'pay_type'])
                ->withSum('client_transactions', 'amount')
                ->first();

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
        }

        private function AdminShow($req, $id) {
            $data;

            if(Info::where('id', $id)->with('user')->whereHas('user', function($q) {$q->where('role', 4);})->first()) {
                $data = Info::where('id', $id)
                    ->with(['user', 'agent_transactions.client', 'pay_type', 'plan', 'agent_clients.plan', 'agent_clients.pay_type', 'agent_clients' => function ($q) {
                        $q->withSum('client_transactions', 'amount');
                    }])
                    ->withSum('agent_transactions', 'amount')
                    ->withCount('agent')
                    ->first();
            }
            else {
                $data = Info::where('id', $id)
                    ->with(['user', 'client_transactions', 'plan', 'pay_type'])
                    ->withSum('client_transactions', 'amount')
                    ->first();
            }

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
        }

    // SECTION UPDATE
    public function update(Request $req, string $id) {
        switch($req->user()->role) {
            case 2:
                return $this->AdminUpdate($req, $id);
            case 5:
                return $this->StaffUpdate($req, $id);
            default:
                return $this->G_UnauthorizedResponse();
        }
    }

        private function StaffUpdate($req, $id) {
            $val = Validator::make($req->all(), [
                'user.avatar'   => '',
                'user.username' => ['required', Rule::unique('users', 'username')->ignore($req->user['id'])],
                'user.email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($req->user['id'])],
                'user.password' => '',
                // 'person.mobile' => 'required',
                'plan_id'  => 'required',
                'pay_type_id' => 'required',

                'name'  => 'required',
                'sex'       => 'required',
                'bday'      => 'required',
                'bplace_id' => 'required',
                'address_id'=> 'required',
                'address'   => 'required',
                'agent_id'  => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $info = Info::where('id', $id)->update([
                'name'      => $req->name,
                'bday'      => $req->bday,
                'bplace_id' => $req->bplace_id,
                'sex'       => $req->sex,
                'address_id'=> $req->address_id,
                'address'   => $req->address,
                // 'mobile'    => $req->person['mobile'],
                'agent_id'  => $req->agent_id,
                'plan_id'   => $req->plan_id,
                'pay_type_id'=> $req->pay_type_id,
            ]);

            $user = User::where('id', $req->user['id'])->update([
                'username' => $req->user['username'],
                'email'    => $req->user['email'],
            ]);

            if($req->password) {
                User::where('id', $req->user['id'])->update(['password' => Hash::make($req->password)]);
            }

            if(!User::where('id', $req->user['id'])->where('avatar', $req->user['avatar'])->first()) {
                User::where('id', $req->user['id'])->update(['avatar' => $this->G_AvatarUpload($req->user['avatar'])]);
            }

            return response()->json([...$this->G_ReturnDefault($req),]);
        }

        private function AdminUpdate($req, $id) {
            $val = Validator::make($req->all(), [
                'user.avatar'   => '',
                'user.username' => ['required', Rule::unique('users', 'username')->ignore($req->user['id'])],
                'user.email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($req->user['id'])],
                'user.password' => '',
                // 'person.mobile' => 'required',
                'plan_id'  => 'required',
                'pay_type_id' => 'required',

                'name'  => 'required',
                'sex'       => 'required',
                'bday'      => 'required',
                'bplace_id' => 'required',
                'address_id'=> 'required',
                'address'   => 'required',
                'agent_id'  => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $info = Info::where('id', $id)->update([
                'name'      => $req->name,
                'bday'      => $req->bday,
                'bplace_id' => $req->bplace_id,
                'sex'       => $req->sex,
                'address_id'=> $req->address_id,
                'address'   => $req->address,
                // 'mobile'    => $req->person['mobile'],
                'agent_id'  => $req->agent_id,
                'plan_id'   => $req->plan_id,
                'pay_type_id'=> $req->pay_type_id,
            ]);

            $user = User::where('id', $req->user['id'])->update([
                'username' => $req->user['username'],
                'email'    => $req->user['email'],
                'role'     => $req->user['role']
            ]);

            if($req->password) {
                User::where('id', $req->user['id'])->update(['password' => Hash::make($req->password)]);
            }

            if(!User::where('id', $req->user['id'])->where('avatar', $req->user['avatar'])->first()) {
                User::where('id', $req->user['id'])->update(['avatar' => $this->G_AvatarUpload($req->user['avatar'])]);
            }

            return response()->json([...$this->G_ReturnDefault($req),]);
        }

    // SECTION DELETE
    public function destroy(string $id, Request $req) {
        if($req->user()->role == 2) {
            User::where('info_id', Info::where('id', $id)->first()->id)->delete();
            Info::where('id', $id)->delete();
            return response()->json([...$this->G_ReturnDefault($req)], 200);
        }
        return $this->G_UnauthorizedResponse();
    }

        // SECTION OTHERS
        private function getCount($req) {
            // SECTION ADMIN
            if($req->user()->role == 2) {
                $count = [
                    'all'     => User::count(),
                    'clients' => User::where('role', 6)->count(),
                    'staff'   => User::where('role', 5)->count(),
                    'agent'   => User::where('role', 4)->count(),
                    'manager' => User::where('role', 3)->count(),
                    'admin'   => User::where('role', 2)->count(),
                    'inactive'=> User::where('role', 0)->count(),
                    'banned'  => User::where('role', 1)->count(),
                ];

                $data = [
                    ['name' => 'All',     'count' => $count['all'],     'color' => 'info',    'icon' => 'fa-users'],
                    ['name' => 'Clients', 'count' => $count['clients'], 'color' => 'success', 'icon' => 'fa-child'],
                    ['name' => 'Staff',   'count' => $count['staff'],   'color' => 'info',    'icon' => 'fa-user-edit'],
                    ['name' => 'Agent',   'count' => $count['agent'],   'color' => 'purple',  'icon' => 'fa-handshake'],
                    ['name' => 'Manager', 'count' => $count['manager'], 'color' => 'orange',  'icon' => 'fa-tasks'],
                    ['name' => 'Admin',   'count' => $count['admin'],   'color' => 'warning', 'icon' => 'fa-crown'],
                    ['name' => 'Inactive','count' => $count['inactive'],'color' => 'secondary','icon'=> 'fa-moon'],
                    ['name' => 'Banned',  'count' => $count['banned'],  'color' => 'danger',  'icon' => 'fa-ban'],
                ];

                return response()->json(['status' => true, 'message' => 'success', 'data' => $data], 200);
            }
            // SECTION STAFF
            if($req->user()->role == 5) {
                $count = [
                    'clients' => User::where('role', 6)->count(),
                    'inactive'=> User::where('role', 6)->whereNotNull('OR')->whereNull('email')->count(),
                ];

                $data = [
                    ['name' => 'Clients', 'count' => $count['clients'], 'color' => 'success', 'icon' => 'fa-child'],
                    ['name' => 'Inactive','count' => $count['inactive'],'color' => 'secondary','icon'=> 'fa-moon'],
                ];

                return response()->json(['status' => true, 'message' => 'success', 'data' => $data], 200);
            }
            return $this->G_UnauthorizedResponse();
        }

        private function ORStore($req) {
            $val = Validator::make($req->all(), [
                'or' => 'required',
                'mobile' => 'required',
                'plan' => 'required',
                'transaction' => '',
                'lastName' => 'required',
                'firstName' => 'required',
                'midName' => '',
                'extName' => '',
                'pay_type' => 'required',
                'agent' => 'required',
                'transaction' => 'required',
            ]);


            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $info = Info::create([
                'created_by_user_id' => $req->user()->id,
                'lastName'  => $req->lastName,
                'firstName' => $req->firstName,
                'midName'   => $req->midName,
                'extName'   => $req->extName,
                'mobile'    => $req->mobile,
                'agent_id'  => $req->agent,
            ]);

            $avatar = null;

            if($req->avatar != '') {
                $avatar = $this->G_AvatarUpload($req->avatar);
            }

            $user = User::create([
                'info_id'=> $info->id,
                'plan_id'  => $req->plan,
                'role'     => 6, // NOTE client only
                'notify_mobile' => $req->notifyMobile,
                'OR' => $req->or,
                'pay_type_id' => $req->pay_type,
                'avatar' => $avatar,
            ]);

            Transaction::create([
                'agent_id'  => $req->agent,
                'staff_id'  => $req->user()->id,
                'client_id' => $info->id,
                'pay_type_id' => $req->pay_type,
                'amount'  =>  $req->transaction,
                'plan_id' => $req->plan,
            ]);


            return response()->json([...$this->G_ReturnDefault($req)]);
        }

        private function Print($req) {
            // SECTION STAFF
            if($req->user()->role == 5) {
                $user = User::select('*')->where('role', 6);

                // NOTE DATE RANGE FILTER
                if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                    if((bool)strtotime($req->start)) {
                        $user->where('created_at', '>=', $req->start);
                    }
                    if((bool)strtotime($req->end)) {
                        $user->where('created_at', '<=', $req->end);
                    }
                    $user->with(['info.user', 'plan', 'pay_type', 'info.referred.info'])->withSum('client_transactions', 'amount');
                }
                else {
                    $user->with(['info.user', 'plan', 'pay_type', 'info.referred.info'])->withSum('client_transactions', 'amount');
                }

                $data = $user->orderBy('created_at', 'desc')->get();

                return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
            }
        }
}
