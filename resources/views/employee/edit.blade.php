@extends('layouts.master')



@section('title')



    @lang('User Edit')



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



            User



        @endslot



        @slot('title')



         Update  Employee



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


                                   <a href="{{url('/employee/users')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>



                            </div>



                        </div><!-- end col-->



                    </div>
                    @if (count($errors) > 0)
                        <div class = "alert alert-danger">
                            <ul>
                               @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                               @endforeach
                            </ul>
                        </div>
                    @endif
                       <form action="{{route('employee.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                        <!-- Modal body -->
                        <div class="row">
                           
                            <div class="form-group col-lg-6">
                                <label>Name<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Name">
                            </div>

                           

                            <div class="form-group col-lg-6 ">
                                <label>Email <span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="email" value="{{ $user->email }}" placeholder="Email">
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}" placeholder="Enter Phone No" maxlength="10" required/>
                            </div>

                            <div class="form-group col-lg-2 mt-3">
                                <label>Cost<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="cost" value="{{ $user->cost }}" placeholder="Enter Cost" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 mt-3">
                                <label>Currency<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <select name="currency" class="form-control" required>
                                        <option value="$" @selected('$' == $user->currency)>($) USD</option>
                                        <option value="€" @selected('€' == $user->currency)>(€) EURO</option>
                                        <option value="£" @selected('£' == $user->currency)>(£) GBP</option>
                                        <option value="₹" @selected('₹' == $user->currency)>(₹) INR</option>
                                        
                                    </select>
                                </div>
                            </div>
                            

                        </div>

                        <div class="text-center" style="margin-top:20px">

                            <button type="submit" class="btn btn-success">Updated</button>

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



