@extends('layouts.master')

@section('title')

    @lang('Create Client Payment')

@endsection

@section('css')

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Payment

        @endslot

        @slot('title')

        Create Client Payment 

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

                                <a href="{{ route('admin.allclients')}}">

                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">

                                        <i class="mdi mdi-arrow-left me-1"></i> Back

                                    </button>

                                </a>

                            </div>

                        </div><!-- end col-->

                    </div>

                    <form autocomplete="off" action="{{ route('user.store') }}" method="Post">

                        @csrf

                        <div class="row">
                           
                            <div class="col-lg-6">

                                <div class="form-group">
                                            
                                    <label>Payment Gateway<span class="text-danger">*</span></label>
                                    <select class="form-control select2 mb-2" name="payment_gateway_id" required>
                                        <option value="">Select Payment Gateway</option>
                                        @foreach($payment as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->payment_gateway }} ({{ $value->doman_name }})</option>
                                        @endforeach
                                    </select>

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

    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

    <script>

        $(document).ready(function() {

            $('.select2').select2();
            
        });

    </script>

@endsection



