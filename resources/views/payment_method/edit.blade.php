@extends('layouts.master')

@section('title') @lang('Payment Method') @endsection

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">

@component('components.breadcrumb')
    @slot('li_1') Payment Method @endslot
    @slot('title') Payment Method @endslot
@endcomponent

<style>
    .flot-right{
        float: right;
    }
    .select-w {
        width: 100% !important;
    }
</style>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 57px;
  height: 25px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 25px;
  width: 26px;
  left: 4px;
  bottom: 0px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #008000a1;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

 .remove-sec {
    margin-left: -2%;
 }
</style>

<div class="row">
    <div class="col-xl-12">
        <div class="card overflow-hidden">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('payment.method') }}">
                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <form autocomplete="off" action="{{ route('payment.method.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $payment->id }}">
                <div class="card-body pt-0 mt-4"> 
                    <div class="row"> 
                    <div class="col-lg-4">
                        <label>Domain (www.example.com)</label>
                        <div class="form-group mt-2">
                            <input type="text" class="form-control" name="doman_name" value="{{ $payment->doman_name }}" required placeholder="www.example.com">
                        </div>
                    </div>
                        
                    <div class="col-lg-4">
                        <div class="form-group mt-2">
                            <label>Gateway Name</label>
                            <input type="text" class="form-control" name="payment_gateway" value="{{ $payment->payment_gateway }}" required placeholder="Enter gateway name">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mt-2">
                            <label>PSP Time (<small class="text-info">In Minute</small>)</label>
                            <input type="text" class="form-control" name="psp_time_minute" value="{{ $payment->psp_time_minute }}" placeholder="Enter PSP Time In Minute">
                        </div>
                    </div>

                    <hr>

                    <h5 class="card-title">Gateway Info</h5>

                    <hr>

                    <div class="col-lg-12">
                        <div class="form-group mt-2">
                            <label>URL</label>
                            <input type="url" class="form-control" name="url" value="{{ $payment->url }}" placeholder="Enter URL">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h5 class="text-muted"><b>Live Details</b></h5>
                    </div>

                    <div class="col-lg-6">
                        <h5 class="text-muted"><b>Test Details</b></h5>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Live Payment Key</label>
                            <input type="text" class="form-control" name="payment_key" value="{{ $payment->payment_key }}" placeholder="Enter Live payment key" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Test Payment Key</label>
                            <input type="text" class="form-control" name="test_payment_key" value="{{ $payment->test_payment_key }}" placeholder="Enter Test payment key">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Live Payment Secret</label>
                            <input type="text" class="form-control" name="payment_secret" value="{{ $payment->payment_secret }}" placeholder="Enter Live payment secret" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Test Payment Secret</label>
                            <input type="text" class="form-control" name="test_payment_secret" value="{{ $payment->test_payment_secret }}" placeholder="Enter Test payment secret">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Live Merchant ID</label>
                            <input type="text" class="form-control" name="merchant_id" value="{{ $payment->merchant_id }}" placeholder="Enter Live Merchant ID">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Test Merchant ID</label>
                            <input type="text" class="form-control" name="test_merchant_id" value="{{ $payment->test_merchant_id }}" placeholder="Enter Test Merchant ID">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Live Request URL</label>
                            <input type="url" class="form-control" name="live_request_url" value="{{ $payment->live_request_url }}" placeholder="Enter Live Request URL">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Test Request URL</label>
                            <input type="url" class="form-control" name="test_request_url" value="{{ $payment->test_request_url }}" placeholder="Enter Test Request URL">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Live Return URL</label>
                            <input type="url" class="form-control" name="live_return_url" value="{{ $payment->live_return_url }}" placeholder="Enter Live Return URL">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Test Return URL</label>
                            <input type="url" class="form-control" name="test_return_url" value="{{ $payment->test_return_url }}" placeholder="Enter Test Return URL">
                        </div>
                    </div>
                </div>

                <hr>

                    <h5 class="card-title">Config</h5>

                    <hr>

                    <div class="row">
                        @php
                            $label_names = !empty($payment->label_name) ? json_decode($payment->label_name, true) : [];
                            $label_keys = !empty($payment->label_key) ? json_decode($payment->label_key, true) : [];
                        @endphp

                        @if(!empty($label_names) && !empty($label_keys))
                            @foreach($label_names as $index => $label_name)
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Label Name</label>
                                        <input type="text" name="label_name[]" value="{{ $label_name }}" class="form-control" placeholder="Enter Label Name">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Key</label>
                                        <input type="text" name="label_key[]" value="{{ $label_keys[$index] }}" class="form-control" placeholder="Enter Key">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                </div>
                            @endforeach
                        @endif

                        <div class="addMore">
                            <!-- Dynamic fields will be appended here -->
                        </div>
                    </div>

                    
                    <button class="btn btn-success btn-sm mt-3" type="button" onclick="addMore()"><i class="fa fa-plus"></i> Add New Config</button>


                    <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Sale End Point</label>
                            <input type="text" class="form-control" name="sale_end_point" value="{{ $payment->sale_end_point }}" placeholder="Enter Sale End Point">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Get End Point</label>
                            <input type="text" class="form-control" name="get_end_point" value="{{ $payment->get_end_point }}" placeholder="Enter Get End Point">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Min Amount</label>
                            <input type="number" class="form-control" name="min_amount" value="{{ $payment->min_amount }}" placeholder="Enter Min Amount">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-2">
                            <label>Max Amount</label>
                            <input type="number" class="form-control" name="max_amount" value="{{ $payment->max_amount }}" placeholder="Enter Max Amount">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mt-2">
                            <label>Country</label>
                            <select class="selectpicker select-w" name="country[]" multiple data-live-search="true">
                                <option value="">Select Country</option>
                                @foreach($country as $value)
                                    @if(json_decode($payment->country, true))
                                        @if(in_array($value->id, json_decode($payment->country, true)))
                                            <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endif
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mt-2">
                            <label>Currency</label><br>
                            <select class="selectpicker currency select-w" name="currency[]" multiple data-live-search="true">
                                <option value="">Select Currency</option>
                                @foreach($currencies as $value)
                                    @if(json_decode($payment->currency, true))
                                        @if($payment->currency && in_array($value->id, json_decode($payment->currency, true)))
                                            <option value="{{ $value->id }}" selected>{{ $value->name }} ({{ $value->symbol }})</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->symbol }})</option>
                                        @endif
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->symbol }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mt-2">
                            <label>3D</label>
                            <input type="text" class="form-control" name="three_d" value="{{ $payment->three_d }}" placeholder="Enter 3D">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mt-2">
                            <label>2D/3D</label><br>
                            <label class="switch mt-2">
                                <input type="checkbox" name="two_d_three_d" value="Yes" {{ $payment->two_d_three_d == 'Yes' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>                    

                    <div class="col-lg-4">
                        <label>Is Live Payment</label><br>
                        <label class="switch mt-2">
                            <input type="checkbox" name="live_key" value="Yes" {{ $payment->is_live_key == 'Yes' ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="col-lg-4">
                        <label>Is Active</label><br>
                        <label class="switch mt-2">
                            <input type="checkbox" name="status" {{ $payment->status == '1' ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

              </div>

                <div class="text-center mb-4">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('script')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $('.currency').selectpicker();
    $('.selectpicker').selectpicker();

</script>

<script>
    function addMore() {
        var html = `
        <div class="row mt-2">
            <div class="col-lg-5">
                <input type="text" name="label_name[]" class="form-control" placeholder="Label" required>
            </div>
            <div class="col-lg-5">
                <input type="text" name="label_key[]" class="form-control" placeholder="Value" required>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-danger btn-sm " type="button" onclick="removeField(this)"><i class="fa fa-remove"></i> Remove</button>
            </div>
        </div>`;
        $('.addMore').append(html);
    }

    function removeField(btn) {
        $(btn).closest('.row').remove();
    }
</script>

@endsection
