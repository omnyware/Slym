<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function index(Request $request){
    	return response()->json('ok', 200);

    }
}
