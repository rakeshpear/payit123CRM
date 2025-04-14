@extends('layouts.master')

@section('title')

    @lang('Payment Method')

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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <style>
        .position-relative {
            display: none !important;
        }
    </style>
@endsection

@section('content')

    @component('components.breadcrumb')


        @slot('li_1')

           Payment Method

        @endslot

        @slot('title')

            Payment Method

        @endslot

    @endcomponent



    <div class="row">
        
        @include('flash_msg')

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">

                        <div class="col-sm-4">

                            <div class="search-box me-2 mb-2 d-inline-block">

                                <div class="position-relative">

                                    <input type="text" class="form-control" id="searchTableList" placeholder="Search...">

                                    <i class="bx bx-search-alt search-icon"></i>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-8">

                            <div class="text-sm-end">

                               <a href="{{route('payment.method.create')}}">

                                   <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                    class="mdi mdi-plus me-1"></i> Add New</button>

                                </a>

                            </div>

                        </div><!-- end col-->

                    </div>

                    <!-- end row -->

                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100 display" id="example">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Domain Name</th>

                                    <th scope="col">Payment Gateway</th>

                                    <th scope="col">Key</th>

                                    <th scope="col">Secret</th>

                                    <th scope="col">Status</th>

                                    <th scope="col" style="width: 200px;">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(!empty($payments))

                                @foreach($payments as $key=> $value)

                                <tr>

                                    <td>{{ ++$key }}</td>

                                    <td>{{ $value->doman_name }}</td>

                                    <td>{{ $value->payment_gateway }} </td>

                                    <td>{{ $value->payment_key }}</td>

                                    <td>{{ $value->payment_secret }}</td>  

                                    <td>
                                        @if($value->status == 1)
                                        <a href="{{ url('payment/method/status/'.'0'.'/'.$value->id) }}" onclick="return confirm('Are You Sure ?')" class="btn btn-sm btn-success">Active</a>
                                        @else
                                        <a href="{{ url('payment/method/status/'.'1'.'/'.$value->id) }}" onclick="return confirm('Are You Sure ?')" class="btn btn-sm btn-danger">Inactive</a>
                                        @endif
                                    </td>                                

                                    <td>

                                        <ul class="list-unstyled hstack gap-1 mb-0">

                                            <li>
                                                <div class="dropdown dropend">
                                                    <a id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><i class="mdi mdi-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-bs-auto-end="true">

                                                        <li><a class="dropdown-item" href="{{ route('payment.method.edit',$value->id) }}">Edit</a></li>

                                                        <li><a class="dropdown-item" href="javascript:void(0)">Refund</a></li>

                                                        <li><a href="javascript:void(0)" class="dropdown-item">View Refund</a></li>
                                                    </ul>
                                                </div>
                                            </li>

                                        </ul>

                                    </td>

                                </tr>

                                @endforeach

                                    @if ($payments->count() == 0)

                                    <tr class="text-center">

                                        <td colspan="6">No data to display.</td>

                                    </tr>

                                    @endif

                                @endif

                            </tbody>

                        </table>

                        <!-- end table -->

                    </div>

                    <!-- end table responsive -->

                </div>

            </div>

        </div>

    </div>


   

@endsection



@section('script')
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <!-- <script>
        jQuery(document).ready(function(){
            new DataTable('#example');
        });
    </script> -->


    <!-- select2 js -->

    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <!-- Required datatable js -->

    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->

    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- ecommerce-customer-list init -->

    <script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

    <!-- init js -->

    <script src="{{ URL::asset('build/js/pages/crypto-orders.init.js') }}"></script>



@endsection



