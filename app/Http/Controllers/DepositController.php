<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index(Request $request){

        return view('deposit.index',compact('request'));
    }

    public function edit(Request $request){

        return view('deposit.edit',compact('request'));
    }
}
