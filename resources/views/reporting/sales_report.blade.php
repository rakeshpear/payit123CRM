@extends('layouts.master')



@section('title')

    @lang('Adminstats')

@endsection



@section('css')

    <!-- select2 css -->

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- bootstrap-datepicker css -->

    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">



    <!-- DataTables -->

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"

        type="text/css" /> 

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

            Sales Report

        @endslot

        @slot('title')

            Adminstats

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title mb-3" id="tableName">{{$cname}}</h4>


                    <!-- Tab panes -->

                    <div class="tab-content mb-2">

                        <div class="tab-pane active" id="all-order" role="tabpanel">
   
                            <div class="row">
                                
                                <div class="col-md-11">
                                    <div class="mb-3">
                                        <!-- <a class="btn btn-warning btn-sm " href="">Refresh</a> -->
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <a class="btn btn-primary btn-sm " href="{{url()->previous()}}">Back</a>
                                    </div>
                                </div>
                            </div>

                        
                                <input type="hidden" name="t_name" value="{{$cname}}">
                                <div class="row">

                                    <div class="col-md-2 form-group">
                                        <label for="order_date_from">Order Date From</label>
                                        <input type="date" class="" name="order_date_from" value="{{ $request->order_date_from }}" placeholder="Order date From" id="orderfrom">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="order_date_to">Order Date To</label>
                                        <input type="date" class="" name="order_date_to" value="{{ $request->order_date_to }}" placeholder="Order date To" id="orderto">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="order_status">Order Status</label>
                                        <select class="mt-1" name="order_status" id="orderStatusFilter">
                                            <option value="">Select Order Status</option>
                                            <option value="200" >Success</option>
                                            <option value="400">Failed</option>
                                            <option value="1000">Pending</option>
                                            <option value="">Refunding</option>
                                            <option value="2001">Refunded</option>
                                            <option value="2008">Chargeback</option>
                                            <option value="2009">High Risk Client</option>
                                            <option value="">Dispute </option>
                                            <option value="2005">Fraud</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="merchant_name">Merchant Name</label>
                                        <select class="mt-1" name="merchant_name" id="MerchantFilter">
                                            <option value="">Select Merchant</option>
                                            <option value="MRV" >MRV</option>
                                            <option value="Mstreet">Mstreet</option>
                                            <option value="Ralseft"> Ralseft</option>
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="payment_method">Payment Method</label>
                                        <select class="mt-1" name="payment_method" id="PaymentMethodFilter">
                                            <option value="">Payment Method</option>
                                            <option value="PSP1" >PSP1</option>
                                        </select>
                                    </div>

                                </div>
                           
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="posts">
                                <thead>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Phone</th>
                                    <th>Card No.</th>
                                    <th>Amount</th>
                                    <th>Invoice Number</th>
                                    <th>Merchant Name</th>
                                    <th>Payment Method </th>
                                    <th>Payment Result</th>
                                    <th>Transaction Id</th>
                                    <th>Order Paid</th>
                                </thead> 

                                <tfoot>
                                    <tr>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Card No.</th>
                                        <th>Amount</th>
                                        <th>Invoice Number</th>
                                        <th>Merchant Name</th>
                                        <th>Payment Method </th>
                                        <th>Payment Result</th>
                                        <th>Transaction Id</th>
                                        <th>Order Paid</th>
                                    </tr>
                                </tfoot>               
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end row -->

@endsection

@section('script')

    <script type="text/javascript">

            $('.select_all').on('change', function() {     
                    $('.checkbox').prop('checked', $(this).prop("checked"));              
            });

            //deselect "checked all", if one of the listed checkbox category is unchecked amd select "checked all" if all of the listed checkbox category is checked

            $('.checkbox').change(function(){ //".checkbox" change 
                if($('.checkbox:checked').length == $('.checkbox').length){
                       $('.select_all').prop('checked',true);
                }else{
                       $('.select_all').prop('checked',false);
                }
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

        var tableName = $('#tableName').text();
            
        var table = $('#posts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                         "url": "{{ url('post/clients/data/pay_orders') }}"+"/"+ tableName,
                         "dataType": "json",
                         "type": "POST",
                         "data":{ _token: "{{csrf_token()}}"}
                       },
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
                "scrollX": true,
                "dom": 'lBfrtip',
                "buttons": [
                    'excel'
                ]

            });

        $("#MerchantFilter").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();


            // table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()).load();

           });

        $("#orderStatusFilter").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

             // table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

           });

        $("#PaymentMethodFilter").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

            // table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()).load();
           });

        $("#orderto").change(function (e) {  

            table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&MerchantFilter="+jQuery('#MerchantFilter').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()+"&PaymentMethodFilter="+jQuery('#PaymentMethodFilter').val()+"&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

            // table.ajax.url("https://www.payit123crm.com/CRM/public/post/clients/data/pay_orders"+"/"+tableName+"?ajax=load&orderfrom="+jQuery('#orderfrom').val()+"&orderto="+jQuery('#orderto').val()).load();

           });

        });

    </script>
   

@endsection

