<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class BeneficiaryController extends Controller
{
  // SECTION INDEX
  public function index(Request $req) {
    switch($req->user()->role) {
      case 2:
        return $this->StaffIndex($req);
      case 5:
        return $this->StaffIndex($req);
      default:
        return $this->G_UnauthorizedResponse();
    }

    $val = Validator::make($req->all(), [
      'search' => '',
      'id' => '',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    // NOTE ADMIN/AGENT
    if($req->user()->role == 6) {
      $data = Info::whereNotNull('client_id')
        ->where('name', 'LIKE', '%'.$req->search.'%')
        ->get();
      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
    }

    if($req->user()->role == 5) {
      $data = Beneficiary::where('info_id', User::where('id', $req->id)->first()->info->id)
        ->where(function($q) use($req) {
          $q->where('lastName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('firstName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('midName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('extName', 'LIKE', '%'.$req->search.'%');
        })
      ->get();
      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
    }

  }

  private function StaffIndex($req) {
    $val = Validator::make($req->all(), [
      'search' => '',
      'id' => 'required'
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    $data = Info::with('user')->where('client_id', $req->id)->orderBy('name', 'ASC')->get();

    return response()->json([...$this->G_ReturnDefault(), 'data' => $data]);
  }

  public function store(Request $req) {
    $val = Validator::make($req->all(), [
      'lastName' => 'required',
      'firstName' => 'required',
      'midName' => '',
      'extName' => '',
      'bday' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if($req->user()->role == 6 || $req->user()->role == 4) {
      $ben = Beneficiary::create([
        'info_id' => User::where('id', $req->user()->id)->with('info')->first()->info->id,
        'lastName' => $req->lastName,
        'firstName' => $req->firstName,
        'midName' => $req->midName,
        'extName' => $req->extName,
        'bday' => $req->bday,
      ]);

      return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
    }

    return $this->G_UnauthorizedResponse();
  }

  public function update(Request $req, $id) {
    $val = Validator::make($req->all(), [
      'lastName' => 'required',
      'firstName' => 'required',
      'midName' => '',
      'extName' => '',
      'bday' => 'required',
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if($req->user()->role == 6 || $req->user()->role == 4) {
      if(Beneficiary::where('id', $id)->where('info_id', User::where('id', $req->user()->id)->with('info')->first()->info->id)) {
        $ben = Beneficiary::where('id', $id)->update([
          'lastName' => $req->lastName,
          'firstName' => $req->firstName,
          'midName' => $req->midName,
          'extName' => $req->extName,
          'bday' => $req->bday,
        ]);

      return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);

      }
      return $this->G_UnauthorizedResponse();
    }
    return $this->G_UnauthorizedResponse();
  }


  public function destroy($id, Request $req) {
    if($req->user()->role == 6 || $req->user()->role == 4) {
      if(Beneficiary::where('id', $id)->where('info_id', User::where('id', $req->user()->id)->with('info')->first()->info->id)) {
        $ben = Beneficiary::where('id', $id)->delete();
        return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
      }
      return $this->G_UnauthorizedResponse();
    }

    return $this->G_UnauthorizedResponse();
  }
}
