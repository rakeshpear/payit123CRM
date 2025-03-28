@extends('layouts.master')

@section('title')

    @lang('Merchant List')

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

    </style>   

@endsection

@section('content')

    @component('components.breadcrumb')


        @slot('li_1')

           Merchant

        @endslot

        @slot('title')

            Merchant

        @endslot

    @endcomponent



    <div class="row">
        
        @include('flash_msg')

        <div class="col-lg-12">

            <div class="row mb-1">

                        <div class="col-sm-4">

                            <div class="search-box me-2 mb-2 d-inline-block">

                                <div class="position-relative">

                                    <!-- <input type="text" class="form-control" id="searchTableList" placeholder="Search...">

                                    <i class="bx bx-search-alt search-icon"></i> -->

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-8">

                            <div class="text-sm-end">

                                   <!-- <a href="{{route('agentcreate')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-plus me-1"></i> New  Agent</button>

                                    </a> -->

                                    <a href="{{url('agent/view/more',encrypt($agent->id))}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">Back</button>

                                    </a>

                            </div>

                        </div><!-- end col-->

            </div>


            <div class="card p-3">

                <div class="row mb-2">

                        <div class="col-sm-6">

                            <strong>Agent Name: &ensp;{{$agent->name}}</strong>

                        </div>

                        <div class="col-sm-4">

                            <strong>Email: &ensp;{{$agent->email}}</strong>

                        </div><!-- end col-->

                        <div class="col-sm-6 mt-2">

                            <strong>Phone: &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;{{$agent->phone}}</strong>

                        </div>

                        <div class="col-sm-6 mt-2">

                            <strong>Role: &ensp;&ensp;&ensp;{{$agent->Role->name}}</strong>

                        </div>
                </div>  

            </div>

            <div class="card">


                <div class="card-body">

                    

                    <!-- end row -->

                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <!-- <th scope="col" style="width: 40px;">Image</th> -->

                                    <th scope="col">Name</th>

                                    <th scope="col">Email</th>

                                    <th scope="col">Phone</th>

                                    <th scope="col">Currency</th>

                                    <th scope="col">Agent Com.</th>

                                    <th scope="col">Client Com.</th>

                                    <th scope="col">Rolling Res.</th>

                                    <th scope="col">Trans. Fee</th>

                                    <th scope="col" style="width: 200px;">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(!empty($users))

                                @foreach($users as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>
                                    
                                    <!-- <td> <img src="{{ $value->avatar }}" alt="" class="member-img img-fluid d-block rounded-circle" /> </td> -->

                                    <td>{{ $value->name }}</td>

                                    <td>{{ $value->email }}</td>

                                    <td>{{ $value->phone }}</td>

                                    <td>
                                        
                                        @if($value->clientDetails->currency=='$')
                                        USD
                                        @elseif($value->clientDetails->currency=='€')
                                        EURO
                                        @elseif($value->clientDetails->currency=='£')
                                        GBP
                                        @elseif($value->clientDetails->currency=='₹')
                                        INR
                                        @else

                                        @endif
 
                                    </td>

                                    <td>{{ $value->clientDetails->agent_commission }}</td>

                                    <td>{{ $value->clientDetails->client_commission }}</td>

                                    <td>{{ $value->clientDetails->rolling_reserve }}</td>

                                    <td>{{ $value->clientDetails->transaction_fee }}</td>

                                    <td>

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">

                                            <a href="{{ route('customer.edit',encrypt($value->id)) }}" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                            <a href="{{ route('customerdelete', encrypt($value->id)) }}" class="delete-link text-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="mdi mdi-delete-outline"></i></a>

                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View Account">

                                            <a href="{{ route('customer.view.more',encrypt($value->id),) }}" class="btn btn-sm btn-soft-info"><i class='fas fa-user-alt'></i> View Account</a>

                                        </li>
                                    </ul>

                                      </td>

                                </tr>

                                @endforeach

                                    @if ($users->count() == 0)

                                    <tr class="text-center">

                                        <td colspan="11">No User to display.</td>

                                    </tr>

                                    @endif

                                @endif

                            </tbody>

                        </table>

                        <!-- end table -->

                    </div>

                    <div>{{ $users->links()}}</div>
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



