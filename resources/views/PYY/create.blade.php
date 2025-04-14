@extends('layouts.master')

@section('title')

    @lang('New Merchant Application Form')

@endsection

@section('css')

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Dashboard

        @endslot

        @slot('title')

            New Merchant Application Form

        @endslot

    @endcomponent
    <style>
        .card-header {
            background-color: lightgrey !important;
        }
    </style>

    <div class="row">

        <div class="col-lg-12">

            <form autocomplete="off" action="{{ route('merchant.application.store') }}" method="Post">
                @csrf

                <div class="card">

                    <div class="card-header">
                        Business Information
                    </div>

                    <div class="card-body">                    

                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Name <b class="text-danger">*</b></label>

                                    <input type="text" name="name" class="form-control" placeholder="Name" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Email <b class="text-danger">*</b></label>

                                    <input type="email" name="email" class="form-control" placeholder="Email" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Phone <b class="text-danger">*</b></label>

                                    <input type="number" name="phone" class="form-control" placeholder="Phone" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Password <b class="text-danger">*</b></label>

                                    <input type="text" name="password" class="form-control" placeholder="Password" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Website URL <b class="text-danger">*</b></label>

                                    <input type="text" name="website_URL" class="form-control" placeholder="Website URL" required>

                                </div>
                                
                            </div>

                        </div>                        

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        Commissions (Currency#1)
                    </div>

                    <div class="card-body">                    

                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Transaction ID <b class="text-danger">*</b></label>

                                    <input type="text" name="trans_id[]" class="form-control" placeholder="Transaction ID" required>

                                    <input type="hidden" name="form_count[]" value="1">
                                    <input type="hidden" name="form_count[]" value="2">
                                    <input type="hidden" name="form_count[]" value="3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Date & Time <b class="text-danger">*</b></label>

                                    <input type="datetime-local" name="date_time[]" class="form-control" placeholder="Date & Time" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Invoice Number <b class="text-danger">*</b></label>

                                    <input type="text" name="invoice_number[]" class="form-control" placeholder="Invoice Number" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Amount Paid <b class="text-danger">*</b></label>

                                    <input type="text" name="amount_paid[]" class="form-control" placeholder="Amount Paid" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Client (Fee) Commission (MDR) <b class="text-danger">*</b></label>

                                    <input type="text" name="client_fee_commission[]" class="form-control" placeholder="Client (Fee) Commission (MDR)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves (%)</label>

                                    <input type="text" name="rolling_reserves[]" class="form-control" placeholder="Rolling Reserves (%)">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Released Days</label>

                                    <input type="text" name="rolling_reserves_released_days[]" class="form-control" placeholder="Rolling Reserves Released Days">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Cap</label>

                                    <input type="text" name="rolling_reserves_cap[]" class="form-control" placeholder="Rolling Reserves Cap">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Payable to client <b class="text-danger">*</b></label>

                                    <input type="text" name="payable_to_cleint[]" class="form-control" placeholder="Payable to client" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks</label>

                                    <input type="text" name="chargebacks[]" class="form-control" placeholder="Chargebacks">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds</label>

                                    <input type="text" name="refunds[]" class="form-control" placeholder="Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds</label>

                                    <input type="text" name="partial_refunds[]" class="form-control" placeholder="Partial Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #1</label>

                                    <input type="text" name="PSP_fees_1[]" class="form-control" placeholder="PSP Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #1</label>

                                    <input type="text" name="PSP_transaction_fees_1[]" class="form-control" placeholder="PSP transaction Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #2</label>

                                    <input type="text" name="PSP_fees_2[]" class="form-control" placeholder="PSP Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #2</label>

                                    <input type="text" name="PSP_transaction_fees_2[]" class="form-control" placeholder="PSP transaction Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #3</label>

                                    <input type="text" name="PSP_fees_3[]" class="form-control" placeholder="PSP Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #3</label>

                                    <input type="text" name="PSP_transaction_fees_3[]" class="form-control" placeholder="PSP transaction Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #4</label>

                                    <input type="text" name="PSP_fees_4[]" class="form-control" placeholder="PSP Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #4</label>

                                    <input type="text" name="PSP_transaction_fees_4[]" class="form-control" placeholder="PSP transaction Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #1</label>

                                    <input type="text" name="agent_1[]" class="form-control" placeholder="Agent #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #2</label>

                                    <input type="text" name="agent_2[]" class="form-control" placeholder="Agent #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #3</label>

                                    <input type="text" name="agent_3[]" class="form-control" placeholder="Agent #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #4</label>

                                    <input type="text" name="agent_4[]" class="form-control" placeholder="Agent #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PYY Share 50% </label>

                                    <input type="text" name="PYY_share_50[]" class="form-control" placeholder="PYY Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Limegrove Share 50% </label>

                                    <input type="text" name="limegrove_share_50[]" class="form-control" placeholder="Limegrove Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Sanabil Share 50% </label>

                                    <input type="text" name="sanabil_share_50[]" class="form-control" placeholder="Sanabil Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Gateway Fees</label>

                                    <input type="text" name="gateway_fees[]" class="form-control" placeholder="Gateway Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Crypto settlement (USDT) <b class="text-danger">*</b></label>

                                    <input type="text" name="crypto_settlement_USDT[]" class="form-control" placeholder="Crypto settlement (USDT)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Fiat Settlement <b class="text-danger">*</b></label>

                                    <input type="text" name="fial_settlement[]" class="form-control" placeholder="Fiat Settlement" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks Fees</label>

                                    <input type="text" name="chargebacks_fees[]" class="form-control" placeholder="Chargebacks Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds Fees</label>

                                    <input type="text" name="refunds_fees[]" class="form-control" placeholder="Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds Fees</label>

                                    <input type="text" name="partial_refunds_fees[]" class="form-control" placeholder="Partial Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>50 cents per transaction</label>

                                    <input type="text" name="cents_per_trans[]" class="form-control" placeholder="50 cents per transaction">

                                </div>
                                
                            </div>



                        </div>                        

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        Commissions (Currency#2)
                    </div>

                    <div class="card-body">                    

                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Transaction ID <b class="text-danger">*</b></label>

                                    <input type="text" name="trans_id[]" class="form-control" placeholder="Transaction ID" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Date & Time <b class="text-danger">*</b></label>

                                    <input type="datetime-local" name="date_time[]" class="form-control" placeholder="Date & Time" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Invoice Number <b class="text-danger">*</b></label>

                                    <input type="text" name="invoice_number[]" class="form-control" placeholder="Invoice Number" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Amount Paid <b class="text-danger">*</b></label>

                                    <input type="text" name="amount_paid[]" class="form-control" placeholder="Amount Paid" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Client (Fee) Commission (MDR) <b class="text-danger">*</b></label>

                                    <input type="text" name="client_fee_commission[]" class="form-control" placeholder="Client (Fee) Commission (MDR)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves (%)</label>

                                    <input type="text" name="rolling_reserves[]" class="form-control" placeholder="Rolling Reserves (%)">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Released Days</label>

                                    <input type="text" name="rolling_reserves_released_days[]" class="form-control" placeholder="Rolling Reserves Released Days">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Cap</label>

                                    <input type="text" name="rolling_reserves_cap[]" class="form-control" placeholder="Rolling Reserves Cap">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Payable to client <b class="text-danger">*</b></label>

                                    <input type="text" name="payable_to_cleint[]" class="form-control" placeholder="Payable to client" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks</label>

                                    <input type="text" name="chargebacks[]" class="form-control" placeholder="Chargebacks">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds</label>

                                    <input type="text" name="refunds[]" class="form-control" placeholder="Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds</label>

                                    <input type="text" name="partial_refunds[]" class="form-control" placeholder="Partial Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #1</label>

                                    <input type="text" name="PSP_fees_1[]" class="form-control" placeholder="PSP Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #1</label>

                                    <input type="text" name="PSP_transaction_fees_1[]" class="form-control" placeholder="PSP transaction Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #2</label>

                                    <input type="text" name="PSP_fees_2[]" class="form-control" placeholder="PSP Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #2</label>

                                    <input type="text" name="PSP_transaction_fees_2[]" class="form-control" placeholder="PSP transaction Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #3</label>

                                    <input type="text" name="PSP_fees_3[]" class="form-control" placeholder="PSP Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #3</label>

                                    <input type="text" name="PSP_transaction_fees_3[]" class="form-control" placeholder="PSP transaction Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #4</label>

                                    <input type="text" name="PSP_fees_4[]" class="form-control" placeholder="PSP Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #4</label>

                                    <input type="text" name="PSP_transaction_fees_4[]" class="form-control" placeholder="PSP transaction Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #1</label>

                                    <input type="text" name="agent_1[]" class="form-control" placeholder="Agent #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #2</label>

                                    <input type="text" name="agent_2[]" class="form-control" placeholder="Agent #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #3</label>

                                    <input type="text" name="agent_3[]" class="form-control" placeholder="Agent #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #4</label>

                                    <input type="text" name="agent_4[]" class="form-control" placeholder="Agent #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PYY Share 50% </label>

                                    <input type="text" name="PYY_share_50[]" class="form-control" placeholder="PYY Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Limegrove Share 50% </label>

                                    <input type="text" name="limegrove_share_50[]" class="form-control" placeholder="Limegrove Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Sanabil Share 50% </label>

                                    <input type="text" name="sanabil_share_50[]" class="form-control" placeholder="Sanabil Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Gateway Fees</label>

                                    <input type="text" name="gateway_fees[]" class="form-control" placeholder="Gateway Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Crypto settlement (USDT) <b class="text-danger">*</b></label>

                                    <input type="text" name="crypto_settlement_USDT[]" class="form-control" placeholder="Crypto settlement (USDT)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Fiat Settlement <b class="text-danger">*</b></label>

                                    <input type="text" name="fial_settlement[]" class="form-control" placeholder="Fiat Settlement" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks Fees</label>

                                    <input type="text" name="chargebacks_fees[]" class="form-control" placeholder="Chargebacks Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds Fees</label>

                                    <input type="text" name="refunds_fees[]" class="form-control" placeholder="Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds Fees</label>

                                    <input type="text" name="partial_refunds_fees[]" class="form-control" placeholder="Partial Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>50 cents per transaction</label>

                                    <input type="text" name="cents_per_trans[]" class="form-control" placeholder="50 cents per transaction">

                                </div>
                                
                            </div>



                        </div>                        

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        Commissions (Currency#3)
                    </div>

                    <div class="card-body">                    

                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Transaction ID <b class="text-danger">*</b></label>

                                    <input type="text" name="trans_id[]" class="form-control" placeholder="Transaction ID" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Date & Time <b class="text-danger">*</b></label>

                                    <input type="datetime-local" name="date_time[]" class="form-control" placeholder="Date & Time" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Invoice Number <b class="text-danger">*</b></label>

                                    <input type="text" name="invoice_number[]" class="form-control" placeholder="Invoice Number" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Amount Paid <b class="text-danger">*</b></label>

                                    <input type="text" name="amount_paid[]" class="form-control" placeholder="Amount Paid" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Client (Fee) Commission (MDR) <b class="text-danger">*</b></label>

                                    <input type="text" name="client_fee_commission[]" class="form-control" placeholder="Client (Fee) Commission (MDR)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves (%)</label>

                                    <input type="text" name="rolling_reserves[]" class="form-control" placeholder="Rolling Reserves (%)">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Released Days</label>

                                    <input type="text" name="rolling_reserves_released_days[]" class="form-control" placeholder="Rolling Reserves Released Days">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Cap</label>

                                    <input type="text" name="rolling_reserves_cap[]" class="form-control" placeholder="Rolling Reserves Cap">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Payable to client <b class="text-danger">*</b></label>

                                    <input type="text" name="payable_to_cleint[]" class="form-control" placeholder="Payable to client" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks</label>

                                    <input type="text" name="chargebacks[]" class="form-control" placeholder="Chargebacks">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds</label>

                                    <input type="text" name="refunds[]" class="form-control" placeholder="Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds</label>

                                    <input type="text" name="partial_refunds[]" class="form-control" placeholder="Partial Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #1</label>

                                    <input type="text" name="PSP_fees_1[]" class="form-control" placeholder="PSP Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #1</label>

                                    <input type="text" name="PSP_transaction_fees_1[]" class="form-control" placeholder="PSP transaction Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #2</label>

                                    <input type="text" name="PSP_fees_2[]" class="form-control" placeholder="PSP Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #2</label>

                                    <input type="text" name="PSP_transaction_fees_2[]" class="form-control" placeholder="PSP transaction Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #3</label>

                                    <input type="text" name="PSP_fees_3[]" class="form-control" placeholder="PSP Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #3</label>

                                    <input type="text" name="PSP_transaction_fees_3[]" class="form-control" placeholder="PSP transaction Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #4</label>

                                    <input type="text" name="PSP_fees_4[]" class="form-control" placeholder="PSP Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #4</label>

                                    <input type="text" name="PSP_transaction_fees_4[]" class="form-control" placeholder="PSP transaction Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #1</label>

                                    <input type="text" name="agent_1[]" class="form-control" placeholder="Agent #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #2</label>

                                    <input type="text" name="agent_2[]" class="form-control" placeholder="Agent #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #3</label>

                                    <input type="text" name="agent_3[]" class="form-control" placeholder="Agent #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #4</label>

                                    <input type="text" name="agent_4[]" class="form-control" placeholder="Agent #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PYY Share 50% </label>

                                    <input type="text" name="PYY_share_50[]" class="form-control" placeholder="PYY Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Limegrove Share 50% </label>

                                    <input type="text" name="limegrove_share_50[]" class="form-control" placeholder="Limegrove Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Sanabil Share 50% </label>

                                    <input type="text" name="sanabil_share_50[]" class="form-control" placeholder="Sanabil Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Gateway Fees</label>

                                    <input type="text" name="gateway_fees[]" class="form-control" placeholder="Gateway Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Crypto settlement (USDT) <b class="text-danger">*</b></label>

                                    <input type="text" name="crypto_settlement_USDT[]" class="form-control" placeholder="Crypto settlement (USDT)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Fiat Settlement <b class="text-danger">*</b></label>

                                    <input type="text" name="fial_settlement[]" class="form-control" placeholder="Fiat Settlement" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks Fees</label>

                                    <input type="text" name="chargebacks_fees[]" class="form-control" placeholder="Chargebacks Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds Fees</label>

                                    <input type="text" name="refunds_fees[]" class="form-control" placeholder="Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds Fees</label>

                                    <input type="text" name="partial_refunds_fees[]" class="form-control" placeholder="Partial Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>50 cents per transaction</label>

                                    <input type="text" name="cents_per_trans[]" class="form-control" placeholder="50 cents per transaction">

                                </div>
                                
                            </div>



                        </div>                        

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        Financial Information (Payment Section)
                    </div>

                    <div class="card-body">                    

                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Payment Gateway <b class="text-danger">*</b></label>

                                    <select class="form-control" name="payment_gateway" required>
                                        <option value="">Select Payment Gateway</option>
                                        @foreach($payments as $key => $pay)
                                        <option value="{{ $pay->id }}">{{ $pay->payment_gateway }} ({{$pay->doman_name}})</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Is Live <b class="text-danger">*</b></label><br>

                                    <div class="row mt-2">
                                        
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline1" name="is_live" class="custom-control-input" required>
                                            <label class="custom-control-label" for="customRadioInline1">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline2" name="is_live" class="custom-control-input" required>
                                            <label class="custom-control-label" for="customRadioInline2">No</label>
                                        </div>

                                    </div>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Request URL <b class="text-danger">*</b></label>

                                    <input type="text" name="request_URL" class="form-control" placeholder="Request URL" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Return URL</label>

                                    <input type="text" name="return_URL" class="form-control" placeholder="Return URL">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Country</label>

                                    <select class="form-control" name="country">
                                        <option value="">Select Country</option>
                                        @foreach($countrie as $key => $cou)
                                        <option value="{{ $cou->id }}">{{ $cou->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Amount Limit</label>

                                    <input type="text" name="amount_limit" class="form-control" placeholder="Amount Limit">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Currency</label>

                                    <select class="form-control" name="currency">
                                        <option value="">Select Currency</option>
                                        @foreach($countrie as $key => $coun)
                                        <option value="{{ $coun->id }}">{{ $cou->code }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Is Active <b class="text-danger">*</b></label><br>

                                    <div class="row mt-2">
                                        
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline4" name="is_active" class="custom-control-input" value="Enable" required>
                                            <label class="custom-control-label" for="customRadioInline4">Enable</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline5" name="is_active" class="custom-control-input" value="Disable" required>
                                            <label class="custom-control-label" for="customRadioInline5">Disable</label>
                                        </div>

                                    </div>

                                </div>
                                
                            </div>

                        </div>                        

                    </div>

                </div>

                <div class="card">
                    
                    <div class="card-body">

                        <div class="text-center mt-4">
                                
                            <button class="btn btn-success" type="submit">Submit</button>

                        </div>
                        
                    </div>

                </div>

            </form>

        </div>



    </div>



@endsection

@section('script')

@endsection



