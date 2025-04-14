@extends('layouts.master')







@section('title')



    @lang('Requested Payment')



@endsection



@section('css')



    <!-- select2 css -->



    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />







    <!-- DataTables -->



    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />







    <!-- Responsive datatable examples -->



    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />

    <style>
        .buttons-excel {
            background: #34c38f !important;
            color: white !important;
        }
    </style>
@endsection



@section('content')



    @component('components.breadcrumb')



        @slot('li_1')



            Requested Payment



        @endslot



        @slot('title')



            Requested Payment



        @endslot



    @endcomponent







    <div class="row">



        <div class="col-lg-12">



            <div class="card">



                <div class="card-body">


                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100 display" id="example">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Customer Name</th>

                                    <th scope="col">Customer Phone</th>

                                    <th scope="col">Customer Email</th>

                                    <th scope="col">Payment Name</th>

                                    <th scope="col">Currency</th>

                                    <th scope="col">Amount</th>

                                    <th scope="col">Beneficiary</th>

                                    <th scope="col">Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($payment as $key => $val)

                                <tr>
                                    
                                    <td>{{ ++$key }}</td>

                                    <td>{{ $val->customer->name ?? 'NA' }}</td>

                                    <td>{{ $val->customer->phone ?? 'NA' }}</td>

                                    <td>{{ $val->customer->email ?? 'NA' }}</td>

                                    <td>
                                        @if($val->customerPayment && $val->customerPayment->payment)
                                            {{ $val->customerPayment->payment->doman_name }}
                                        @endif
                                    </td>

                                    <td>{{ $val->currency }}</td>

                                    <td>
                                        @if($val->customerPayment)
                                            @if($val->currency=='USD')
                                                $
                                            @elseif($val->currency=='EURO')
                                                €
                                            @elseif($val->currency=='GBP')
                                                £
                                            @elseif($val->currency=='INR')
                                                ₹
                                            @endif

                                            {{ $val->customerPayment->amount_limit }}
                                        @endif
                                    </td>

                                    <td>{{ $val->is_beneficiary }}</td>

                                    <td>
                                        @if($val->status=='0')
                                            <a href="{{ route('change.request.payment.status',$val->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure approved this?')">Disapproved</a>
                                        @else
                                            <a href="{{ route('change.request.payment.status',$val->id) }}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure disapproved this?')">Approved</a>
                                        @endif
                                    </td>

                                </tr>

                                @endforeach()

                            </tbody>

                        </table>

                        <!-- end table -->

                    </div>



                </div>



            </div>



        </div>



    </div>



@endsection



@section('script')

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script>
        jQuery(document).ready(function(){
            new DataTable('#example', {
                layout: {
                    topStart: {
                        buttons: ['excelHtml5']
                    }
                }
            });
        });
    </script>

    <!-- select2 js -->



@endsection



