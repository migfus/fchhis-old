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

  public function PlanCount($req) {
    return response()->json([...$this->ReturnDefault($req->user()->role), 'data' => Plan::get()]);
  }

  public function index(Request $req, Plan $plan)
  {
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

    $this->UnauthorizedResponse();
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
