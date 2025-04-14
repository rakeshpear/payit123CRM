@extends('layouts.master')

@section('title')

    @lang('Crypto')

@endsection

@section('css')

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Crypto

        @endslot

        @slot('title')

            Update Crypto

        @endslot

    @endcomponent

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <form autocomplete="off" action="{{ route('crypto.update') }}" method="Post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="row">

                            <div class="col-lg-6 mt-2 beneficiary_section">
                                
                                <div class="form-group">
                                    
                                    <label>Crypto</label>

                                    <input type="text" name="crypto" class="form-control" value="{{ $data->crypto }}" placeholder="Crypto">

                                </div>
                                
                            </div>

                            

                        </div>

                        <div class="text-center mt-4">
                            
                            <button class="btn btn-success">Update</button>

                        </div>

                    </form>

                </div>



            </div>



        </div>



    </div>



@endsection

@section('script')

@endsection



