@extends('layouts.master')



@section('title')

    @lang('Merchant')

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

        .dataTables_filter {
            display: none;
        }
    </style>    

@endsection



@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Merchant

        @endslot

        @slot('title')

             Merchant Transactions

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title mb-3">Merchant Transactions</h4>

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
                                        <th>Invoice</th>
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


@endsection