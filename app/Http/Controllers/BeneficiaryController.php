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
        if($req->user()->hasRole('staff') || $req->user()->hasRole('admin')) {
            return $this->StaffIndex($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffIndex($req) {
            $val = Validator::make($req->all(), [
                'search' => '',
                'id' => 'required'
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $data = User::where('client_id', $req->id)->orderBy('name', 'ASC')->get();

            return response()->json([...$this->G_ReturnDefault(), 'data' => $data]);
        }

    public function store(Request $req) {
        if($req->user()->hasRole('admin') || $req->user()->hasRole('staff')) {
            return $this->StaffStore($req);
        }
    }

        private function StaffStore($req) {
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

            if($req->user()->hasRole('client') || $req->user()->hasRole('staff')) {
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

        if($req->user()->hasRole('admin') || $req->user()->hasRole('staff')) {
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
        if($req->user()->hasRole('client') || $req->user()->hasRole('staff')) {
            if(Beneficiary::where('id', $id)->where('info_id', User::where('id', $req->user()->id)->with('info')->first()->info->id)) {
                $ben = Beneficiary::where('id', $id)->delete();
                return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
            }
            return $this->G_UnauthorizedResponse();
        }

        return $this->G_UnauthorizedResponse();
    }
}
