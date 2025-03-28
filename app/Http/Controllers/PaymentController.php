<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Role;
use App\Models\User;
use App\Models\CustomerPayment;
use App\Models\RequestPayment;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function index()
    {
        $payments=Payment::get();
        return view('payment.index',compact('payments'));
    }

    public function create()
    {
        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::where('role', $customerRole->id)->get();



        return view('payment.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $params['customer']=$request->customer;
        $params['amount']=$request->amount;
        $params['convert_amount']=$request->convert_amount;
        $params['currency']=$request->currency;
        $params['crypto']=$request->crypto;
        $payment=Payment::create($params);
        return redirect('/payments')->with('success','Payment Created successfully');

    }

    public function edit($id)
    {
        $id=decrypt($id);
        $payment=Payment::find($id);
        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::where('role', $customerRole->id)->get();

        return view('payment.edit',compact('payment','customers'));

    }

    public function update($id,Request $request)
    {
        $payment=Payment::find($id);
        $payment->update([
            'customer'=>$request->customer,
            'amount'=>$request->amount,
            'convert_amount'=>$request->convert_amount,
            'currency'=>$request->currency,
            'crypto'=>$request->crypto
        ]);

        return redirect('/payments')->with('success','Payment Updated successfully');
    }

        
    public function request_payment()
    {
        $data['customers'] = User::where('role','10')->where('status','1')->orderBy('id', 'DESC')->get();

        return view('payment.request_payment',$data);
    }

    public function get_customer_payment(Request $request)
    {
        $cus_pays = CustomerPayment::where('user_id',$request->customer_id)->get();

        $html = '<option value="">Select Customer Payment</option>';
        
        foreach ($cus_pays as $row) {

            $html .= '<option value="' . $row->id . '">' . $row->payment->doman_name . '</option>';

        }

        echo json_encode($html);
    }

    public function requested_payment()
    {
        $data['payment'] = RequestPayment::orderBy('id', 'DESC')->get();

        return view('payment.requested_payment',$data);
    }

    public function request_payment_post(Request $request)
    {
        $params['is_beneficiary']       = $request->beneficiary;
        $params['currency']             = $request->currency;
        $params['customer_id']          = $request->customer_id;
        $params['customer_payment_id']  = $request->customer_payment_id;
        $params['recipient_name']       = $request->recipient_name;
        $params['iban']                 = $request->iban;
        $params['bic']                  = $request->bic;

        $res = RequestPayment::create($params);

        if($res){

            return redirect()->route('request.payment')->with('success','Request payment created successfully');

        } else {

            return redirect()->back()->with('error','Try again.');

        }
    }

    public function change_request_payment_status($id='')
    {

        $res = RequestPayment::find($id);

        if($res->status=='1'){
            $params['status'] = '0'; 
        } else {
            $params['status'] = '1';
        }

        RequestPayment::whereId($id)->update($params);
        
        return redirect()->back()->with('success','Status updated successfully');
    }
}
