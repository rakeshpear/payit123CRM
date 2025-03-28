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

           Employee

        @endslot

        @slot('title')

            Employee

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
                                @can('Employee.Create')
                                   <a href="{{route('employee.create')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-plus me-1"></i> New Employee</button>

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


                                    <th scope="col">Name</th>

                                    <th scope="col">Email</th>

                                    <th scope="col">Role</th>

                                    <th scope="col">Phone</th>

                                   

                                    <th scope="col" style="width: 200px;">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(!empty($users))

                                @foreach($users as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>
                                    

                                    <td>{{ $value->name }}</td>

                                    <td>{{ $value->email }}</td>

                                    <td>{{ $value->Role->name }} </td>


                                    <td>{{ $value->phone }}</td>

                                   

                                    <td>

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        @can('Employee.Edit')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">

                                            <a href="{{ route('employee.edit',encrypt($value->id)) }}" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                        </li>
                                        @endcan

                                        @can('Employee.Delete')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">

                                           <a href="{{ route('employee.delete', encrypt($value->id)) }}" class="delete-link" onclick="return confirm('Are you sure you want to delete this Employee?')"><i class="mdi mdi-delete-outline"></i></a>

                                        </li>
                                        @endcan

                                        @can('Employee.Account')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View Account">

                                            <a href="{{ route('employee.view.more',encrypt($value->id)) }}" class="btn btn-sm btn-soft-info"><i class='fas fa-user-alt'></i> View Account</a>

                                        </li>
                                        @endcan

                                    </ul>

                                      </td>

                                </tr>

                                @endforeach

                                    @if ($users->count() == 0)

                                    <tr class="text-center">

                                        <td colspan="6">No Employee to display.</td>

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



