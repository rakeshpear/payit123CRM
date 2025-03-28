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

            Edit Merchant Application Form

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

                                    <input type="text" name="name" class="form-control" value="{{ $data->name }}" placeholder="Name" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Email <b class="text-danger">*</b></label>

                                    <input type="email" name="email" class="form-control" value="{{ $data->email }}" placeholder="Email" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Phone <b class="text-danger">*</b></label>

                                    <input type="number" name="phone" class="form-control" value="{{ $data->phone }}" placeholder="Phone" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Website URL <b class="text-danger">*</b></label>

                                    <input type="text" name="website_URL" class="form-control" value="{{ $data->website_URL }}" placeholder="Website URL" required>

                                </div>
                                
                            </div>

                        </div>                        

                    </div>

                </div>

                @foreach($commission as $key => $comm)
                <div class="card">

                    <div class="card-header">
                        Commissions (Currency#{{ ++$key }})
                    </div>

                    <div class="card-body">                    

                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Transaction ID <b class="text-danger">*</b></label>

                                    <input type="text" name="trans_id[]" class="form-control" value="{{ $comm->trans_id }}" placeholder="Transaction ID" required>

                                    <input type="hidden" name="form_count[]" value="1">
                                    <input type="hidden" name="form_count[]" value="2">
                                    <input type="hidden" name="form_count[]" value="3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Date & Time <b class="text-danger">*</b></label>

                                    <input type="datetime-local" name="date_time[]" value="{{ $comm->date_time }}" class="form-control" placeholder="Date & Time" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Invoice Number <b class="text-danger">*</b></label>

                                    <input type="text" name="invoice_number[]" value="{{ $comm->invoice_number }}" class="form-control" placeholder="Invoice Number" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Amount Paid <b class="text-danger">*</b></label>

                                    <input type="text" name="amount_paid[]" value="{{ $comm->amount_paid }}" class="form-control" placeholder="Amount Paid" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Client (Fee) Commission (MDR) <b class="text-danger">*</b></label>

                                    <input type="text" name="client_fee_commission[]" value="{{ $comm->client_fee_commission }}" class="form-control" placeholder="Client (Fee) Commission (MDR)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves (%)</label>

                                    <input type="text" name="rolling_reserves[]" class="form-control" value="{{ $comm->rolling_reserves }}" placeholder="Rolling Reserves (%)">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Released Days</label>

                                    <input type="text" name="rolling_reserves_released_days[]" class="form-control" value="{{ $comm->rolling_reserves_released_days }}" placeholder="Rolling Reserves Released Days">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Rolling Reserves Cap</label>

                                    <input type="text" name="rolling_reserves_cap[]" class="form-control" value="{{ $comm->rolling_reserves_cap }}" placeholder="Rolling Reserves Cap">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Payable to client <b class="text-danger">*</b></label>

                                    <input type="text" name="payable_to_cleint[]" class="form-control" value="{{ $comm->payable_to_cleint }}" placeholder="Payable to client" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks</label>

                                    <input type="text" name="chargebacks[]" class="form-control" value="{{ $comm->chargebacks }}" placeholder="Chargebacks">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds</label>

                                    <input type="text" name="refunds[]" class="form-control" value="{{ $comm->refunds }}" placeholder="Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds</label>

                                    <input type="text" name="partial_refunds[]" class="form-control" value="{{ $comm->partial_refunds }}" placeholder="Partial Refunds">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #1</label>

                                    <input type="text" name="PSP_fees_1[]" class="form-control" value="{{ $comm->PSP_fees_1 }}" placeholder="PSP Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #1</label>

                                    <input type="text" name="PSP_transaction_fees_1[]" class="form-control" value="{{ $comm->PSP_transaction_fees_1 }}" placeholder="PSP transaction Fees #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #2</label>

                                    <input type="text" name="PSP_fees_2[]" class="form-control" value="{{ $comm->PSP_fees_2 }}" placeholder="PSP Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #2</label>

                                    <input type="text" name="PSP_transaction_fees_2[]" class="form-control" value="{{ $comm->PSP_transaction_fees_2 }}" placeholder="PSP transaction Fees #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #3</label>

                                    <input type="text" name="PSP_fees_3[]" class="form-control" value="{{ $comm->PSP_fees_3 }}" placeholder="PSP Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #3</label>

                                    <input type="text" name="PSP_transaction_fees_3[]" class="form-control" value="{{ $comm->PSP_transaction_fees_3 }}" placeholder="PSP transaction Fees #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP Fees #4</label>

                                    <input type="text" name="PSP_fees_4[]" class="form-control" value="{{ $comm->PSP_fees_4 }}" placeholder="PSP Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PSP transaction Fees #4</label>

                                    <input type="text" name="PSP_transaction_fees_4[]" class="form-control" value="{{ $comm->PSP_transaction_fees_4 }}" placeholder="PSP transaction Fees #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #1</label>

                                    <input type="text" name="agent_1[]" class="form-control" value="{{ $comm->agent_1 }}" placeholder="Agent #1">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #2</label>

                                    <input type="text" name="agent_2[]" class="form-control" value="{{ $comm->agent_2 }}" placeholder="Agent #2">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #3</label>

                                    <input type="text" name="agent_3[]" class="form-control" value="{{ $comm->agent_3 }}" placeholder="Agent #3">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Agent #4</label>

                                    <input type="text" name="agent_4[]" class="form-control" value="{{ $comm->agent_4 }}" placeholder="Agent #4">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>PYY Share 50% </label>

                                    <input type="text" name="PYY_share_50[]" class="form-control" value="{{ $comm->PYY_share_50_p }}" placeholder="PYY Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Limegrove Share 50% </label>

                                    <input type="text" name="limegrove_share_50[]" class="form-control" value="{{ $comm->limegrove_share_50_p }}" placeholder="Limegrove Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Sanabil Share 50% </label>

                                    <input type="text" name="sanabil_share_50[]" class="form-control" value="{{ $comm->sanabil_share_50_p }}" placeholder="Sanabil Share 50%">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Gateway Fees</label>

                                    <input type="text" name="gateway_fees[]" class="form-control" value="{{ $comm->gateway_fees }}" placeholder="Gateway Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Crypto settlement (USDT) <b class="text-danger">*</b></label>

                                    <input type="text" name="crypto_settlement_USDT[]" class="form-control" value="{{ $comm->crypto_settlement_USDT }}" placeholder="Crypto settlement (USDT)" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Fiat Settlement <b class="text-danger">*</b></label>

                                    <input type="text" name="fial_settlement[]" value="{{ $comm->fial_settlement }}" class="form-control" value="{{ $comm->client_fee_commission }}" placeholder="Fiat Settlement" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Chargebacks Fees</label>

                                    <input type="text" name="chargebacks_fees[]" class="form-control" value="{{ $comm->chargebacks_fees }}" placeholder="Chargebacks Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Refunds Fees</label>

                                    <input type="text" name="refunds_fees[]" class="form-control" value="{{ $comm->refunds_fees }}" placeholder="Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Partial Refunds Fees</label>

                                    <input type="text" name="partial_refunds_fees[]" class="form-control" value="{{ $comm->partial_refunds_fees }}" placeholder="Partial Refunds Fees">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>50 cents per transaction</label>

                                    <input type="text" name="cents_per_trans[]" class="form-control" value="{{ $comm->cents_per_trans }}" placeholder="50 cents per transaction">

                                </div>
                                
                            </div>



                        </div>                        

                    </div>

                </div>
                @endforeach

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
                                        <option value="{{ $pay->id }}" {{ $financial->payment_gateway==$pay->id?'selected':'' }}>{{ $pay->payment_gateway }} ({{$pay->doman_name}})</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Is Live <b class="text-danger">*</b></label><br>

                                    <div class="row mt-2">
                                        
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline1" name="is_live" class="custom-control-input" {{ $financial->is_live=='1'?'checked':'' }} required>
                                            <label class="custom-control-label" for="customRadioInline1">Yes</label>
                                        </div>
                                       
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline2" name="is_live" class="custom-control-input" {{ $financial->is_live=='0'?'checked':'' }} required>
                                            <label class="custom-control-label" for="customRadioInline2">No</label>
                                        </div>

                                    </div>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Request URL <b class="text-danger">*</b></label>

                                    <input type="text" name="request_URL" class="form-control" value="{{ $financial->request_URL }}" placeholder="Request URL" required>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Return URL</label>

                                    <input type="text" name="return_URL" class="form-control" value="{{ $financial->return_URL }}" placeholder="Return URL">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Country</label>

                                    <select class="form-control" name="country">
                                        <option value="">Select Country</option>
                                        @foreach($countrie as $key => $cou)
                                        <option value="{{ $cou->id }}" {{ $financial->country==$cou->id?'selected':'' }}>{{ $cou->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Amount Limit</label>

                                    <input type="text" name="amount_limit" value="{{ $financial->amount_limit }}" class="form-control" placeholder="Amount Limit">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Currency</label>

                                    <select class="form-control" name="currency">
                                        <option value="">Select Currency</option>
                                        @foreach($countrie as $key => $coun)
                                        <option value="{{ $coun->id }}" {{ $financial->currency==$coun->id?'selected':'' }}>{{ $cou->code }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                        
                                    <label>Is Active <b class="text-danger">*</b></label><br>

                                    <div class="row mt-2">
                                        
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline4" name="is_active" class="custom-control-input" value="1" {{ $financial->is_active=='1'?'checked':'' }} required>
                                            <label class="custom-control-label" for="customRadioInline4">Enable</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline col-lg-6">
                                            <input type="radio" id="customRadioInline5" name="is_active" class="custom-control-input" value="0"{{ $financial->is_active=='0'?'checked':'' }} required>
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
                                
                            <button class="btn btn-success" type="submit">Update</button>

                        </div>
                        
                    </div>

                </div>

            </form>

        </div>



    </div>



@endsection

@section('script')

@endsection



