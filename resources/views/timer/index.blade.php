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

           Time

        @endslot

        @slot('title')

            Time List

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

                                  

                            </div>

                        </div><!-- end col-->

                    </div>

                    <!-- end row -->

                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Name</th>

                                    <th scope="col">Date</th>

                                    <th scope="col">Time In</th>

                                    <th scope="col">Time Out</th>

                                    <th scope="col">Total Hours</th>

                                </tr>

                            </thead>

                        

                            <tbody>

                                @if(!empty($timers))

                                @foreach($timers as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>
   
                                    <td>{{ $value->User->name }}</td>

                                    <td>{{ \Carbon\Carbon::parse($value->date)->format('j M Y') }}</td>

                                    <td>
                                        @if ($value->start_time)
                                            {{\Carbon\Carbon::parse($value->start_time)->format('H:i:s')
                                            }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($value->end_time)
                                            {{ \Carbon\Carbon::parse($value->end_time)->format('H:i:s') }}
                                        @endif
                                    </td>


                                     <td>
                                        {{ floor($value->total_hours / 60) }} hrs {{ $value->total_hours % 60 }} min
                                    </td>

                                </tr>

                                @endforeach

                                    @if ($timers->count() == 0)

                                    <tr class="text-center">

                                        <td colspan="6">No Timer to display.</td>

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



