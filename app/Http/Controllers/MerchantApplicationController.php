<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{MerchantBusinessInformation,MerchantCommission,MerchantFinancialInformation,PaymentMethod,Countrie};

class MerchantApplicationController extends Controller
{

    public function index(Request $request)
    {
        $data['datas'] = MerchantBusinessInformation::orderBy('id', 'DESC')->get();

        return view('PYY.index', $data);
    }

    public function form(Request $request)
    {
        $data['payments'] = PaymentMethod::where('status', '1')->get();
        $data['countrie'] = Countrie::get();
        
        return view('PYY.create', $data);
    }

    public function store(Request $request)
    {
        $params['name']         = $request->name;
        $params['email']        = $request->email;
        $params['phone']        = $request->phone;
        $params['password']     = Hash::make($request->password);
        $params['website_URL']  = $request->website_URL;

        $res = MerchantBusinessInformation::create($params);

        if($res){

            if($request->form_count){

                foreach ($request->form_count as $key => $form_count) {

                    $pparams['merchant_business_info_id']       = $res->id;
                    $pparams['trans_id']                        = $request->trans_id[$key];
                    $pparams['date_time']                       = $request->date_time[$key];
                    $pparams['invoice_number']                  = $request->invoice_number[$key];
                    $pparams['invoice_number']                  = $request->invoice_number[$key];
                    $pparams['amount_paid']                     = $request->amount_paid[$key];
                    $pparams['client_fee_commission']           = $request->client_fee_commission[$key];
                    $pparams['rolling_reserves']                = $request->rolling_reserves[$key];
                    $pparams['rolling_reserves_released_days']  = $request->rolling_reserves_released_days[$key];
                    $pparams['rolling_reserves_cap']            = $request->rolling_reserves_cap[$key];
                    $pparams['chargebacks']                     = $request->chargebacks[$key];
                    $pparams['refunds']                         = $request->refunds[$key];
                    $pparams['partial_refunds']                 = $request->partial_refunds[$key];
                    $pparams['PSP_fees_1']                      = $request->PSP_fees_1[$key];
                    $pparams['PSP_transaction_fees_1']          = $request->PSP_transaction_fees_1[$key];
                    $pparams['PSP_fees_2']                      = $request->PSP_fees_2[$key];
                    $pparams['PSP_transaction_fees_2']          = $request->PSP_transaction_fees_2[$key];
                    $pparams['PSP_fees_3']                      = $request->PSP_fees_3[$key];
                    $pparams['PSP_transaction_fees_3']          = $request->PSP_transaction_fees_3[$key];
                    $pparams['PSP_fees_4']                      = $request->PSP_fees_4[$key];
                    $pparams['PSP_transaction_fees_4']          = $request->PSP_transaction_fees_4[$key];
                    $pparams['agent_1']                         = $request->agent_1[$key];
                    $pparams['agent_2']                         = $request->agent_2[$key];
                    $pparams['agent_3']                         = $request->agent_3[$key];
                    $pparams['agent_4']                         = $request->agent_4[$key];
                    $pparams['PYY_share_50_p']                  = $request->PYY_share_50[$key];
                    $pparams['limegrove_share_50_p']            = $request->limegrove_share_50[$key];
                    $pparams['sanabil_share_50_p']              = $request->sanabil_share_50[$key];
                    $pparams['gateway_fees']                    = $request->gateway_fees[$key];
                    $pparams['crypto_settlement_USDT']          = $request->crypto_settlement_USDT[$key];
                    $pparams['fial_settlement']                 = $request->fial_settlement[$key];
                    $pparams['chargebacks_fees']                = $request->chargebacks_fees[$key];
                    $pparams['refunds_fees']                    = $request->refunds_fees[$key];
                    $pparams['partial_refunds_fees']            = $request->partial_refunds_fees[$key];
                    $pparams['cents_per_trans']                 = $request->cents_per_trans[$key];

                    MerchantCommission::create($pparams);
                }

            }  

            $mparams['merchant_business_info_id']   = $res->id;
            $mparams['payment_gateway']             = $request->payment_gateway;
            $mparams['is_live']                     = $request->is_live;
            $mparams['request_URL']                 = $request->request_URL;
            $mparams['return_URL']                  = $request->return_URL;
            $mparams['country']                     = $request->country;
            $mparams['amount_limit']                = $request->amount_limit;
            $mparams['currency']                    = $request->currency;
            $mparams['is_active']                   = $request->is_active;

            MerchantFinancialInformation::create($mparams);

            return redirect()->route('merchant.application')->with('success','Data insert successfully');

        } else {

            return redirect()->back()->with('error','Try Again.');

        }

    }

    public function edit($id='')
    {
        $id = decrypt($id);

        $data['data'] = MerchantBusinessInformation::find($id);

        $data['payments'] = PaymentMethod::where('status', '1')->get();

        $data['countrie'] = Countrie::get();

        $data['commission'] = MerchantCommission::where('merchant_business_info_id', $id)->get();

        $data['financial'] = MerchantFinancialInformation::where('merchant_business_info_id', $id)->first();

        return view('PYY.edit', $data);
    }

    public function detail($id='')
    {
        $id = decrypt($id);

        $data['data'] = MerchantBusinessInformation::find($id);

        $data['commission'] = MerchantCommission::where('merchant_business_info_id', $id)->get();

        $data['financial'] = MerchantFinancialInformation::where('merchant_business_info_id', $id)->first();

        return view('PYY.detail', $data);
    }
}
