@extends('layouts.master')



@section('title')



    @lang('Customer/Client Add')



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



           Add Customer/Client 



        @endslot



        @slot('title')



        Add Customer/Client 



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


                                   <a href="{{route('customer.index',$agentid)}}">

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
                       <form autocomplete="off" action="{{ route('agent.customer.store') }}" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">
                           <input type="hidden" name="role" value="{{$role->id}}">
                           <input type="hidden" name="registered_by" value="{{$agentid}}">

                            <div class="form-group col-lg-6">
                                <label>Name<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" name="name" value="" placeholder="Name" required/>
                            </div>

                            

                            <div class="form-group col-lg-6 ">
                                <label>Email <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" name="email" value="" placeholder="Email" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone" placeholder="Enter Phone No" maxlength="10" required/>
                            </div>

                            

                            <div class="form-group col-lg-6 mt-3">
                                <label>Password<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="password" class="form-control" name="password" value="" placeholder="Enter password" required/>
                                </div>
                            </div>

                            <h5 class="mt-3">Commissions>>> 

                                Select Currency <select class="" name="currency">

                                    <option value="$" >($) USD</option>
                                    <option value="€" >(€) EURO</option>
                                    <option value="£" >(£) GBP</option>
                                    <option value="₹" >(₹) INR</option>
                                    
                                </select>
                            </h5>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Agent Commission (Fee)<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="agent_commission" value="" placeholder="Agent Commission" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Client Commission (Fee)<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="client_commission" value="" placeholder="Client Commission" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Rolling Reserve<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="rolling_reserve" value="" placeholder="Rolling Reserve" required/>
                                </div>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Transaction Fee<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="transaction_fee" value="" placeholder="Transaction Fee" required/>
                                </div>
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



