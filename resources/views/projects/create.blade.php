@extends('layouts.master')



@section('title')

    @lang('Projects Create')

@endsection

@section('css')

    <!-- select2 css -->

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!--   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
 --> 
    <!-- DataTables -->

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"

        type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Projects

        @endslot

        @slot('title')

         Create  Project

        @endslot

    @endcomponent

    <div class="row">

        @include('flash_msg')

        <div class="col-lg-6 mx-auto">

            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">

                        <div class="col-sm-4">

                            <div class="search-box me-2 mb-2 d-inline-block">

                                <div class="position-relative">

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-8">

                            <div class="text-sm-end">


                                   <a href="{{url('projects')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>

                            </div>

                        </div><!-- end col-->

                    </div>

                    <form autocomplete="off" action="{{ route('projects.store') }}" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">

                            <div class="form-group col-lg-12 mt-2">
                            <label>Project Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="" placeholder="Type Title" required/> 
                            </div>

                            <div class="form-group col-lg-6 mt-2" style="display: inline-block;">
                                <label>Start Date <span class="text-danger"></span></label>
                                <input type="date" class="form-control" name="start_date" value="" placeholder="Select Date"/>
                            </div>

                            <div class="form-group col-lg-6 mt-2" style="display: inline-block;">
                                <label for="designation-input" class="form-label">Deadline</label>
                                <input type="date" class="form-control" placeholder="" name="deadline"/>
                            </div>

                            <div class="form-group col-lg-12 mt-2">
                            <label>Status <span class="text-danger"></span></label>
                            <div class="btn-group">
                                <button style="border: 1px solid;margin-left: 3px;" type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <input type="radio" name="status" value="Open" checked> Open
                                </button>
                                <div class="dropdown-menu">
                                    <label class="dropdown-item">
                                        <input type="radio" name="status" value="Closed"> Closed
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="radio" name="status" value="Progress"> Progress
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group mt-2">
                                    <label>Email <span class="text-danger"></span></label>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <!-- Dropdown -->
                                <?php $datas = $clients; ?>
                                @include('dropdown',$datas)
                            </div>
                            <div class="col-md-3">
                                <!-- Button -->
                                <div class="form-group text-right">
                                    <button type="button" class="mb-2 btn btn-success" data-toggle="modal" data-target="#addclientsModal"> + Add Clients</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group mt-2">
                                <i class="fas fa-user fa-lg mr-2"></i>
                                <span class="h5 mb-0" style="font-size: 1rem;">Team</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <!-- Dropdown -->
                                <select class="selectpicker" multiple data-live-search="true" name="team_ids[]">
                                    @foreach($users as $key => $data)
                                      <option class="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>

                        <div class="text-center" style="margin-top:20px">

                            <button type="submit" class="btn btn-success">Create</button>

                        </div>

                         </div>

                    

                    </form>

                </div>

            </div>

        </div>

    </div>

<!-- Modal Add Clients-->

<div class="modal fade" id="addclientsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Client</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form autocomplete="off" action="{{ route('user.client.store') }}" method="Post">
            @csrf
            <!-- Modal body -->
            <div class="modal-body">

                        <!-- Modal body -->
                        <div class="row">
                           
                            <div class="form-group col-lg-6">
                                <label>Name<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="name" value="" placeholder="Name" required/>
                            </div>

                              <div class="form-group col-lg-6">
                                <label>Role <span class="text-danger"></span></label>
                                <select class="form-control" name="role" disabled>
                                    @foreach($roles as $role)
                                        @if($role->name === 'Customer')
                                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                        @else
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="hidden" name="role" value="{{$customerRoleId}}">
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Email <span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="email" value="" placeholder="Email" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Phone <span class="text-danger"></span></label>
                                <input type="tel" class="form-control" name="phone" placeholder="Enter Phone No" maxlength="10" required/>
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                               <label for="designation-input" class="form-label">DOB</label>
                                <input type="date" class="form-control" placeholder="Enter DOB" name="dob" required />
                            </div>

                            <div class="form-group col-lg-6 mt-3">
                                <label>Password<span class="text-danger"></span></label>
                                <div class="input-group mb-2">
                                    <input type="password" class="form-control" name="password" value="" placeholder="Enter password" required/>
                                </div>
                            </div>  
                        </div>
                   </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
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

