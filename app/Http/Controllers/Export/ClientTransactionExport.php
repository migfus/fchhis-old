<?php

namespace App\Http\Controllers\Export;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ClientTransactionExport extends Controller
{
  public function index(Request $req) {
    return $req->user()->id;
  }
}
