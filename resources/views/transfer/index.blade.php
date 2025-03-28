@extends('layouts.master')



@section('title')

    @lang('Transfer')

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

            Transfer

        @endslot

        @slot('title')

         Transfer

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-4">

            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">

                        <div class="col-sm-4">

                            <div class="search-box me-2 mb-2 d-inline-block">

                                <div class="position-relative">

                                   Add Transfer

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-8">

                            <div class="text-sm-end">

                            </div>

                        </div><!-- end col-->

                    </div>

                    <form autocomplete="off" action="{{ route('user.store') }}" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">
                           

                            <div class="form-group col-lg-12 mt-3">
                            <label>Account <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                             <div class="form-group col-lg-12">
                                <label>Code<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="name" value="" placeholder="code" required/>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                                <label>Date <span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="Date" value="" placeholder="Date" required/>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                                <label>Description <span class="text-danger"></span></label>
                                   <input type="number" class="form-control" name="description" value="" placeholder=" Description " required/>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                               <label for="designation-input" class="form-label">Attach File</label>
                                <input type="file" class="form-control" placeholder="" name="dob" required />
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Currency <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                                <label>Amount<span class="text-danger"></span></label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="password" value="" placeholder="Enter Amount" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Category <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                                <label>Tags<span class="text-danger"></span></label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="password" value="" placeholder="" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Company <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Payer <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Staff <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Method <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Item <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                            <label>Status <span class="text-danger"></span></label>
                            <select class=" form-control dropdown-toggle" name="role" type="button" data-toggle="dropdown">      
                             </select>
                            </div>

                            <div class="form-group col-lg-12 mt-3">
                               <label for="designation-input" class="form-label">Ref#</label>
                                <input type="text" class="form-control" placeholder="e.g. Transaction ID, Check No" name="dob" required />
                            </div>

                            

                        </div>

                        <div class="text-center" style="margin-top:20px">

                            <button type="submit" class="btn btn-success">Submit</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">

                        <div class="col-sm-4">

                            <div class="search-box me-2 mb-2 d-inline-block">

                                <div class="position-relative">

                                    Recent Transfer

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

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100"

                            id="">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col" style="width: 40px;">#</th>

                                    <th scope="col">Account</th>

                                    <th scope="col">Description</th>

                                    <th scope="col">Amount</th>

                                    <!-- <th scope="col" style="width: 200px;">Manage</th> -->

                                </tr>

                            </thead>


                            <tbody>

                                <tr>

                                    <td>1</td>
                                    <td>JPMorgan Chase & Co.</td>

                                  <td><a href="{{ route('transferedit') }}">Invoice 3 Payment</a></td>

                                     <td>149.00</td>

                                </tr>

                                 <tr>

                                    <td>1</td>
                                    <td>JPMorgan Chase & Co.</td>

                                    <td><a href="{{ route('transferedit') }}">Web Development</a></td>

                                     <td>149.00</td>

                                </tr>

                                <tr>

                                    <td>1</td>
                                    <td>JPMorgan Chase & Co.</td>

                                   <td><a href="{{ route('transferedit') }}">Sales</a></td>

                                     <td>149.00</td>

                                </tr>

                                <tr>

                                    <td>1</td>
                                    <td>JPMorgan Chase & Co.</td>

                                   <td><a href="{{ route('transferedit') }}">Consultancy</a></td>

                                     <td>149.00</td>

                                </tr>


                               <tr>

                                    <td>1</td>
                                    <td>JPMorgan Chase & Co.</td>

                                    <td><a href="{{ route('transferedit') }}">Record initial balance</a></td>

                                     <td>149.00</td>

                                </tr>




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



                    <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this Account ?</p>







                    <div class="hstack gap-2 justify-content-center mb-0">



                        <a href=""><button type="button" class="btn btn-danger" id="remove-item">Remove Now</button></a>




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

