<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Info;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Phone;
use Spatie\Permission\Models\Role;

use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    // SECTION INDEX
    public function index(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminIndex($req);
        }
        else if($req->user()->hasRole('agent')) {
            return $this->AgentIndex($req);
        }
        else if($req->user()->hasRole('staff')) {
            if($req->print) {
                return $this->StaffPrint($req);
            }

            return $this->StaffIndex($req);
        }
        else if($req->user()->hasRole('client')) {
            return $this->ClientIndex($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function ClientIndex ($req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'search' => '',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $data = Beneficiary::where('user_id', $req->user()->id)
                ->where('name', 'LIKE', '%'.$req->search.'%')
                ->get();

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        private function AgentIndex(Request $req) : JsonResponse {
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
                $data = Info::with(['plan_details.plan', 'pay_type'])
                    ->withSum('client_transactions', 'amount')
                    ->where('agent_id', $req->user()->id)
                    ->where('created_at', '>=', $req->start)
                    ->where('created_at', '<=', $req->end)
                    ->whereNull('client_id')
                    ->orderBy('name', 'ASC')
                    ->get();

                return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
            }
            else {
                $data = Info::with(['plan_details.plan', 'pay_type'])
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

        private function StaffIndex(Request $req) : JsonResponse {
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

            $data = User::select('*');

            if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                if((bool)strtotime($req->start)) {
                    $data->where('created_at', '>=', $req->start);
                }
                if((bool)strtotime($req->end)) {
                    $data->where('created_at', '<=', $req->end);
                }
            }

            $data->with(['info.plan_details.plan', 'info.pay_type', 'info.agent', 'info.staff']);

            switch($req->filter) {
                case 'plans':
                    $data->role('client')
                        ->whereHas('info.plan_details.plan', function($q) use($req) {
                            $q->where('name', 'LIKE', '%'.$req->search.'%');
                        })
                        ->withSum('client_transactions', 'amount');
                    break;
                case 'address':
                    $data->role('client')
                        ->withSum('client_transactions', 'amount')
                        ->whereHas('info', function($q) use($req) {
                            $q->where('address', 'LIKE', '%'.$req->search.'%');
                        });
                    break;
                case 'email':
                    $data->role('client')->where('email', 'LIKE', '%'.$req->search.'%')
                        ->withSum('client_transactions', 'amount');
                    break;
                default:
                    $data->role('client')
                        ->withSum('client_transactions', 'amount')
                        ->where('name', 'LIKE', '%'.$req->search.'%');
            }

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data->withSum('client_transactions', 'amount')->orderBy('created_at', 'DESC')->paginate(10)
            ]);
        }

        private function StaffPrint(Request $req) : JsonResponse {
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

            $data = User::select('*');

            if((bool)strtotime($req->start) OR (bool)strtotime($req->end)) {
                if((bool)strtotime($req->start)) {
                    $data->where('created_at', '>=', $req->start);
                }
                if((bool)strtotime($req->end)) {
                    $data->where('created_at', '<=', $req->end);
                }
            }

            $data->with(['info.plan_details.plan', 'info.pay_type', 'info.agent', 'info.staff']);

            switch($req->filter) {
                case 'plans':
                    $data->role('client')
                        ->whereHas('info.plan', function($q) use($req) {
                            $q->where('name', 'LIKE', '%'.$req->search.'%');
                        })
                    ->withSum('client_transactions', 'amount');
                    break;
                case 'address':
                    $data->role('client')
                        ->withSum('client_transactions', 'amount')
                        ->whereHas('info', function($q) use($req) {
                            $q->where('address', 'LIKE', '%'.$req->search.'%');
                        });
                    break;
                case 'email':
                    $data->role('client')->where('email', 'LIKE', '%'.$req->search.'%')
                        ->withSum('client_transactions', 'amount');
                    break;
                default:
                    $data->role('client')
                        ->withSum('client_transactions', 'amount')
                        ->where('name', 'LIKE', '%'.$req->search.'%');
            }

            if($req->print) {
                return response()->json([
                    ...$this->G_ReturnDefault($req),
                    'data' => $data->withSum('client_transactions', 'amount')->orderBy('created_at', 'DESC')->get()
                ]);
            }

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $data->withSum('client_transactions', 'amount')->orderBy('created_at', 'DESC')->paginate(10)
            ]);
        }

        private function StaffOverdueIndex(Request $req) : JsonResponse {
            $data = Info::with(['plan_details.plan', 'pay_type', 'user', 'staff', 'agent'])
                ->withSum('client_transactions', 'amount')
                ->whereNotNull('due_at')
                ->orderBy('due_at', 'ASC')
                ->paginate($req->limit);

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        private function AdminIndex(Request $req) : JsonResponse {
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

            $data->with(['plan_details.plan', 'pay_type', 'agent', 'user', 'staff', 'phones']);

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
                case 'plan_details.plan':
                    $data->whereHas('plan_details.plan', function($q) use($req) {
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
    public function store(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminIndex($req);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffStore($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffStore(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'avatar'   => '',
                'username' => 'required|unique:users',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:8',
                'mobile'   => 'required',
                'role'     => 'required',
                'plan_details_id'  => 'required',
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
                default:
                    $due = null;
            }

            $avatar = null;

            if($req->avatar != '') {
                $avatar = $this->G_AvatarUpload($req->avatar);
            }

            $user = User::create([
                'region_id' => $req->user()->region_id,
                'branch_id' => $req->user()->branch_id,
                'username' => $req->username,
                'name'     => $req->name,
                'email'    => $req->email,
                'password' => Hash::make($req->password),
                'avatar'   => $avatar,
            ])->assignRole('client');

            $info = Info::create([
                'user_id'    => $user->id,
                'staff_id'   => $req->user()->id,
                'agent_id'   => $req->agent_id,
                'bday'       => $req->bday,
                'bplace_id'  => $req->bplace_id,
                'sex'        => $req->sex,
                'address_id' => $req->bplace_id,
                'address'    => $req->address,
                'plan_details_id'    => $req->plan_details_id,
                'pay_type_id'=> $req->pay_type_id,
                'due_at'     => $due,
            ]);

            Transaction::create([
                'or' => rand(000000, 999999),
                'agent_id'  => $req->agent_id,
                'staff_id'  => $req->user()->id,
                'client_id' => $user->id,
                'pay_type_id' => $req->pay_type_id,
                'amount'  =>  $req->transaction,
                'plan_details_id' => $req->plan_details_id,
            ]);

            Phone::create([
                'user_id' => $user->id,
                'phone' => $req->mobile,
            ]);

            return response()->json([...$this->G_ReturnDefault($req)]);
        }

        private function AdminStore(Request $req) : JsonResponse {
            if($req->or) {
                $val = Validator::make($req->all(), [
                    'or'   => 'required',
                    'plan_details.plan'     => 'required',
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
                    'plan_details_id'    => $req->plan,
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
                    'plan_details_id' => $req->plan,
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
                    'plan_details.plan'     => 'required',
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
                    'plan_details_id'   => $req->plan,
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
                    'plan_details_id' => $req->plan,
                ]);

                Phone::create([
                    'info_id' => $info->id,
                    'phone' => $req->mobile,
                ]);
            }
            return response()->json([...$this->G_ReturnDefault($req)]);
        }

    // SECTION SHOW
    public function show(string $id, Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminShow($req, $id);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffShow($req, $id);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffShow(Request $req, string $id) : JsonResponse {
            $data = User::where('id', $id)
                ->with([
                    'client_transactions.plan_details.plan',
                    'client_transactions.pay_type',
                    'client_transactions.agent',
                    'info.plan_details.plan',
                    'info.pay_type',
                    'beneficiaries'
                ])
                ->withSum('client_transactions', 'amount')->first();

            $data['role'] = User::find($id)->roles->pluck('name', 'name')->first();

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
        }

        private function AdminShow(Request $req, string $id) : JsonResponse {
            $data;

            if(Info::where('id', $id)->with('user')->whereHas('user', function($q) {$q->where('role', 4);})->first()) {
                $data = Info::where('id', $id)
                    ->with(['user', 'agent_transactions.client', 'pay_type', 'plan_details.plan', 'agent_clients.plan', 'agent_clients.pay_type', 'agent_clients' => function ($q) {
                        $q->withSum('client_transactions', 'amount');
                    }])
                    ->withSum('agent_transactions', 'amount')
                    ->withCount('agent')
                    ->first();
            }
            else {
                $data = Info::where('id', $id)
                    ->with(['user', 'client_transactions', 'plan_details.plan', 'pay_type'])
                    ->withSum('client_transactions', 'amount')
                    ->first();
            }

            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
        }

    // SECTION UPDATE
    public function update(Request $req, string $id) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminUpdate($req, $id);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffUpdate($req, $id);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffUpdate(Request $req, string $id) : JsonResponse {
            $val = Validator::make($req->all(), [
                'user.avatar'   => '',
                'user.username' => ['required', Rule::unique('users', 'username')->ignore($req->user['id'])],
                'user.email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($req->user['id'])],
                'user.password' => '',
                // 'person.mobile' => 'required',
                'plan_details_id'  => 'required',
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
                'plan_details_id'   => $req->plan_details_id,
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

        private function AdminUpdate(Request $req, string $id) : JsonResponse {
            $val = Validator::make($req->all(), [
                'user.avatar'   => '',
                'user.username' => ['required', Rule::unique('users', 'username')->ignore($req->user['id'])],
                'user.email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($req->user['id'])],
                'user.password' => '',
                // 'person.mobile' => 'required',
                'plan_details_id'  => 'required',
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
                'plan_details_id'   => $req->plan_details_id,
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
    public function destroy(string $id, Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            User::where('info_id', Info::where('id', $id)->first()->id)->delete();
            Info::where('id', $id)->delete();
            return response()->json([...$this->G_ReturnDefault($req)], 200);
        }

        return $this->G_UnauthorizedResponse();
    }
        // SECTION OTHERS


        private function ORStore(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'or' => 'required',
                'mobile' => 'required',
                'plan_details.plan' => 'required',
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
                'plan_details_id'  => $req->plan,
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
                'plan_details_id' => $req->plan,
            ]);


            return response()->json([...$this->G_ReturnDefault($req)]);
        }

        private function Print(Request $req) : JsonResponse {
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
                    $user->with(['info.user', 'plan_details.plan', 'pay_type', 'info.referred.info'])->withSum('client_transactions', 'amount');
                }
            else {
                    $user->with(['info.user', 'plan_details.plan', 'pay_type', 'info.referred.info'])->withSum('client_transactions', 'amount');
                }

                $data = $user->orderBy('created_at', 'desc')->get();

                return response()->json([...$this->G_ReturnDefault($req), 'data' => $data], 200);
            }
        }

    // SECTION SPECIAL
    public function dashboard(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminDashboard($req);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffDashboard($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function AdminDashboard(Request $req) : int {
            return '2sdfsdf2';
        }

        private function StaffDashboard(Request $req) : JsonResponse {
            $user = User::with(['info.agent'])
                ->withSum('client_transactions', 'amount')
                ->role('client')->limit(5)->orderBy('created_at', 'DESC')->get();

            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => $user
            ]);

        }

    public function Count(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminGetCount($req);
        }
        else if($req->user()->hasRole('staff')) {
            return $this->StaffGetCount($req);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function AdminGetCount(Request $req) : JsonResponse {
            // SECTION ADMIN
            if($req->user()->role == 2) {
                $count = [
                    'all'     =>    User::count(),
                    'clients' =>    User::role('clients')->count(),
                    'staff'   =>    User::role('staff')->count(),
                    'agent'   =>    User::role('agent')->count(),
                    'regional_manager' => User::role('manager')->count(),
                    'branch_manager' => User::role('manager')->count(),
                    'admin'   => User::role('admin')->count(),
                ];

                $data = [
                    ['name' => 'All',     'count' => $count['all'],     'color' => 'info',    'icon' => 'fa-users'],
                    ['name' => 'Clients', 'count' => $count['clients'], 'color' => 'success', 'icon' => 'fa-child'],
                    ['name' => 'Staff',   'count' => $count['staff'],   'color' => 'info',    'icon' => 'fa-user-edit'],
                    ['name' => 'Agent',   'count' => $count['agent'],   'color' => 'purple',  'icon' => 'fa-handshake'],
                    ['name' => 'Regional Manager', 'count' => $count['regional_manager'], 'color' => 'orange',  'icon' => 'fa-tasks'],
                    ['name' => 'Branch Manager', 'count' => $count['branch_manager'], 'color' => 'orange',  'icon' => 'fa-tasks'],
                    ['name' => 'Admin',   'count' => $count['admin'],   'color' => 'warning', 'icon' => 'fa-crown'],
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
        private function StaffGetCount(Request $req) : JsonResponse {
            $count = [
                'clients' => User::role('client')->count(),
                'agent' => User::role('agent')->count(),
                'beneficiaries'=> Beneficiary::count(),
            ];

            $data = [
                ['name' => 'Clients', 'count' => $count['clients'], 'color' => 'success', 'icon' => 'fa-child'],
                ['name' => 'Agent', 'count' => $count['agent'], 'color' => 'warning', 'icon' => 'fa-hands-helping'],
                ['name' => 'Beneficiaries','count' => $count['beneficiaries'],'color' => 'secondary','icon'=> 'fa-users'],
            ];

            return response()->json(['status' => true, 'message' => 'success', 'data' => $data], 200);
        }
}


