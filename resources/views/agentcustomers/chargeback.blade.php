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

           ChargeBack

        @endslot

        @slot('title')

            Customer/Client Details

        @endslot

    @endcomponent

    <section>

        <div class="col-sm-12 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

               <a href="{{url('/customer/view/more', encrypt($users->id))}}">

               <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                class="mdi mdi-arrow-left me-1"></i> Back</button>

              </a>

        </div>

        <!-- <div class="row">

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

                                        <p class="text-muted fw-medium">Client Commission(10%)</p>

                                        <h4 class="mb-0">${{398*10/100}}</h4>

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

                                        <h4 class="mb-0">${{398*1/100}}</h4>

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

                                        <p class="text-muted fw-medium">Tasks</p>

                                        <h4 class="mb-0"></h4>

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

                                        <p class="text-muted fw-medium">Clients</p>

                                        <h4 class="mb-0"></h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class="bx bx-user font-size-24"></i>

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

                                        <p class="text-muted fw-medium">Average Price</p>

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

                    </div>

                    

                    <div class="col-md-4">

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

                    </div>

                </div>

            </div>

        </div> -->

        <div class="row">

            <div class="col-md-2 form-group">
                <label for="date_from">Date From </label>
                <input type="date" name="date_from" class="" value="" id="datefrom">
            </div>

            <div class="col-md-2 form-group">
                <label for="date_to">Date To</label>
                <input type="date" class="" name="date_to" value=""  id="dateto">
            </div>
            
        </div>


        <div class="row">
            <div class="col-md-12 ">
                <table class="table table-bordered" id="report">
                    <thead>

                        <th>Dispute Date</th>
                        <th>PSP code</th>
                        <th>Amount</th>
                        <th>Chargeback Fee</th>
                        <th>Total amount</th>
                        <th>Card ending in</th>
                        <th>Client name</th>
                        <th>Blocked?</th>
                        <th>Invoice number</th>
                        <th>Double invoice Check</th>

                    </thead> 

                    <tbody>

                        <tr>

                            <td>15/10/2023 04:15 AM</td>
                            <td>pi_3O1Iv6K9y7fkiHAE0S2vBXxV</td>
                            <td>157.30</td>
                            <td>50.00</td>
                            <td>207.30</td>
                            <td>5156 76## #### 1704</td>
                            <td>peyton demetre</td>
                            <td>Yes</td>
                            <td>74354804</td>
                            <td>1</td>

                        </tr>

                        <tr>
                            <td>15/10/2023 04:15 AM</td>
                            <td>pi_3O1Iv6K9y7fkiHAE0S2vBXxV</td>
                            <td>157.30</td>
                            <td>50.00</td>
                            <td>207.30</td>
                            <td>5156 76## #### 1704</td>
                            <td>peyton demetre</td>
                            <td>Yes</td>
                            <td>74354804</td>
                            <td>1</td>
                        </tr>

                        <tr>
                            <td>15/10/2023 04:15 AM</td>
                            <td>pi_3NrBJgK9y7fkiHAE0XuROlHr</td>
                            <td>47.65</td>
                            <td>50.00</td>
                            <td>97.65</td>
                            <td>4306 28## #### 1773</td>
                            <td>Darius Singleton</td>
                            <td>Yes</td>
                            <td>73470365</td>
                            <td>1</td>
                        </tr>

                        <tr>

                            <td>15/10/2023 10:45 AM</td>
                            <td>pi_3NqWirK9y7fkiHAE1StKFnwv</td>
                            <td>63.58</td>
                            <td>50.00</td>
                            <td>113.58</td>
                            <td>4815 82## #### 9167</td>
                            <td>Olivia Thompson</td>
                            <td>Yes</td>
                            <td>73395350</td>
                            <td>1</td>

                        </tr>
                        
                    </tbody>

                    <tfoot>
                        <tr>

                            <th>Dispute Date</th>
                            <th>PSP code</th>
                            <th>Amount</th>
                            <th>Chargeback Fee</th>
                            <th>Total amount</th>
                            <th>Card ending in</th>
                            <th>Client name</th>
                            <th>Blocked?</th>
                            <th>Invoice number</th>
                            <th>Double invoice Check</th>

                        </tr>
                    </tfoot>               
                </table>
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
                    { "data": "Dispute Date" },
                    { "data": "PSP code" },
                    { "data": "Amount" },
                    { "data": "Chargeback Fee" },
                    { "data": "Total amount" },
                    { "data": "Card ending in" },
                    { "data": "Client name" },
                    { "data": "Blocked?" },
                    { "data": "Invoice number" },
                    { "data": "Double invoice Check" },                
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

