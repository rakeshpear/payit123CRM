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

           Agent

        @endslot

        @slot('title')

            Commission Schedule

        @endslot

    @endcomponent



    <div class="row">
        
        @include('flash_msg')

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    

                        <div class="row">

                            <h5>Fixed</h5>
                            <br>
                            <br>

                            <form action="{{url('/updateCommissionSchedule')}}" method="post">
                                @csrf

                                <input type="hidden" name="fixed_commission_id" value="{{$fixed_commission->id}}">

                                <div class="row">

                                    <div class="col-md-4">

                                        <label for="rate">Rate(%):&ensp;</label>

                                        <input type="text" name="rate" value="{{$fixed_commission->rate}}" size="10">
                                        
                                    </div>

                                    <div class="col-md-3">

                                        <button type="submit" class="btn btn-primary rounded-pill btn-sm">Update</button>

                                    </div>

                                </div>

                            </form>
                            
                        </div>

                        <hr>

                        <div class="row">

                            <h5>Scalable</h5>
                            <br>
                            <br>

                            <form action="{{url('/updateCommissionSchedule')}}" method="post">

                                @csrf

                                <div class="row">

                                    @foreach($scalable_commission as $key=> $value)

                                        <input type="hidden" name="addmore[{{$key}}][commission_id]" value="{{$value->id}}">

 
                                        <div class="col-md-4">

                                            <label for="volume_from">Volume From:</label>

                                            <input type="text" name="addmore[{{$key}}][volume_from]" value="{{$value->volume_from}}" size="15">
                                            
                                        </div>

                                        <div class="col-md-4">

                                            <label for="volume_to">Volume To:</label>

                                            <input type="text" name="addmore[{{$key}}][volume_to]" value="{{$value->volume_to}}" size="15">
                                            
                                        </div>

                                        <div class="col-md-4">

                                            <label for="rate">Rate(%):</label>

                                            <input type="text" name="addmore[{{$key}}][rate]" value="{{$value->rate}}" size="10">
                                            
                                        </div>

                                    @endforeach 

                                </div>

                                <div class="text-center mt-1">

                                    <button type="submit" class="btn btn-primary rounded-pill btn-sm">Update</button>
                                    
                                </div>
                                
                            </form>
                              
                        </div>

                   

                </div>

            </div>

        </div>

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                        <div class="row">

                            <h5>Charges</h5>
                            <br>
                            <br>

                            <form action="{{url('/updateCharges')}}" method="post">

                                @csrf

                                <div class="row">

                                    @foreach($charges as $key=> $value)

                                        <input type="hidden" name="addcharges[{{$key}}][charges_id]" value="{{$value->id}}">

                                        <div class="col-md-4">
                                            <strong>{{$value->type}}</strong>
                                        </div>
 
                                        <div class="col-md-4">

                                            <label for="fixed_amt">Fixed Amt. :</label>

                                            <input type="text" name="addcharges[{{$key}}][fixed_amt]" value="{{$value->fixed_amt}}" size="15">
                                            
                                        </div>

                                        <div class="col-md-4">

                                            <label for="percent_amt">Percent Amt.(%) :</label>

                                            <input type="text" name="addcharges[{{$key}}][percent_amt]" value="{{$value->percent_amt}}" size="15">
                                            
                                        </div>

                                    @endforeach 

                                </div>

                                <div class="text-center mt-1">

                                    <button type="submit" class="btn btn-primary rounded-pill btn-sm">Update</button>
                                    
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

    <!-- init js -->

    <script src="{{ URL::asset('build/js/pages/crypto-orders.init.js') }}"></script>



@endsection



