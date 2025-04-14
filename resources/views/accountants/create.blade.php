@extends('layouts.master')



@section('title')



    @lang('Bill')



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



            Bill



        @endslot



        @slot('title')



        Bill



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

                              Customer Bill

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

                       <form autocomplete="off" action="" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">

                            <div class="form-group col-lg-4 mt-3">
                                <label>Vender<span class="text-danger">*</span></label>
                                   <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">
                                        
                                      </select>
                            </div>

                            <div class="form-group col-lg-4 mt-3">
                                <label>Bill Date<span class="text-danger"></span></label>
                                   <input type="date" class="form-control" name="phone" value="" placeholder="" required/>
                            </div>

                             <div class="form-group col-lg-4 mt-3">
                                <label>Bill<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="phone" value="" placeholder="" required/>
                            </div>

                            <div class="form-group col-lg-4 mt-3">
                                <label>Currency<span class="text-danger"></span></label>
                                   <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">
                                        
                                      </select>
                            </div>

                            <div class="form-group col-lg-4 mt-3">
                                <label>Due Date<span class="text-danger"></span></label>
                                   <input type="date" class="form-control" name="phone" value="" placeholder="" required/>
                            </div>

                           
                            <div class="form-group col-lg-4 mt-3">
                                <label>P.O/S.O<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="phone" value="" placeholder="" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label for="exampleFormControlTextarea1">Note</label>
                                   <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                          

                        </div>



                        <div class="container-fluid" style="border-radius: 1px; solid:black;">
 
                          <div class="table-responsive">



                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">



                            <thead class="table-light">



                                <tr>



                                    <th scope="col" style="width: 40px;">Image</th>



                                    <th scope="col">Name</th>



                                    <th scope="col">Email</th>


                                    <th scope="col">Phone</th>


                                    <th scope="col">DOB</th>



                                    <th scope="col" style="width: 200px;">Action</th>



                                </tr>



                            </thead>

                        

                        </table>



                        <!-- end table -->



                    </div>

                        </div>



                        <div class="text-left" style="margin-top:20px">

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



