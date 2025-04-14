<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,Role,CurrencyExchange};

class AccountantsController extends Controller
{
    public function index(Request $request)
    {

         $users = User::query();
         $roles = Role::all();

        if ($request->search) {
        $users = $users->where('name', 'like', '%' . $request->search . '%');
        }
        $users = $users->whereHas('role', function ($query) {
            $query->where('name', 'Customer');
        })->orderBy('id', 'desc')->paginate(10);

        return view('accountants.index', compact('users', 'request', 'roles'));
    }

    public function Viewmore($id)
    {
        $id = decrypt($id);
        $user = User::find($id); 
        return view('accountants.view_more', compact('user'));
    }


    public function store(Request $request)
    {
        $params['vendor'] = $request->vendor;
        $params['bill_date'] = $request->bill_date;
        $params['bill'] = $request->bill;
        $params['due_date'] = $request->due_date;
        $params['currency'] = $request->currency;
        $params['note'] = $request->note;
        CurrencyExchange::create($params);
        return redirect('accounts')->with('success', 'Currency Exchange Create successfully.');
    }




    
}




   

    

    


    

    
 