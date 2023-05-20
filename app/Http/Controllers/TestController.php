<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMailer;

class TestController extends Controller
{
  public function index() {
    $mail = 'migfus20@gmail.com';
    $data = [
      'link' => 'https://google.com/account',
      'code' => '123456'
    ];
    Mail::to($mail)->send(new ForgotPasswordMailer($data));
  }
}
