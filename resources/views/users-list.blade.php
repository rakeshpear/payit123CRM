@extends('layouts.master')







@section('title')



    @lang('translation.User_List')



@endsection



@section('css')



    <!-- select2 css -->



    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />







    <!-- DataTables -->



    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />







    <!-- Responsive datatable examples -->



    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"



        type="text/css" />



@endsection



@section('content')



    @component('components.breadcrumb')



        @slot('li_1')



            Contacts



        @endslot



        @slot('title')



            Users List



        @endslot



    @endcomponent







    <div class="row">



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


                                   <a href="{{route('user.create')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-plus me-1"></i> New Contact</button>

                                    </a>



                            </div>



                        </div><!-- end col-->



                    </div>



                    <!-- end row -->



                    <div class="table-responsive">



                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100" id="userList-table">



                            <thead class="table-light">



                                <tr>



                                    <th scope="col" style="width: 40px;">#</th>



                                    <th scope="col">Name</th>



                                    <th scope="col">Email</th>



                                    <th scope="col">DOB</th>



                                    <th scope="col" style="width: 200px;">Action</th>



                                </tr>



                            </thead>



                            <tbody>

                                @foreach(App\Models\User::all() as $key => $user)

                                <tr>

                                    

                                    <td> <img src="{{ $user->avatar }}" alt="" class="member-img img-fluid d-block rounded-circle" /> </td>



                                    <td>{{ $user->name }}</td>



                                    <td>{{ $user->email }}</td>



                                    <td>{{ $user->dob }}</td>


                                    <td>

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">

                                            <a href="{{ route('user.edit',encrypt($user->id)) }}" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">

                                            <a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="mdi mdi-delete-outline"></i></a>

                                        </li>
                                    </ul>

                                      </td>

                                </tr>

                                @endforeach



                            </tbody>



                        </table>



                        <!-- end table -->



                    </div>



                    <!-- end table responsive -->



                </div>



            </div>



        </div>



    </div>


    <!-- removeItemModal -->



    <div class="modal fade" id="removeItemModal" tabindex="-1" aria-hidden="true">



        <div class="modal-dialog modal-dialog-centered modal-sm">



            <div class="modal-content">



                <div class="modal-body px-4 py-5 text-center">



                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"



                        aria-label="Close"></button>



                    <div class="avatar-sm mb-4 mx-auto">



                        <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">



                            <i class="mdi mdi-trash-can-outline"></i>



                        </div>



                    </div>



                    <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this User ?</p>







                    <div class="hstack gap-2 justify-content-center mb-0">



                        <a href="{{ route('user.delete', encrypt($user->id)) }}"><button type="button" class="btn btn-danger" id="remove-item">Remove Now</button></a>




                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>



                    </div>



                </div>



            </div>



        </div>



    </div>



    <!-- end removeItemModal -->



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



@endsection



