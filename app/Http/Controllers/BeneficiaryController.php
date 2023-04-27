<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class BeneficiaryController extends Controller
{
  public function index(Request $req) {
    $val = Validator::make($req->all(), [
      'search' => ''
    ]);

    if($val->fails()) {
      return $this->G_ValidatorFailResponse($val);
    }

    if($req->user()->role == 6 || $req->user()->role == 4) {
      $data = Beneficiary::where('person_id', User::where('person_id', $req->user()->id)->with('person')->first()->person->id)
        ->where(function($q) use($req) {
          $q->where('lastName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('firstName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('midName', 'LIKE', '%'.$req->search.'%')
            ->orWhere('extName', 'LIKE', '%'.$req->search.'%');
        })
        ->get();
      return response()->json([...$this->G_ReturnDefault($req), 'data' => $data]);
    }

    return $this->G_UnauthorizedResponse();
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
        'person_id' => User::where('id', $req->user()->id)->with('person')->first()->person->id,
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

    /**
     * Display the specified resource.
     */
    public function show(Beneficiary $beneficiary)
    {
        //
    }

  /**
   * Update the specified resource in storage.
   */
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
      if(Beneficiary::where('id', $id)->where('person_id', User::where('id', $req->user()->id)->with('person')->first()->person->id)) {
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
      if(Beneficiary::where('id', $id)->where('person_id', User::where('id', $req->user()->id)->with('person')->first()->person->id)) {
        $ben = Beneficiary::where('id', $id)->delete();
        return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
      }
      return $this->G_UnauthorizedResponse();
    }

    return $this->G_UnauthorizedResponse();
  }
}
