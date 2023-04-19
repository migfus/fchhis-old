<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
  private function ReturnDefault($role) {
    return ['status' => true, 'message' => 'success', 'role' => $role];
  }

  private function ValidateInputResponse($req, $role = []) {
    $val = Validator::make($req->all(), $role);

    if($val->fails()) {
      return response()->json(['status' => false, 'message' => 'Invalid Input' ], 401);
    }
  }

  private function UnauthorizedResponse() {
    return response()->json(['status' => false, 'message' => 'Logout'], 401);
  }

  private function AvatarUpload($req) {
    $image = $req->avatar;
    list($type, $image) = explode(';', $image);
    list(, $image) = explode(',', $image);

    $image = base64_decode($image);
    $imageName = time(). '.jpg';
    $location = '/uploads/'.$imageName;
    file_put_contents('uploads/'.$imageName, $image);

    return $location;
  }

  public function PlanCount($req) {
    return response()->json([
      ...$this->ReturnDefault($req->user()->role),
      'data' => Plan::withCount(['users'])->orderBy('users_count', 'DESC')->get()
    ]);
  }

  public function index(Request $req, Plan $plan) {
    if ($req->count)
      return $this->PlanCount($req);

    $this->ValidateInputResponse($req, [
      'search' => '',
      'filter' => 'required'
    ]);

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
      return response()->json([...$this->ReturnDefault($req->user()->role), 'data' => $data]);
    }

    return $this->UnauthorizedResponse();
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
        return response()->json(['status' => false, 'message' => 'Invalid Input', 'errors' => $val->errors() ], 401);
      }

      $avatar = null;
      if($req->avatar) {
        $avatar = $this->AvatarUpload($req);
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
      ]);
      return response()->json([...$this->ReturnDefault($req->user()->role), 'data' => $plan]);
    }

    return $this->UnauthorizedResponse();
  }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $req, string $id)
  {
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
      return response()->json(['status' => false, 'message' => 'Invalid Input', 'errors' => $val->errors() ], 401);
    }


    if(Plan::where('id', $id)->avatar != $req->avatar) {
      Plan::where('id', $id)->update(['avatar' => $this->AvatarUpload($req)]);
    }

    $plan = Plan::where('id', $id)->update([
      'name' => $req->name,
      'age_start' => $req->age_start,
      'age_end' => $req->age_end,
      'desc' => $req->desc,
      'contract_price' => $req->contract_price,
      'spot_pay' => $req->spot_pay,
      'spot_service' => $req->spot_service,
    ]);
    return response()->json([...$this->ReturnDefault($req->user()->role), 'data' => $plan]);

  }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req, string $id)
    {
      if($req->user()->role == 2) {
        Plan::where('id', $id)->delete();

        return response()->json([...$this->ReturnDefault($req->user()->role), 'data' => 1]);
      }

      return $this->UnauthorizedResponse();
    }
}
