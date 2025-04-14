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

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />


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

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -25px;
            margin-left: -25px;
            z-index: 9999;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .nav-tabs {
            background-color: #d2fae5; /* Light gray background */
            border: 1px solid #dee2e6; /* Border color */
            border-radius: 5px; /* Rounded corners */
        }

        .nav-link {
            color: #495057; /* Text color */
        }

        .nav-link.active,
        .nav-link:focus,
        .nav-link:hover {
            background-color: #c4f1f5; /* Active, focus, and hover background color */
            color: #fff; /* Active, focus, and hover text color */
        }

        .tab-content {
            border: 1px solid #dee2e6; /* Border color */
            border-radius: 5px; /* Rounded corners */
            padding: 15px;
            margin-top: 10px;
        }


    </style>    

@endsection



@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Report

        @endslot

        @slot('title')

            Adminstats

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title mb-3">Report</h4>

                    <ul class="nav nav-tabs" id="myTabs">

                        <li class="nav-item">
                            <a class="nav-link " id="tab1-tab" data-bs-toggle="tab" href="#tab1">Filter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2">Filter 2</a>
                        </li>
                        
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade" id="tab1">

                            <div class="row">

                                <div class="col-md-2 form-group">
                                    <label for="order_date_from">Order Date From </label>
                                    <input type="date" name="order_date_from" class="" value="{{ $request->order_date_from }}" id="orderdatefrom">
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="order_date_to">Order Date To</label>
                                    <input type="date" class="" name="order_date_to" value="{{ $request->order_date_to }}"  id="orderdateto">
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="s_date">Charge Back From</label>
                                    <input type="date" class="" name="s_date" value="{{ $request->s_date }}" placeholder="Enter Date" id="chargebackfrom">
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="e_date">Charge Back To</label>
                                    <input type="date" class="" name="e_date" value="{{ $request->e_date }}" placeholder="Chargeback To date" id="chargebackto">
                                </div>

                                <div class="col-md-2">
                                    <label for="cardtype">CardType</label>
                                    <select class="mt-1" name="cardtype" id="cardtypeFilter">
                                        <option value="">Select CardType</option>
                                        <option value="Visa" @selected($request->cardtype=='Visa')>Visa</option>
                                        <option value="Mastercard" @selected($request->cardtype=='Mastercard')>Mastercard</option>
                                        <option value="American Express" @selected($request->cardtype=='American Express')>American Express</option>
                                        
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="" name="amount" size="10"  placeholder="Amount" id="amountFilter">
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane fade" id="tab2">

                            <div class="row">

                                <div class="col-md-2">
                                    <label for="currency">Currency</label>
                                    <select class="mt-1" name="currency" id="currencyFilter">
                                        <option value="">Select Currency</option>
                                        <option value="USD" @selected($request->currency=='USD')>USD</option>
                                        <option value="EUR" @selected($request->currency=='EUR')>EUR</option>
                                        <option value="GBP" @selected($request->currency=='GBP')>GBP</option>
                                        <option value="JPY" @selected($request->currency=='JPY')>JPY</option>
                                        
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="order_status">Order Status</label>
                                    <select class="mt-1" name="order_status" id="orderStatusFilter">
                                        <option value="">Select Order Status</option>
                                        <option value="200" >Success</option>
                                        <option value="400">Failed</option>
                                        <option value="1000">Pending</option>
                                        <option value="2000">Refunding</option>
                                        <option value="2001">Refunded</option>
                                        <option value="2008">Chargeback</option>
                                        <option value="2009">High Risk Client</option>
                                        <option value="2010">Dispute </option>
                                        <option value="2005">Fraud</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                        
                    </div>



                    <div id="loader" class="loader"></div>

                    <br>
                    

                    <div class="row">
                        <div class="col-md-12 ">
                            <table class="table table-striped table-bordered" id="posts">
                                <thead>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Charge Back Date</th>
                                    <th>Refund Status</th>
                                    <th>Included Report</th>
                                    <th>Merchant Name</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Phone</th>
                                    <th>Card No.</th>
                                    <th>Bank Name</th>
                                    <th>Descriptor</th>
                                    <th>Profile Name</th>
                                    <th>Card Type</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Invoice Number</th>
                                    <th>Client</th>
                                    <th>Payment Result</th>
                                    <th>Transaction Id</th>
                                    <th>Order Paid</th>
                                </thead> 

                                <tfoot>
                                    <tr>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Charge Back Date</th>
                                        <th>Refund Status</th>
                                        <th>Included Report</th>
                                        <th>Merchant Name</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Card No.</th>
                                        <th>Bank Name</th>
                                        <th>Descriptor</th>
                                        <th>Profile Name</th>
                                        <th>Card Type</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Invoice Number</th>
                                        <th>Client</th>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


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
        var table = $('#posts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                         "url": "{{ url('post/adminstatsreports') }}",
                         "dataType": "json",
                         "type": "POST",
                         "data":{ _token: "{{csrf_token()}}"}
                       },
                "columns": [
                    { "data": "orderDate" },
                    { "data": "orderStatus" },
                    { "data": "bank_charge" },
                    { "data": "refund_status","orderable": false, "searchable": false },
                    { "data": "included_report" },
                    { "data": "merchant_name" },
                    { "data": "full_name" },
                    { "data": "email" },
                    { "data": "country" },
                    { "data": "phone" },
                    { "data": "card_no" },
                    { "data": "bank_name" },
                    { "data": "description" },
                    { "data": "profile" },
                    { "data": "card_type" },
                    { "data": "amount" },
                    { "data": "currency"},
                    { "data": "invoice_number" },
                    { "data": "client" },
                    { "data": "order_message" },
                    { "data": "transaction_id" },
                    { "data": "order_paid" }
                ],
                "dom": 'lBfrtip',
                "buttons": ['excel'],
                "scrollX": true,
                "paging": true,
                "preDrawCallback": function (settings) {
                    showLoader();
                },
                "drawCallback": function (settings) {
                    hideLoader();
                }

            });

            


        $("#currencyFilter").change(function (e) {  
            
            showLoader();
            table.ajax.url("https://www.payit123crm.com/CRM/public/post/adminstatsreports?ajax=load&currencyFilter="+jQuery('#currencyFilter').val()+"&cardtypeFilter="+jQuery('#cardtypeFilter').val()+"&amountFilter="+jQuery('#amountFilter').val()+"&chargebackfrom="+jQuery('#chargebackfrom').val()+"&chargebackto="+jQuery('#chargebackto').val()+"&orderdatefrom="+jQuery('#orderdatefrom').val()+"&orderdateto="+jQuery('#orderdateto').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

            table.draw();

        });

        $("#cardtypeFilter").change(function (e) {  
            showLoader();
            table.ajax.url("https://www.payit123crm.com/CRM/public/post/adminstatsreports?ajax=load&currencyFilter="+jQuery('#currencyFilter').val()+"&cardtypeFilter="+jQuery('#cardtypeFilter').val()+"&amountFilter="+jQuery('#amountFilter').val()+"&chargebackfrom="+jQuery('#chargebackfrom').val()+"&chargebackto="+jQuery('#chargebackto').val()+"&orderdatefrom="+jQuery('#orderdatefrom').val()+"&orderdateto="+jQuery('#orderdateto').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

            table.draw();

        });

        $("#orderStatusFilter").change(function (e) {  
            showLoader();
            table.ajax.url("https://www.payit123crm.com/CRM/public/post/adminstatsreports?ajax=load&currencyFilter="+jQuery('#currencyFilter').val()+"&cardtypeFilter="+jQuery('#cardtypeFilter').val()+"&amountFilter="+jQuery('#amountFilter').val()+"&chargebackfrom="+jQuery('#chargebackfrom').val()+"&chargebackto="+jQuery('#chargebackto').val()+"&orderdatefrom="+jQuery('#orderdatefrom').val()+"&orderdateto="+jQuery('#orderdateto').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

            table.draw();

        });


        $("#amountFilter").change(function (e) {  
            showLoader();
            table.ajax.url("https://www.payit123crm.com/CRM/public/post/adminstatsreports?ajax=load&currencyFilter="+jQuery('#currencyFilter').val()+"&cardtypeFilter="+jQuery('#cardtypeFilter').val()+"&amountFilter="+jQuery('#amountFilter').val()+"&chargebackfrom="+jQuery('#chargebackfrom').val()+"&chargebackto="+jQuery('#chargebackto').val()+"&orderdatefrom="+jQuery('#orderdatefrom').val()+"&orderdateto="+jQuery('#orderdateto').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

            table.draw();
            
        });

        $("#chargebackto").change(function (e) {
            showLoader();
            table.ajax.url("https://www.payit123crm.com/CRM/public/post/adminstatsreports?ajax=load&currencyFilter="+jQuery('#currencyFilter').val()+"&cardtypeFilter="+jQuery('#cardtypeFilter').val()+"&amountFilter="+jQuery('#amountFilter').val()+"&chargebackfrom="+jQuery('#chargebackfrom').val()+"&chargebackto="+jQuery('#chargebackto').val()+"&orderdatefrom="+jQuery('#orderdatefrom').val()+"&orderdateto="+jQuery('#orderdateto').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

            table.draw();  

        });

        $("#orderdateto").change(function (e) { 
            showLoader();
            table.ajax.url("https://www.payit123crm.com/CRM/public/post/adminstatsreports?ajax=load&currencyFilter="+jQuery('#currencyFilter').val()+"&cardtypeFilter="+jQuery('#cardtypeFilter').val()+"&amountFilter="+jQuery('#amountFilter').val()+"&chargebackfrom="+jQuery('#chargebackfrom').val()+"&chargebackto="+jQuery('#chargebackto').val()+"&orderdatefrom="+jQuery('#orderdatefrom').val()+"&orderdateto="+jQuery('#orderdateto').val()+"&orderStatusFilter="+jQuery('#orderStatusFilter').val()).load();

            table.draw(); 


        });

        
        function showLoader() {
            $('#loader').show();
        }

        
        function hideLoader() {
            $('#loader').hide();
        }

        });


    </script>

    


@endsection

