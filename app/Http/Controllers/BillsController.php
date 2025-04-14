<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillsController extends Controller
{
    public function index(Request $request){

        return view('bills.index',compact('request'));
    }

    public function edit(Request $request){

        return view('bills.edit',compact('request'));
    }
}
