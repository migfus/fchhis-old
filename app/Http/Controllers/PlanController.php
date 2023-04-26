<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
  private function PlanCount($req) {
    return response()->json([
      ...$this->G_ReturnDefault($req),
      'data' => Plan::withCount(['users'])->orderBy('users_count', 'DESC')->get()
    ]);
  }

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
    if($req->user()->role == 2) {
      switch($req->filter) {
        case 'desc':
          $data = $plan->where('desc', 'LIKE', '%' . $req->search .'%')->get();
          break;
        case 'user':
          $data = $plan->with('user')->whereRelation('username', 'LIKE', '%' . $req->search .'%')->get();
        default:
          $data = $plan->where('name', 'LIKE', '%' . $req->search .'%')->get();
      }
      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function store(Request $req) {
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

    return $this->G_UnauthorizedResponse();
  }

  public function show(string $id) {
      //
  }

  public function update(Request $req, string $id) {
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


    if(Plan::where('id', $id)->avatar != $req->avatar) {
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

  public function destroy(Request $req, string $id) {
    if($req->user()->role == 2) {
      Plan::where('id', $id)->delete();

      return response()->json([...$this->G_ReturnDefault($req), 'data' => 1]);
    }

    return $this->G_UnauthorizedResponse();
  }
}
