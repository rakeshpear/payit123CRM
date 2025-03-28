<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request){

        return view('expense.index',compact('request'));
    }

    public function edit(Request $request){

        return view('expense.edit',compact('request'));
    }
}
