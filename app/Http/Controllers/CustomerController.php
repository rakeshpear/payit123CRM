<?php

namespace App\Http\Controllers;

use App\Exports\ClientTransactionExport;
use App\Models\Countrie;
use App\Models\Role;
use App\Models\User;
use App\Models\{Task, TaskWorkingHours, Timer, CommissionSchedule, Charges, Customers, ClientDetails, ClientSettlementLog, PaymentMethod, ClientPayment, PayOrdersVernapayment, CustomerPayment, ClientTransaction, ExportClientTransaction};
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request, $id)
    {

        Session::forget('agentid');

        $rolesToInclude = ['Customer'];

        $users = User::where('registered_by', $id)->whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->orderBy('id', 'desc')->paginate(10);

        $agent = User::find($id);

        Session::put('agentid', $agent->id);

        return view('agentcustomers.index', compact('users', 'request', 'agent'));
    }

    public function create($id)
    {

        $role = Role::where('name', 'Customer')->first();

        $agentid = $id;

        // return view('agentcustomers.create',compact('role','agentid'));

        $payment    = PaymentMethod::where('status', '1')->get();

        $country    = Countrie::all();

        $rolesToInclude = ['Agent'];

        $users = User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->get();

        return view('adminclients.create', compact('role', 'payment', 'country', 'agentid', 'users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'role'         => 'required',
            'email'        => 'required|email|unique:users',
            'password'     => 'required',
        ]);

        $params['name'] = $request->name;
        $params['role'] = $request->role;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['registered_by'] = $request->registered_by;
        $params['password'] = Hash::make($request->password);
        $user = User::create($params);
        $user->assignRole($request->role);

        if ($user) {

            $data['client_id'] = $user->id;
            $data['agent_commission'] = $request->agent_commission;
            $data['client_commission'] = $request->client_commission;
            $data['extra_client_fee'] = $request->extra_client;
            $data['crypto_fee'] = $request->crypto_fee;
            $data['chargeback_fee'] = $request->chargeback_fee;
            $data['refund_fee'] = $request->refund_fee;
            $data['highRisk_fee'] = $request->highRisk_fee;
            $data['fraudWarning_fee'] = $request->fraudWarning_fee;
            $data['rolling_reserve'] = $request->rolling_reserve;
            $data['transaction_fee'] = $request->transaction_fee;
            $data['currency'] = $request->currency;

            ClientDetails::create($data);
        }

        return redirect()->route('agent.view.more', ['id' => encrypt($request->registered_by)])->with('success', 'Customer Create successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);

        $user = User::find($id);

        $rolesToInclude = ['Agent'];

        $agents = User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->get();

        $client_details = ClientDetails::where('client_id', $user->id)->first();

        $client_details['agents'] = json_decode($client_details->agents);

        return view('agentcustomers.edit', compact('user', 'client_details', 'agents'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name'         =>  'required',
            'email'        =>  'required|email|unique:users,email,' . $id,
        ]);

        $user = User::find($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        $user->update($data);

        if ($user) {

            $client = ClientDetails::where('client_id', $user->id)->first();


            $info = [

                'currency'          => $request->currency,
                'agent_commission'  => $request->agent_commission,
                'client_commission' => $request->client_commission,
                'extra_client_fee'  => $request->extra_client,
                'crypto_fee'        => $request->crypto_fee,
                'chargeback_fee'    => $request->chargeback_fee,
                'refund_fee'        => $request->refund_fee,
                'highRisk_fee'      => $request->highRisk_fee,
                'fraudWarning_fee'  => $request->fraudWarning_fee,
                'rolling_reserve'   => $request->rolling_reserve,
                'transaction_fee'   => $request->transaction_fee,
                'psp'               => $request->psp,
                'agents'            => json_encode($request->agents),
                'payit123share'     => $request->payit123share

            ];

            $client->update($info);
        }

        return redirect()->route('customer.index', ['id' => $user->registered_by])->with('success', 'Customer Edit successfully.');
    }

    public function delete($id)
    {
        $id = decrypt($id);

        $user = User::find($id);

        $client = ClientDetails::where('client_id', $user->id)->delete();

        $agentid = $user->registered_by;

        $user->delete();

        return redirect()->route('agent.view.more', ['id' => encrypt($agentid)])->with('error', 'Customer deleted successfully.');
    }

    public function Customer_Viewmore($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        $client_transactions = ClientTransaction::where('user_name', $users->name)->orderBy('id', 'DESC')->get();

        if (!$users) {
            return redirect()->route('error.page')->with('message', 'User not found');
        }

        return view('agentcustomers.customeraccount', compact('users', 'client_transactions'));
    }

    public function export_client_transaction(Request $request)
    {

        foreach (ExportClientTransaction::all() as $key => $value) {
            $value->delete();
        }

        $qa = ClientTransaction::query();

        if ($request->merchent) {
            $qa->where('user_name', $request->merchent);
        }

        if ($request->to_date != '' || $request->from_date != '') {
            $qa->whereBetween('transaction_date', [$request->to_date, $request->from_date]);
        }

        $client_transactions = $qa->get();

        // $client_transactions = ClientTransaction::where('user_name', $users->name)->get();

        if ($client_transactions) {

            foreach ($client_transactions as $key => $item) {

                $users = User::where('name', $item->user_name)->first();

                $params['user_id'] = $users->id;
                $params['transaction_id'] = $item->transaction_id;
                $params['transaction_date'] = date("d-m-Y", strtotime($item->transaction_date));
                $params['status'] = $item->status;
                $params['currency'] = $item->currency;
                $params['amount'] = number_format($item->amount, 2);

                if ($users && $users->clientDetails) {
                    $client_commission = $users->clientDetails->client_commission;
                } else {
                    $client_commission = '0';
                }

                $fee = ($client_commission / 100) * $item->amount;

                $params['fee'] = number_format($fee, 2);

                $before_roll_rec = $item->amount - $fee;

                $params['before_roll_rec'] = number_format($before_roll_rec, 2);

                if ($users && $users->clientDetails) {
                    $rolling_reserve = $users->clientDetails->rolling_reserve;
                } else {
                    $rolling_reserve = '0';
                }

                $rolling_rec_per = ($rolling_reserve / 100) * $item->amount;

                $params['rolling_rec_per'] = number_format($rolling_rec_per, 2);

                $payable_to_clnt = $before_roll_rec - $rolling_rec_per;

                $params['payable_to_clnt'] = number_format($payable_to_clnt, 2);

                $PSP_fees = (5.21 / 100) * $item->amount;

                $params['PSP_fees'] = number_format($PSP_fees, 2);

                $net_after_PSP = $item->amount - $before_roll_rec - $PSP_fees;

                $params['net_after_PSP'] = number_format($net_after_PSP, 2);

                $PP_frnd = (0.10 / 100) * $item->amount;

                $params['PP_frnd'] = number_format($PP_frnd, 2);

                $majestic = (0.50 / 100) * $item->amount;

                $params['majestic'] = number_format($majestic, 2);

                $limegrove =  (50.00 / 100) * ($net_after_PSP - $majestic - $PP_frnd);

                $params['limegrove'] = number_format($limegrove, 2);

                $params['invoice'] = $item->invoice;

                ExportClientTransaction::create($params);
            }

            return Excel::download(new ClientTransactionExport(), 'ClientTransaction.xlsx');
        } else {
            return back()->with('message', 'Data not found');;
        }
    }

    public function Agent_Customer_Transaction($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        return view('agentcustomers.transaction', compact('users'));
    }

    public function Agent_Customer_Refunded($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        return view('agentcustomers.refunded', compact('users'));
    }

    public function Agent_Customer_Chargeback($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        return view('agentcustomers.chargeback', compact('users'));
    }



    // individual customer account

    public function Customer_Account(Request $request)
    {
        $id = Auth::user()->id;

        $users = User::find($id);

        if (!$users) {
            return redirect()->route('error.page')->with('message', 'User not found');
        }

        return view('customer.account', compact('users', 'request'));
    }

    public function Customer_Transaction(Request $request, $id)
    {

        $id = decrypt($id);

        $users = User::find($id);

        return view('customer.transaction', compact('users', 'request'));
    }

    public function Customer_Refunded($id)
    {

        $id = decrypt($id);

        $users = User::find($id);

        return view('customer.refunded', compact('users'));
    }

    public function Customer_Chargeback($id)
    {

        $id = decrypt($id);

        $users = User::find($id);

        return view('customer.chargeback', compact('users'));
    }


    // Admin Client Functions
    public function Admin_Client_Index(Request $request)
    {
        $rolesToInclude = ['Customer'];

        $users = User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->orderBy('id', 'DESC')->paginate(10);

        $settlementLogs = ClientSettlementLog::get() ?? collect();

        return view('adminclients.index', compact('users', 'request', 'settlementLogs'));
    }

    public function create_Client_Create($id = '')
    {
        $id         = decrypt($id);

        $client     = User::find($id);

        $payment    = PaymentMethod::where('status', '1')->get();

        $country    = Countrie::all();

        return view('adminclients.client_payment_create', compact('client', 'payment', 'country'));
    }

    public function Admin_Client_Create()
    {
        $role = Role::where('name', 'Customer')->first();

        $payment    = PaymentMethod::where('status', '1')->get();

        $rolesToInclude = ['Agent'];

        $users = User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->get();

        $country    = Countrie::all();

        $agentid = '';

        return view('adminclients.create', compact('role', 'payment', 'country', 'agentid', 'users'));
    }

    public function Admin_Client_Store(Request $request)
    {

        $this->validate($request, [
            'name'         => 'required',
            'role'         => 'required',
            'email'        => 'required|email|unique:users',
            'password'     => 'required',
        ]);

        $params['name'] = $request->name;
        $params['role'] = $request->role;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['marchant_id'] = $request->marchant_id;
        $params['merchant_active'] = $request->merchant_active == 'on' ? '1' : '0';
        $params['registered_by'] = $request->registered_by;
        $params['password'] = Hash::make($request->password);
        $user = User::create($params);
        $user->assignRole($request->role);

        if ($user) {

            $data['client_id']                  = $user->id;
            // $data['agent_commission']        = $request->agent_commission;
            $data['client_commission']          = $request->client_commission;
            $data['extra_client_fee']           = $request->extra_client;
            $data['crypto_fee']                 = $request->crypto_fee;
            $data['chargeback_fee']             = $request->chargeback_fee;
            $data['refund_fee']                 = $request->refund_fee;
            $data['highRisk_fee']               = $request->highRisk_fee;
            $data['fraudWarning_fee']           = $request->fraudWarning_fee;
            $data['before_rolling_reserve']     = $request->before_rolling_reserve;
            $data['rolling_reserve']            = $request->rolling_reserve;
            $data['payabletoclient']            = $request->payabletoclient;
            $data['net_after_psp_client']       = $request->net_after_psp_client;
            $data['transaction_fee']            = $request->transaction_fee;
            $data['psp']                        = $request->psp;
            $data['agents']                     = json_encode($request->agents);
            $data['payit123share']              = $request->payit123share;
            // $data['currency']                = $request->currency;
            // $data['amount_limit']            = $request->amount_limit;
            // $data['card_limit']              = $request->card_limit;

            $client = ClientDetails::create($data);

            foreach ($request->payment_gateway_id as $key => $payment_id) {

                $index_no = $request->new_row[$key];

                $is_liv = 'is_live_' . $index_no;
                $cou = 'country_' . $index_no;
                $is_ac = 'is_active_' . $index_no;

                $cp_params['client_id']             = $client->id;
                $cp_params['user_id']               = $user->id;
                $cp_params['payment_gateway_id']    = $payment_id;
                $cp_params['is_live']               = $request->$is_liv;
                $cp_params['request_url']           = $request->request_url[$key];
                $cp_params['return_url']            = $request->return_url[$key];
                $cp_params['country']               = json_encode($request->$cou);
                $cp_params['amount_limit']          = $request->amount_limit[$key];
                $cp_params['currency']              = $request->currency[$key];
                $cp_params['is_active']             = $request->$is_ac;

                if (CustomerPayment::where('user_id', $user->id)->where('client_id', $client->id)->where('payment_gateway_id', $payment_id)->count()) {
                    CustomerPayment::where('user_id', $user->id)->where('client_id', $client->id)->where('payment_gateway_id', $payment_id)->update($cp_params);
                } else {
                    CustomerPayment::create($cp_params);
                }
            }
        }

        return redirect()->route('admin.allclients')->with('success', 'Customer Create successfully.');
    }

    public function Admin_Client_Edit($id)
    {

        $id = decrypt($id);

        $user = User::find($id);

        $payment = PaymentMethod::where('status', '1')->get();

        $client_details = ClientDetails::where('client_id', $user->id)->first();

        $client_details['agents'] = json_decode($client_details->agents);

        $client_payment = ClientPayment::where('user_id', $user->id)->where('client_id', $client_details->id)->get();

        $client_payment_ids = [];

        $rolesToInclude = ['Agent'];

        $agents = User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->get();

        foreach ($client_payment as $key => $value) {
            array_push($client_payment_ids, $value->payment_moad_id);
        }
        return view('adminclients.edit', compact('user', 'client_details', 'payment', 'client_payment_ids', 'agents'));
    }

    public function Admin_Client_Update($id, Request $request)
    {


        $this->validate($request, [
            'name'         =>  'required',
            'email'        =>  'required|email|unique:users,email,' . $id,
        ]);

        $user = User::find($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'marchant_id' => $request->marchant_id,
            'merchant_active' => $request->merchant_active == 'on' ? '1' : '0'
        ];

        $user->update($data);

        if ($user) {

            $client = ClientDetails::where('client_id', $user->id)->first();


            $info = [

                'currency'          => $request->currency,
                // 'agent_commission'  => $request->agent_commission,
                'client_commission' => $request->client_commission,
                'rolling_reserve'   => $request->rolling_reserve,
                'crypto_fee'        => $request->crypto_fee,
                'chargeback_fee'    => $request->chargeback_fee,
                'refund_fee'        => $request->refund_fee,
                'highRisk_fee'      => $request->highRisk_fee,
                'fraudWarning_fee'  => $request->fraudWarning_fee,
                'transaction_fee'   => $request->transaction_fee,
                'amount_limit'      => $request->amount_limit,
                'card_limit'        => $request->card_limit,

            ];

            $info['psp']            = $request->psp;
            $info['agents']         = json_encode($request->agents);
            $info['payit123share']  = $request->payit123share;

            $client->update($info);

            if ($request->payment_gateway_id) {
                foreach ($request->payment_gateway_id as $key => $payment_id) {

                    $cp_params['payment_moad_id'] = $payment_id;

                    if (ClientPayment::where('client_id', $client->id)->where('user_id', $user->id)->where('payment_moad_id', $payment_id)->first()) {

                        ClientPayment::where('client_id', $client->id)->where('user_id', $user->id)->where('payment_moad_id', $payment_id)->update($cp_params);
                    } else {

                        $cp_params['client_id']  = $client->id;
                        $cp_params['user_id']    = $user->id;

                        ClientPayment::create($cp_params);
                    }
                }
            }
        }

        return redirect()->route('admin.allclients')->with('success', 'Customer Edit successfully.');
    }

    public function Admin_Client_Delete($id)
    {

        $id = decrypt($id);

        $user = User::find($id);

        $client = ClientDetails::where('client_id', $user->id)->delete();

        $agentid = $user->registered_by;

        $user->delete();

        return redirect()->route('admin.allclients')->with('error', 'Customer deleted successfully.');
    }

    public function Admin_Client_ViewMore($id)
    {

        $id = decrypt($id);

        $users = User::find($id);

        if (!$users) {
            return redirect()->route('error.page')->with('message', 'User not found');
        }

        return view('adminclients.account', compact('users'));
    }

    public function Admin_Customer_Transaction($id, Request $request)
    {

        $id = decrypt($id);

        $users = User::find($id);

        if (isset($request) && $request->date_from || $request->date_to) {

            $result = PayOrdersVernapayment::select();

            $s_date = $request->date_from;
            $e_date = $request->date_to;

            $result->whereBetween('orderDate', [$s_date, $e_date]);

            $posts = $result->orderBy('orderId', 'desc')->get();

            return view('adminclients.adminclient_transaction_filter', compact('users', 'posts', 's_date', 'e_date'));
        } else {
            return view('adminclients.adminclient_transaction', compact('users'));
        }
    }

    public function Admin_Customer_Refunded($id)
    {

        $id = decrypt($id);

        $users = User::find($id);

        return view('adminclients.refunded', compact('users'));
    }

    public function Admin_Customer_Chargeback($id)
    {

        $id = decrypt($id);

        $users = User::find($id);

        return view('adminclients.chargeback', compact('users'));
    }


    public function client_payment()
    {
        $payments = ClientPayment::orderBy('id', 'desc')->paginate(10);

        return view('client_payment.index', compact('payments'));
    }

    public function client_payment_status($status, $id)
    {
        $params['is_active'] = $status;
        ClientPayment::whereId($id)->update($params);
        return back()->with('message', 'Status Updated');
    }

    public function hide_cc(Request $request)
    {
        $data['value'] = ClientPayment::find($request->id);

        return array(

            'status' => true,

            'modal_view' => view('client_payment.hide_cc', $data)->render(),

        );
    }

    public function store_hide_cc(Request $request)
    {
        $params['currency_hide_id']  = json_encode($request->currency_hide_id);
        $params['country_hide_id']   = json_encode($request->country_hide_id);

        ClientPayment::whereId($request->client_payment_id)->update($params);

        return back()->with('message', 'Updated successfully');
    }
}
