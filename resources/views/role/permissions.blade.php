@extends('layouts.master')







@section('title')



    @lang('Role Permission')



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



            Contacts



        @endslot



        @slot('title')



            Role List



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">



            <div class="card">



                <div class="card-body">



                    <div class="row mb-2">



                        <div class="col-sm-4">



                            <div class="search-box me-2 mb-2 d-inline-block">



                            </div>



                        </div>



                        <div class="col-sm-8">



                            <div class="text-sm-end">


                                   <a href="{{url('roles')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>



                            </div>



                        </div><!-- end col-->



                    </div>



                    <!-- end row -->


                    <form action="{{ route('assign.permission') }}" method="POST" id="vendor_register">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Role<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="{{$dats->name}}" readonly>
                                            <input type="hidden" name="role_id" value="{{$dats->id}}">
                                        </div>
                                    </div>
                                    <div class="row mt-4 ">
                                      
                                        <table class="permissionTable table">
                                            <th>
                                                {{__('Section')}}
                                            </th>

                                            <th>
                                                <label>
                                                    
                                                    {{__('Select All') }}
                                                </label>
                                            </th>
                                
                                            <th>
                                                {{__("Available permissions")}}
                                            </th>
                                
                                
                                           
                                            <tbody class="role-permission">
                                               @foreach($custom_permission as $key => $group)
                                                <tr>
                                                    <td>
                                                        <b>{{ ucfirst($key) }}</b>
                                                    </td>

                                                    <td width="30%">
                                                        <label>
                                                            <input class="selectall" onclick="selectAll(this.value)" value="{{$key}}" type="checkbox">
                                                            {{__('Select All') }}
                                                        </label>
                                                    </td>

                                                    <td>
                                                        
                                                        @forelse($group as $permission)
                                                            
                                                           <label>
                                                                @if(in_array($permission->id, $permissionIds))
                                                                   <input name="permissions[]" class="permissioncheckbox {{$key}}" type="checkbox" checked value="{{ $permission->id }}">
                                                                   &nbsp; {{ucfirst($permission->name)}} &nbsp;&nbsp;
                                                                @else
                                                                    <input name="permissions[]" class="permissioncheckbox {{$key}}" type="checkbox" value="{{ $permission->id }}">
                                                                   &nbsp; {{ucfirst($permission->name)}} &nbsp;&nbsp;
                                                                @endif
                                                           </label>
                                
                                                        @empty
                                                            {{ __("No permission in this group !") }}
                                                        @endforelse
                                
                                                    </td>
                                
                                                </tr>
                                               @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success bg-grad-4">Update</button>
                                        <input type="reset" class="btn btn-danger" value="Reset">
                                    </div>

                                </form>



                    <!-- end table responsive -->



                </div>



            </div>



        </div>



    </div>





    <!-- removeItemModal -->




    <!-- end removeItemModal -->



@endsection



@section('script')
    
    <script>
        function selectAll(argument) {
           
            var cls = "."+argument;

            if($(cls).prop('checked')==true){
               
                $(cls).prop('checked', false);
            } else {
               
                $(cls).prop('checked', true); 
            }
            
        }
    </script>


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



