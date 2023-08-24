<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayType;

class PayTypeController extends Controller
{
    public function index(Request $req) {
        return response()->json([
            ...$this->G_ReturnDefault($req),
            'data' => PayType::get()
        ]);
    }
}
