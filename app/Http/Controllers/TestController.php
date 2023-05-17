<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Carbon\Carbon;

class TestController extends Controller
{
  public function index() {
    $data = Person::wherePerson('fulfilled_at')->get();

    return response()->json(['data' => $data]);
  }
}
