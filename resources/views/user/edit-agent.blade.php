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



            Agent



        @endslot



        @slot('title')



         Update  Agent



        @endslot



    @endcomponent


    <div class="content-wrapper" style="margin-top: 15px">

    <div class="row">

        @include('multiselect')

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


                                   <a href="{{url()->previous()}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>



                            </div>



                        </div><!-- end col-->



                    </div>

                       <form action="{{route('agent.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                        <!-- Modal body -->
                        <div class="row">
                           
                            <div class="form-group col-lg-6">
                                <label>Name<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Name">
                            </div>

                            <div class="form-group col-lg-6">
                                    <label>Customer <span class="text-danger"></span></label>
                                     <select class="form-control selectpicker multiselect" name="customers[]" multiple data-live-search="true">
                                        <option value="">Select Customer</option>

                                        @foreach($customers as $customer)
                                            @if($user->customers!=null)

                                                @if (in_array($customer->id, json_decode($user->customers)))
                                                    <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                                                @else
                                                    <option value="{{ $customer->id }}" >{{ $customer->name }}</option>
                                                @endif

                                            @else
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>

                                            @endif

                                        @endforeach
                                      </select>
                                </div>


                            <div class="form-group col-lg-6 mt-3">
                                <label>Email <span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="email" value="{{ $user->email }}" placeholder="Email">
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}" placeholder="Enter Phone No" maxlength="10" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Commission (%)</label>
                                <input type="text" class="form-control" name="commission" value="{{ $user->commission }}" placeholder="Commission in percentage (%)"/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Payout (USDT)</label>
                                <input type="text" class="form-control" name="payout" value="{{ $user->payout }}" placeholder="Payout in USDT"/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Amount Limit</label>
                                <input type="text" class="form-control" name="amount_limit" value="{{ $user->amount_limit }}" placeholder="Amount Limit"/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Commission Schedule<span class="text-danger"></span></label>
                                <div class="input-group mb-2">
                                    <input type="radio" id="fixed"  name="commission_schedule" value="Fixed" @if($user->commission_schedule=='Fixed')checked @endif>&ensp;
                                    <label for="fixed" class="mt-1">Fixed</label>
                                    &ensp;&ensp;&ensp;&ensp;
                                    <input type="radio" id="scalable" name="commission_schedule" value="Scalable"  @if($user->commission_schedule=='Scalable')checked @endif>&ensp;
                                    <label for="scalable" class="mt-1">Scalable</label>
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



                        <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>



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



