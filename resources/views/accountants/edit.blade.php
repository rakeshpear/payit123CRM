@extends('layouts.master')



@section('title')



    @lang('User Add')



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



            Account



        @endslot



        @slot('title')



        Add New Account



        @endslot



    @endcomponent


    <div class="content-wrapper" style="margin-top: 15px">

    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-body">

                     <div class="row mb-2">



                        <div class="col-sm-4">



                            <div class="search-box me-2 mb-2 d-inline-block">



                            </div>



                        </div>



                        <div class="col-sm-8">



                            <div class="text-sm-end">


                                   <a href="{{url('accounts')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                       class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>



                            </div>



                        </div><!-- end col-->



                    </div>

                       <form autocomplete="off" action="{{ route('accounts.store') }}" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">
                           
                            <div class="form-group col-lg-6">
                                <label>Account Title<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" name="name" value="" placeholder="Enter Account Title" required/>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Description <span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="description" value="" placeholder="Description" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Initial Balance [ USD ] <span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="phone" value="" placeholder="Enter Initial Balance" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                               <label>Account Number</label>
                                <input type="text" class="form-control" placeholder="Enter Account Number" name="dob" required />
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Contact Person<span class="text-danger"></span></label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="password" value="" placeholder="Enter Contact Person" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Phone<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="phone" value="" placeholder="Enter Phone" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                               <label>Internet Banking URL</label>
                                <input type="text" class="form-control" placeholder="Enter Account Number" name="dob" required />
                            </div>


                            <div class="form-group col-lg-6 mt-3">
                                    <label>Owner <span class="text-danger"></span></label>
                                     <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">
                                        <option value="">Select Owner</option>
                                        
                                      </select>
                            </div>

                            

                        </div>

                        <div class="text-center" style="margin-top:20px">

                            <button type="submit" class="btn btn-success">Submit</button>

                        </div>

                    </form>

                </div>

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



@endsection



