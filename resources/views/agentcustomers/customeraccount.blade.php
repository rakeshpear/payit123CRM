@extends('layouts.master')

@section('title')

    @lang('Customer')

@endsection

@section('css')

    <!-- select2 css -->

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- bootstrap-datepicker css -->

    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">



    <!-- DataTables -->

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Add Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>

        .flex-1
        {
            display: none;
        }
        .w-5
        {
          display: none;
        } 

        th, td
        {
          white-space: nowrap;
        }
        thead
        {
            background-color: #e8edea;
        }

        div.dataTables_wrapper div.dataTables_length select{

            min-width: 50px;

        }


    </style> 

@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

           Merchant Account

        @endslot

        @slot('title')

            Merchant Details

        @endslot

    @endcomponent

    <section>

        <div class="col-sm-12 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

               <a href="{{url('/customer/index',['agentid' => Session::get('agentid')])}}">

               <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                class="mdi mdi-arrow-left me-1"></i> Back</button>

              </a>

        </div>

        <div class="row">

            <div class="col-xl-4">

                <div class="card overflow-hidden">

                    <div class="bg-primary-subtle">

                        <div class="row">

                            <div class="col-7">

                                <div class="text-primary p-3">

                                    <h5 class="text-primary">Welcome Back !</h5>

                                    <p>PayIT</p>

                                </div>

                            </div>

                            <div class="col-5 align-self-end">

                                <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">

                            </div>

                        </div>

                    </div>

                    <div class="card-body pt-0">

                        <div class="row">

                            <div class="col-sm-12">

                                <div class="avatar-md profile-user-wid mb-2">

                                    <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('build/images/users/profile.png') }}" alt="" class="img-thumbnail rounded-circle">

                                </div>

                                <h4 class="font-size-20 mb-1 text-truncate">{{ $users->name }}</h4>

                                <p class="p-0 m-0"><strong>Phone:&nbsp;&nbsp;</strong>{{ $users->phone }}</p>
                                <p class="p-0 m-0"><strong>Email:&nbsp;&nbsp;</strong>{{ $users->email }}</p>
                               
                                <p class="p-0 m-0"><strong>Role:&nbsp;&nbsp;</strong>{{ $users->Role->name }}</p>
                                <p class="p-0 m-0"><strong>Status:&nbsp;&nbsp;</strong>{{ $users->status == 1 ? 'Active' : 'Inactive' }}</p> 

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <?php
                if($users && $users->clientDetails && $users->clientDetails->client_commission){
                    $client_commission = $users->clientDetails->client_commission;
                } else {
                    $client_commission = '0';
                }

                if($users && $users->clientDetails && $users->clientDetails->extra_client_fee){
                    $extra_client_fee = $users->clientDetails->extra_client_fee;
                } else {
                    $extra_client_fee = '0';
                }
                                    
                if($users && $users->clientDetails && $users->clientDetails->rolling_reserve){
                    $rolling_reserve = $users->clientDetails->rolling_reserve;
                } else {
                    $rolling_reserve = '0';
                }

                if($users && $users->clientDetails && $users->clientDetails->psp){
                    $psp = $users->clientDetails->psp;
                } else {
                    $psp = '0';
                } 

                if($users && $users->clientDetails && $users->clientDetails->pp_friend){
                    $pp_friend = $users->clientDetails->pp_friend;
                } else {
                    $pp_friend = '0';
                }

                if($users && $users->clientDetails && $users->clientDetails->majestic){
                    $majestic_p = $users->clientDetails->majestic;
                } else {
                    $majestic_p = '0';
                }

                if($users && $users->clientDetails && $users->clientDetails->payit123share){
                    $payit123share = $users->clientDetails->payit123share;
                } else {
                    $payit123share = '0';
                }       
            ?>

            <div class="col-xl-8">

                <div class="row">

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Merchant Commission({{$client_commission}}%)</p>

                                        <h4 class="mb-0">$0.00</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class='bi bi-cash-coin font-size-24'></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Agent Commission(1%)</p>

                                        <h4 class="mb-0">$0.00</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center ">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class='bi bi-cash-coin font-size-24'></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Transaction Calculation</p>

                                        <h4 class="mb-0"><a href="{{url('agent/customer/transaction/calculation', encrypt($users->id))}}">Click</a></h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center ">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-copy-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>                    

                </div>

                <div class="row">

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Refunded</p>

                                        <h5 class="mb-0"><a href="{{url('/agent/customer/refunded', encrypt($users->id))}}">Click</a></h5>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class="bx bx-copy-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Chargeback</p>

                                        <h5 class="mb-0"><a href="{{url('/agent/customer/chargeback', encrypt($users->id))}}">Click</a></h5>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-copy-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <div class="row card">
            <div class="col-md-12 card-body">
                <form action="{{ route('export.client.transaction') }}" method="Get">
                        
                    <input type="hidden" name="merchent" value="{{ $users->name }}">

                    <button class="btn btn-success mb-4" type="submit">Export</button>
                </form>
                
                <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100 display" id="example">
                    <thead>
                        <th>Merchant</th>
                        <th>Transaction Id</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Fee ({{$client_commission}}%)+{{$extra_client_fee}}</th>
                        <th>Before Rolling Re.</th>
                        <th>Rolling Re. ({{$rolling_reserve}}%)</th>
                        <th>Payable to client</th>
                        <th>PSP Fees ({{ $psp }}%)</th>
                        <th>Net After PSP & Client</th>
                        <th>PP Friend ({{ $pp_friend }}%)</th>
                        <th>Majestic ({{$majestic_p}}%)</th>
                        <th>Payit123 share ({{$payit123share}}%)</th>
                        <th>Invoice</th>
                    </thead> 

                    <tbody>

                        @foreach($client_transactions as $key => $item)

                            <tr>

                                <td>{{ $item->user_name }}</td>
                                <td>{{ $item->transaction_id }}</td>
                                <td>{{ date("d-m-Y", strtotime($item->transaction_date)) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->currency }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>
                                    <?php
                                        $fee = (($client_commission / 100) * $item->amount)+$extra_client_fee;
                                    ?>
                                    {{ number_format($fee, 2); }}
                                </td>
                                <td>
                                    <?php
                                        $before_roll_rec = $item->amount - $fee;
                                    ?>
                                    {{ number_format($before_roll_rec, 2) }}
                                </td>
                                <td>
                                    <?php
                                        $rolling_rec_per = ($rolling_reserve / 100) * $item->amount;
                                    ?>
                                    {{ number_format($rolling_rec_per, 2); }}
                                </td>
                                <td>
                                    <?php
                                        $payable_to_clnt = $before_roll_rec - $rolling_rec_per;
                                    ?>
                                    {{ number_format($payable_to_clnt, 2) }}
                                </td>
                                <td>
                                    <?php

                                        $PSP_fees = ($psp / 100) * $item->amount;
                                    ?>
                                    {{ number_format($PSP_fees, 2); }}
                                </td>
                                <td>
                                    <?php

                                        $net_after_PSP = $item->amount - $before_roll_rec - $PSP_fees;
                                    ?>
                                    {{ number_format($net_after_PSP, 2); }}
                                </td>
                                <td>
                                    <?php

                                        $PP_frnd = ($pp_friend / 100) * $item->amount;
                                    ?>
                                    {{ number_format($PP_frnd, 2); }}
                                </td>
                                <td>
                                    <?php

                                        $majestic = ($majestic_p / 100) * $item->amount;
                                    ?>
                                    {{ number_format($majestic, 2); }}
                                </td>
                                <td>
                                    <?php

                                        $limegrove =  ($payit123share / 100) * ($net_after_PSP - $majestic - $PP_frnd);
                                    ?>
                                    {{ number_format($limegrove, 2); }}
                                </td>
                                <td>
                                    {{ $item->invoice }}
                                </td>
                                
                            </tr>

                        @endforeach

                    </tbody>                      

                    <tfoot>
                        <tr>
                            <th>Merchant</th>
                            <th>Transaction Id</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Fee ({{$client_commission}}%)</th>
                            <th>Before Rolling Re.</th>
                            <th>Rolling Re. ({{$rolling_reserve}}%)</th>
                            <th>Payable to client</th>
                            <th>PSP Fees ({{ $psp }}%)</th>
                            <th>Net After PSP & Client</th>
                            <th>PP Friend ({{ $pp_friend }}%)</th>
                            <th>Majestic ({{$majestic_p}}%)</th>
                            <th>Payit123 share ({{$payit123share}}%)</th>
                            <th>Invoice</th>
                        </tr>
                    </tfoot>               
                </table>
            </div>
        </div>

    </section>    

        

@endsection



@section('script')

<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script>
        jQuery(document).ready(function(){
            new DataTable('#example');
        });
    </script>


    <!-- select2 -->

    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <!-- bootstrap-datepicker js -->

    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Required datatable js -->

    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->

    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- init js -->

    <script src="{{ URL::asset('build/js/pages/crypto-orders.init.js') }}"></script>

    <!-- New Script -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script> 

    <!-- DataTables Buttons CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>   
    


    <script>
        $(document).ready(function () {
            
        var table = $('#report').DataTable({
                "processing": true,
                // "serverSide": true,
                // "ajax":{
                //          "url": "{{ url('post/clients/data/pay_orders') }}"+"/"+ tableName,
                //          "dataType": "json",
                //          "type": "POST",
                //          "data":{ _token: "{{csrf_token()}}"}
                //        },
                "columns": [
                    { "data": "orderDate" },
                    { "data": "orderStatus" },
                    { "data": "full_name" },
                    { "data": "email" },
                    { "data": "country" },
                    { "data": "phone" },
                    { "data": "card_no" },
                    { "data": "amount" },
                    { "data": "invoice_number" },
                    { "data": "merchant_name" },
                    { "data": "paymentMethod" },
                    { "data": "order_message" },
                    { "data": "transaction_id" },
                    { "data": "order_paid" },            
                ],
                "dom": 'lBfrtip',
                "scrollX": true,
                "buttons": [
                    'excel'
                ]

            });

        $("#MerchantFilter").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

           });

        $("#orderStatusFilter").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

           });

        $("#PaymentMethodFilter").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();
           });

        $("#orderto").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

           });

        });

    </script>

@endsection

