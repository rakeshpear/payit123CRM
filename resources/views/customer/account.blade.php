@extends('layouts.master')

@section('title')

    @lang('Merchant')

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
        .dataTables_filter {
            display: none;
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

               <!-- <a href="{{url()->previous()}}}">

               <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                class="mdi mdi-arrow-left me-1"></i> Back</button>

              </a> -->

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

            <div class="col-xl-8">

                <div class="row">

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Merchant Commission</p>

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

                                        <p class="text-muted fw-medium">Agent Commission</p>

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

                                        <p class="text-muted fw-medium">Transactions</p>

                                        <h5 class="mb-0"><a href="{{url('/customer/transaction', encrypt($users->id))}}">Click</a></h5>

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

                                        <h5 class="mb-0"><a href="{{url('/customer/refunded', encrypt($users->id))}}">Click</a></h5>

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

                                        <h5 class="mb-0"><a href="{{url('/customer/chargeback', encrypt($users->id))}}">Click</a></h5>

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

                    
                    <!-- <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Reports</p>

                                        <h4 class="mb-0">$16.2</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> -->

                </div>

            </div>

        </div>

        <hr>

        <div class="row card">
            <div class="col-md-12 card-body">
                
                <form action="" method="Get">
                        
                    <div class="row">

                        <div class="col-lg-3">
                            
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control to_date" value="{{ $request->to_date }}">
                            
                        </div>

                        <div class="col-lg-3">
                            
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control from_date" value="{{ $request->from_date }}">
                            
                        </div>

                        <div class="col-lg-3 mt-4">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>

                    </div>

                </form>
                 <br>               
                <form action="{{ route('export.client.transaction') }}" method="Get">
                    
                    <input type="hidden" name="merchent" class="user_name" value="{{ $users->name }}">
                    <input type="hidden" name="to_date" value="{{ $request->to_date }}">
                    <input type="hidden" name="from_date" value="{{ $request->from_date }}">

                    <button class="btn btn-success mb-4" type="submit">Export</button>
                </form>

                <div class="row">
                    <div class="col-md-12 ">
                        <table class="table table-striped table-bordered" id="posts">
                            <thead>
                                <th>Merchant</th>
                                <th>Transaction Id</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Before Rolling Re.</th>
                                <th>Rolling Re.</th>
                                <th>Payable to client</th>
                                <th>PSP Fees</th>
                                <th>Net After PSP & Client</th>
                                <th>PP Friend</th>
                                <th>Majestic</th>
                                <th>Payit123 share</th>
                                <th>Invoice</th>
                            </thead> 

                            <tfoot>
                                <tr>
                                    <th>Merchant</th>
                                    <th>Transaction Id</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Fee</th>
                                    <th>Before Rolling Re.</th>
                                    <th>Rolling Re.</th>
                                    <th>Payable to client</th>
                                    <th>PSP Fees</th>
                                    <th>Net After PSP & Client</th>
                                    <th>PP Friend</th>
                                    <th>Majestic</th>
                                    <th>Payit123 share</th>
                                    <th>Invoice</th>
                                </tr>
                            </tfoot>               
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </section>    
        

@endsection




@section('script')

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
            
        let merchent_name = $('.user_name').val();
        let to_date = $('.to_date').val();
        let from_date = $('.from_date').val();

        var table = $('#posts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                         "url": "{{ url('post/client/adminstatsreports') }}",
                         "dataType": "json",
                         "type": "POST",
                         "data":{ _token: "{{csrf_token()}}", merchent: merchent_name, to_date : to_date, from_date : from_date }
                       },
                "columns": [
                    { "data": "Merchant" },
                    { "data": "TransactionId" },
                    { "data": "Date" },
                    { "data": "Status" },
                    { "data": "Corrency"},
                    { "data": "Amount" },
                    { "data": "Fee" },
                    { "data": "BeforeRollingRe" },
                    { "data": "RollingRe" },
                    { "data": "Payabletoclient" },
                    { "data": "PSPFees" },
                    { "data": "NetAfterPSP" },
                    { "data": "PPFriend" },
                    { "data": "Majestic" },
                    { "data": "Limegrove" },
                    { "data": "Invoice" }
                ],
              
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

