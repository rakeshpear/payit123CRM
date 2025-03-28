@extends('layouts.master')



@section('title')



@lang('Customer/Client')



@endsection



@section('css')



<!-- select2 css -->
<!-- <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> -->

<!-- DataTables -->
<!-- <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> -->

<!-- Responsive datatable examples -->


@endsection


@section('content')

<style>
    .flot-right {
        float: right;
    }

    .select-w {
        width: 100% !important;
    }
</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">


@component('components.breadcrumb')



@slot('li_1')



Edit Customer/Client



@endslot



@slot('title')



Edit Customer/Client



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


                                <a href="{{route('customer.index',$user->registered_by)}}">

                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                            class="mdi mdi-arrow-left me-1"></i> Back</button>

                                </a>



                            </div>



                        </div><!-- end col-->



                    </div>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form autocomplete="off" action="{{ route('customer.update',$user->id) }}" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">


                            <div class="form-group col-lg-6">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="Name" required />
                            </div>



                            <div class="form-group col-lg-6 ">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" value="{{$user->email}}" placeholder="Email" required />
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone" value="{{$user->phone}}" placeholder="Enter Phone No" maxlength="10" required />
                            </div>

                            <div class="col-lg-6">

                            </div>

                            <h5 class="mt-2">Commissions>>>

                                Select Currency <select class="" name="currency">

                                    <option value="$" @selected('$'==$client_details->currency)>($) USD</option>
                                    <option value="€" @selected('€'==$client_details->currency)>(€) EURO</option>
                                    <option value="£" @selected('£'==$client_details->currency)>(£) GBP</option>
                                    <option value="₹" @selected('₹'==$client_details->currency)>(₹) INR</option>

                                </select>
                            </h5>


                            <div class="form-group col-lg-6 ">
                                <label>Agent Commission<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="agent_commission" value="{{$client_details->agent_commission}}" placeholder="Agent Commission" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Client Commission<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="client_commission" value="{{$client_details->client_commission}}" placeholder="Client Commission" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Extra Client (Fee)</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="extra_client" value="{{$client_details->extra_client_fee}}" placeholder="Extra Client (Fee)" />
                                </div>
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Rolling Reserve<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="rolling_reserve" value="{{$client_details->rolling_reserve}}" placeholder="Rolling Reserve" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>PSP<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="psp" value="{{$client_details->psp}}" placeholder="PSP" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Agents<span class="text-danger">*</span></label>

                                @if($client_details->agents !== null)
                                <div class="input-group mb-2">
                                    <select class="selectpicker select-w" name="agents[]" multiple data-live-search="true" required>
                                        <option value="">Select Agents</option>
                                        @foreach($agents as $value)
                                        <option value="{{ $value->id }}" {{in_array($value->id, $client_details->agents) ? 'selected' : ''}}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                <div class="input-group mb-2">
                                    <select class="selectpicker select-w" name="agents[]" multiple data-live-search="true" required>
                                        <option value="">Select Agents</option>
                                        @foreach($agents as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Payit123 Share<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="payit123share" value="{{$client_details->payit123share}}" placeholder="Payit123 Share" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Transaction Fee<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="transaction_fee" value="{{$client_details->transaction_fee}}" placeholder="Transaction Fee" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label>Transaction Fee<span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" class="form-control" name="transaction_fee" value="{{$client_details->transaction_fee}}" placeholder="Transaction Fee" required />
                                </div>
                            </div>


                        </div>

                        <div class="text-center" style="margin-top:20px">

                            <button type="submit" class="btn btn-success">Update</button>

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

<!-- 

<script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>



<script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script> -->


<!-- Responsive examples -->

<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>


<!-- ecommerce-customer-list init -->


@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $('.selectpicker').selectpicker();
</script>

@endsection


@endsection