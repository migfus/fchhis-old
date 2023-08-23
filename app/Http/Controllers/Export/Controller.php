<?php

namespace App\Http\Controllers\Export;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;
}
