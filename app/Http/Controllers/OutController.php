<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OutControllerController extends Controller
{

    public function __construct()
    {

    }
    
    public function index()
    {
      return view('welcome');
    }
}
