<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $data['datas'] = Network::orderBy('id', 'DESC')->get();

        return view('network.index',$data);
    }

    public function create(Request $request)
    {
        $data['datas'] = Crypto::where('status', '1')->orderBy('id', 'DESC')->get();

        return view('network.create',$data);
    }

    public function store(Request $request)
    {
        $params['crypto_id'] = $request->crypto_id;
        $params['name'] = $request->name;

        $res = Network::create($params);

        if($res){

            return redirect()->route('network')->with('success', 'Network successfully created.');

        } else {

            return redirect()->back()->with('error', 'Try again.');

        }
    }

    public function edit($id='')
    {
        $data['network'] = Network::find($id);

        $data['datas'] = Crypto::where('status', '1')->orderBy('id', 'DESC')->get();

        return view('network.edit',$data);
    }

    public function update(Request $request)
    {
        $params['crypto_id'] = $request->crypto_id;
        $params['name'] = $request->name;

        Network::whereId($request->id)->update($params);

        return redirect()->route('network')->with('success', 'Network successfully update.');
    }

    public function status($id='')
    {
        $data = Network::find($id);

        if($data->status=='1'){
            $params['status'] = '0';
        } else {
            $params['status'] = '1';
        }

        Network::whereId($id)->update($params);

        return redirect()->back()->with('success', 'Status change successfully.');
    }

    public function delete($id='')
    {

        Network::whereId($id)->delete();

        return redirect()->back()->with('success', 'Network delete successfully.');
    }
}
