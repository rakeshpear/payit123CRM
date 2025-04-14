<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Countrie;
use App\Models\Currencies;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['payments'] = PaymentMethod::orderBy('id', 'desc')->paginate(10);
        return view('payment_method.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['country'] = Countrie::all();
        $data['currencies'] = Currencies::all();
        $data['crypto'] = Crypto::where('status', '1')->orderBy('id', 'DESC')->get();

        return view('payment_method.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params['psp_time_minute'] = $request->psp_time_minute;
        $params['doman_name'] = $request->doman_name;
        $params['payment_gateway'] = $request->payment_gateway;
        $params['payment_key'] = $request->payment_key;
        $params['payment_secret'] = $request->payment_secret;
        $params['merchant_id'] = $request->merchant_id;
        $params['status'] = $request->status == 'on' ? '1' : '0';
        $params['country'] = json_encode($request->country);
        $params['currency'] = json_encode($request->currency);
        $params['is_live_key'] = $request->live_key == 'Yes' ? 'Yes' : 'No';
        $params['test_payment_key'] = $request->test_payment_key;
        $params['test_payment_secret'] = $request->test_payment_secret;
        $params['test_merchant_id'] = $request->test_merchant_id;
        $params['three_d'] = $request->three_d;
        $params['two_d_three_d'] = $request->two_d_three_d == 'Yes' ? 'Yes' : 'No';
        $params['sale_end_point'] = $request->sale_end_point;
        $params['get_end_point'] = $request->get_end_point;
        $params['url'] = $request->url;
        $params['live_request_url'] = $request->live_request_url;
        $params['test_request_url'] = $request->test_request_url;
        $params['live_return_url'] = $request->live_return_url;
        $params['test_return_url'] = $request->test_return_url;
        $params['min_amount'] = $request->min_amount;
        $params['max_amount'] = $request->max_amount;

        $params['label_name'] = [];
        $params['label_key'] = [];

        foreach ($request->label_name as $index => $item) {
            $params['label_name'][] = $request->label_name[$index];
            $params['label_key'][] = $request->label_key[$index];
        }

        $params['label_name'] = json_encode($params['label_name']);
        $params['label_key'] = json_encode($params['label_key']);

        PaymentMethod::create($params);

        return redirect()->route('payment.method')->with('success', 'Payment method successfully created.');
    }


    /**
     * Display the specified resource.
     */
    public function status($status, $id)
    {
        $params['status'] = $status;
        PaymentMethod::whereId($id)->update($params);
        return redirect()->back()->with('success', 'Payment status change successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $payment = PaymentMethod::find($id);


        if($payment){
            $data['payment'] = $payment;
            $data['country'] = Countrie::all();
            $data['currencies'] = Currencies::all();
            return view('payment_method.edit',$data);


        } else {
            return redirect()->back()->with('error', 'Data not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $params['psp_time_minute']  = $request->psp_time_minute;
        $params['doman_name']       = $request->doman_name;
        $params['payment_gateway']  = $request->payment_gateway;
        $params['payment_key']      = $request->payment_key;
        $params['payment_secret']   = $request->payment_secret;
        $params['merchant_id']      = $request->merchant_id;
        $params['status']           = $request->status=='on'?'1':'0';
        $params['country']          = json_encode($request->country);
        $params['currency']         = json_encode($request->currency);
        $params['is_live_key']      = $request->live_key=='Yes'?'Yes':'No';
        $params['test_payment_key']      = $request->test_payment_key;
        $params['test_payment_secret']   = $request->test_payment_secret;
        $params['test_merchant_id']      = $request->test_merchant_id;
        $params['three_d']               = $request->three_d;
        $params['two_d_three_d']         = $request->two_d_three_d=='Yes'?'Yes':'No';
        $params['sale_end_point']        = $request->sale_end_point;
        $params['get_end_point']         = $request->get_end_point;
        $params['url']                   = $request->url;
        $params['live_request_url']         = $request->live_request_url;
        $params['test_request_url']         = $request->test_request_url;
        $params['live_return_url']         = $request->live_return_url;
        $params['test_return_url']         = $request->test_return_url;
        $params['min_amount']         = $request->min_amount;
        $params['max_amount']         = $request->max_amount;

        $params['label_name'] = [];
        $params['label_key'] = [];

        foreach ($request->label_name as $index => $item) {
            $params['label_name'][] = $request->label_name[$index];
            $params['label_key'][] = $request->label_key[$index];
        }

        $params['label_name'] = json_encode($params['label_name']);
        $params['label_key'] = json_encode($params['label_key']);
      
        PaymentMethod::whereId($request->id)->update($params);

        return redirect()->route('payment.method')->with('success', 'Payment mathod successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
