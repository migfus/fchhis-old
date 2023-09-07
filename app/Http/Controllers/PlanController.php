<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PlanDetails;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function index(Request $req, Plan $plan) {
        if ($req->count)
            return $this->PlanCount($req);

        $val = Validator::make($req->all(), [
            'search' => '',
            'filter' => 'required'
        ]);

        if($val->fails()) {
            return $this->G_ValidatorFailResponse($val);
        }

        $data;
        if($req->user()->hasRole('admin') || $req->user()->hasRole('staff')) {
            switch($req->filter) {
                case 'desc':
                    $data = $plan
                        ->with(['plan_details'])
                        ->whereHas('plan_details', function($q) use($req) {
                            $q->where('desc', 'LIKE', '%' . $req->search .'%');
                        })
                        ->orderBy('created_at', 'DESC')->get();
                    break;
                default:
                    $data = $plan->with(['plan_details'])->where('name', 'LIKE', '%' . $req->search .'%')->orderBy('created_at', 'DESC')->get();
            }
            return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function PlanCount(Request $req) : JsonResponse {
            return response()->json([
                ...$this->G_ReturnDefault($req),
                'data' => Plan::withCount(['infos'])->orderBy('infos_count', 'DESC')->get()
            ]);
        }

    public function store(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminStore($req);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function AdminStore(Request $req) : JsonResponse {
            if($req->user()->role == 2) {
                $val = Validator::make($req->all(), [
                    'avatar' => '',
                    'desc' => '',

                    'name' => 'required',
                    'start' => 'required',
                    'end' => 'required',

                    'contract_price' => 'required',
                    'spot_service' => 'required',
                    'spot_payment' => 'required',

                    'annual' => 'required',
                    'semi_annual' => 'required',
                    'quarterly' => 'required',
                    'monthly' => 'required',
                ]);

                if($val->fails()) {
                    return $this->G_ValidatorFailResponse($val);
                }

                $avatar = null;
                if($req->avatar) {
                    $avatar = $this->G_AvatarUpload($req->avatar);
                }

                $plan = Plan::create([
                    'avatar' => $avatar,
                    'name' => $req->name,
                    'age_start' => $req->start,
                    'age_end' => $req->end,
                    'desc' => $req->desc,
                    'contract_price' => $req->contract_price,
                    'spot_pay' => $req->spot_payment,
                    'spot_service' => $req->spot_service,
                    'user_id' => $req->user()->id,
                    'annual' => $req->annual,
                    'semi_annual' => $req->semi_annual,
                    'quarterly' => $req->quarterly,
                    'monthly' => $req->monthly
                ]);
                return response()->json([...$this->G_ReturnDefault($req), 'data' => $plan]);
            }
        }

    public function show(int $id) {
        //
    }

    public function update(Request $req, int $id) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminUpdate($req, $id);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function AdminUpdate(Request $req, int $id) : JsonResponse {
            $val = Validator::make($req->all(), [
                'avatar' => '',
                'desc' => '',

                'name' => 'required',
                'age_start' => 'required',
                'age_end' => 'required',

                'contract_price' => 'required',
                'spot_service' => 'required',
                'spot_pay' => 'required',

                'annual' => 'required',
                'semi_annual' => 'required',
                'quarterly' => 'required',
                'monthly' => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if(Plan::where('id', $id)->first()->avatar != $req->avatar) {
                Plan::where('id', $id)->update(['avatar' => $this->G_AvatarUpload($req->avatar)]);
            }

            $plan = Plan::where('id', $id)->update([
                'name' => $req->name,
                'age_start' => $req->age_start,
                'age_end' => $req->age_end,
                'desc' => $req->desc,
                'contract_price' => $req->contract_price,
                'spot_pay' => $req->spot_pay,
                'spot_service' => $req->spot_service,
                'annual' => $req->annual,
                'semi_annual' => $req->semi_annual,
                'quarterly' => $req->quarterly,
                'monthly' => $req->monthly
            ]);
            return response()->json([...$this->G_ReturnDefault($req), 'data' => $plan]);
        }

    public function destroy(Request $req, int $id) : JsonResponse {
        if($req->user()->hasRole('admin')) {
            return $this->AdminDestroy($req, $id);
        }

        return $this->G_UnauthorizedResponse();
    }
        private function AdminDestroy(Request $req, int $id) : JsonResponse {
            Plan::where('id', $id)->delete();
            return response()->json([...$this->G_ReturnDefault($req), 'data' => 1]);
        }
}
