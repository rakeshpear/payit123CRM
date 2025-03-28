@extends('layouts.master')

@section('title')

    @lang('Network')

@endsection

@section('css')

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Network

        @endslot

        @slot('title')

            Add New Network

        @endslot

    @endcomponent

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <form autocomplete="off" action="{{ route('network.store') }}" method="Post">
                        @csrf

                        <div class="row">

                            <div class="col-lg-6 mt-2 beneficiary_section">
                                
                                <div class="form-group">
                                    
                                    <label>Crypto</label>

                                    <select class="form-control" name="crypto_id">
                                        <option value="">Select Crypto</option>
                                        @foreach($datas as $key => $data)
                                        <option value="{{ $data->id }}">{{ $data->crypto }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2 beneficiary_section">
                                
                                <div class="form-group">
                                    
                                    <label>Network</label>

                                    <input type="text" name="name" class="form-control" placeholder="Network">

                                </div>
                                
                            </div>

                        </div>

                        <div class="text-center mt-4">
                            
                            <button class="btn btn-success">Submit</button>

                        </div>

                    </form>

                </div>



            </div>



        </div>



    </div>



@endsection

@section('script')

@endsection



