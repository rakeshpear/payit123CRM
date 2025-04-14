@extends('layouts.master')

@section('title')

    @lang('User List')

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

@endsection

@section('content')

    @component('components.breadcrumb')


        @slot('li_1')

           Payments

        @endslot

        @slot('title')

            Payments

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

                                @can('Payment.Create')

                                   <a href="{{route('createpayments')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-plus me-1"></i> New Payment</button>

                                    </a>

                                @endcan    
                            </div>

                        </div><!-- end col-->

                    </div>

                    <!-- end row -->

                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Customer</th>

                                    <th scope="col">Amount</th>

                                    <th scope="col">Currency</th>

                                    <th scope="col">Crypto</th>

                                    <th scope="col">Convert Amount</th>

                                    <th scope="col">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(!empty($payments))

                                @foreach($payments as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>

                                    <td>{{ $value->Customer->name ?? 'NA' }}</td>

                                    <td>{{ $value->amount }}</td>

                                    <td>{{ $value->currency }}</td>

                                    <td>{{ $value->crypto }}</td>

                                    <td>{{ $value->convert_amount }}</td>

    
                                    <td>
                                        
                                        @can('Payment.Edit')
                
                                            <a href="{{ route('payment.edit',encrypt($value->id)) }}" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                        @endcan    
                                        
                                    </td>

                                </tr>

                                @endforeach

                                    @if ($payments->count() == 0)

                                    <tr class="text-center">

                                        <td colspan="6">No payments to display.</td>

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



