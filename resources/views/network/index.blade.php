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

            Network

        @endslot

    @endcomponent

    <div class="row">

        <div class="col-lg-12">

            <div class="row mb-1">

                <div class="col-sm-4">

                    <div class="search-box me-2 mb-2 d-inline-block">

                        <div class="position-relative">

                        </div>

                    </div>

                </div>

                <div class="col-sm-8">

                    <div class="text-sm-end">

                        <a href="{{ route('network.create') }}">

                            <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">
                                
                                <i class="mdi mdi-plus me-1"></i> Add New

                            </button>

                        </a>

                    </div>

                </div>

            </div>

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100 display" id="example">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Name</th>

                                    <th scope="col">Crypto</th>

                                    <th scope="col">Status</th>

                                    <th scope="col">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($datas as $key => $data)

                                    <tr>
                                    
                                        <td>{{ ++$key }}</td>

                                        <td>{{ $data->name }}</td>

                                        <td>{{ $data->crypto?$data->crypto->crypto:'' }}</td>

                                        <td class="text-success">
                                            @if($data->status=='1')
                                                <a href="{{ route('network.status',$data->id) }}" class="btn btn-sm btn-success">Active</a>
                                            @else
                                                <a href="{{ route('network.status',$data->id) }}" class="btn btn-sm btn-danger">Inactive</a>
                                            @endif
                                        </td>

                                        <td>
                                            
                                            <ul class="list-unstyled hstack gap-1 mb-0">

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">

                                                    <a href="{{ route('network.edit',$data->id) }}" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                    <a href="{{ route('network.delete',$data->id) }}" class="delete-link btn btn-sm btn-soft-danger" onclick="return confirm('Are you sure you want to delete this network?')"><i class="mdi mdi-delete-outline"></i></a>

                                                </li>

                                            </ul>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')

    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>

    <script>
        jQuery(document).ready(function(){
            new DataTable('#example');
        });
    </script>

    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

@endsection