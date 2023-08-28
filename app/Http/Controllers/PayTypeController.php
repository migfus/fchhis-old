<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayType;
use Illuminate\Http\JsonResponse;

class PayTypeController extends Controller
{
    public function index(Request $req) : JsonResponse {
        return response()->json([
            ...$this->G_ReturnDefault($req),
            'data' => PayType::get()
        ]);
    }
}
