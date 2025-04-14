<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index(Request $request){

        return view('transfer.index',compact('request'));
    }

    public function edit(Request $request){


        return view('transfer.edit',compact('request'));
    }
}
