<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    
    public function index(Request $request)
    {

        $data['datas'] = Crypto::orderBy('id', 'DESC')->get();

        return view('crypto.index',$data);

    }

    public function create(Request $request)
    {
        return view('crypto.create');
    }

    public function store(Request $request)
    {
        $params['crypto'] = $request->crypto;

        $res = Crypto::create($params);

        if($res){

            return redirect()->route('crypto')->with('success', 'Crypto successfully created.');

        } else {

            return redirect()->back()->with('error', 'Try again.');

        }
    }

    public function edit($id='')
    {
        $data['data'] = Crypto::find($id);

        return view('crypto.edit',$data);
    }

    public function update(Request $request)
    {
        $params['crypto'] = $request->crypto;

        Crypto::whereId($request->id)->update($params);

        return redirect()->route('crypto')->with('success', 'Crypto successfully update.');
    }

    public function status($id='')
    {
        $data = Crypto::find($id);

        if($data->status=='1'){
            $params['status'] = '0';
        } else {
            $params['status'] = '1';
        }

        Crypto::whereId($id)->update($params);

        return redirect()->route('crypto')->with('success', 'Status change successfully.');
    }

    public function delete($id='')
    {

        Crypto::whereId($id)->delete();

        return redirect()->route('crypto')->with('success', 'Crypto delete successfully.');
    }

}
