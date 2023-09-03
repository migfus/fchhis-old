<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Beneficiary;

class BeneficiaryController extends Controller
{
    // SECTION INDEX
    public function index(Request $req) : JsonResponse {
        if($req->user()->hasRole('staff') || $req->user()->hasRole('admin')) {
            return $this->StaffIndex($req);
        }

        return $this->G_UnauthorizedResponse();
    }

        private function StaffIndex(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'search' => '',
                'client_id' => 'required'
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            $data = Beneficiary::where('user_id', $req->client_id)->orderBy('name', 'ASC')->get();

            return response()->json([...$this->G_ReturnDefault(), 'data' => $data]);
        }

    public function store(Request $req) : JsonResponse {
        if($req->user()->hasRole('admin') || $req->user()->hasRole('staff')) {
            return $this->StaffStore($req);
        }
    }

        private function StaffStore(Request $req) : JsonResponse {
            $val = Validator::make($req->all(), [
                'name' => 'required',
                'bday' => 'required',
                'client_id' => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if($req->user()->hasRole('client') || $req->user()->hasRole('staff')) {
                $ben = Beneficiary::create([
                    'user_id' => $req->client_id,
                    'staff_id' => $req->user()->id,
                    'name' => $req->name,
                    'bday' => $req->bday,
                ]);

                return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
            }

            return $this->G_UnauthorizedResponse();
        }

    public function update(Request $req, int $id) : JsonResponse {
        if($req->user()->hasRole('admin') || $req->user()->hasRole('staff')) {
            return $this->StaffUpdate($req, $id);
        }
    }
        private function StaffUpdate(Request $req, $id) : JsonResponse {
            $val = Validator::make($req->all(), [
                'name' => 'required',
                'bday' => 'required',
                'client_id' => 'required',
            ]);

            if($val->fails()) {
                return $this->G_ValidatorFailResponse($val);
            }

            if($req->user()->hasRole('client') || $req->user()->hasRole('staff')) {
                $ben = Beneficiary::where('id', $id)
                    ->where('user_id', $req->client_id)
                    ->update([
                        'name' => $req->name,
                        'bday' => $req->bday,
                    ]);

                if(!$ben) {
                    return $this->G_UnauthorizedResponse();
                }

                return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
            }

            return $this->G_UnauthorizedResponse();
        }


    public function destroy(int $id, Request $req) : JsonResponse {
        if($req->user()->hasRole('staff')) {
            $ben = Beneficiary::where('id', $id)->delete();
            return response()->json([...$this->G_ReturnDefault(), 'data' => $ben]);
        }

        return $this->G_UnauthorizedResponse();
    }
}
