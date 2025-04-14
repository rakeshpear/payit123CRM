@extends('layouts.master')

@section('title')



    @lang('LeaveType')



@endsection



@section('css')



    <!-- select2 css -->



    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- DataTables -->



    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">


    <style type="text/css">

        .select2-container--default .select2-selection--single .select2-selection__arrow {

            background-color: #419e41;
            color: white;
        }

    </style>



@endsection



@section('content')



    @component('components.breadcrumb')



        @slot('li_1')



            Home



        @endslot



        @slot('title')



            Leave Type



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">
            
                <!-- Table Card Start -->
                <div class="card">

                    <div class="card-body">

                        <div class="row mt-2 mb-1">

                            <div class="col-md-8">
                                
                            </div>

                            <div class="col-md-4 text-right text-end">
                                @can('LeaveType.Create')
                                <a href="{{url('/leave_type/create/')}}" class="btn btn-success rounded-pill">+ Add Leave Type</a>
                                @endcan
                                
                            </div>
                            
                        </div>

                        <div class="row mt-2"> 

                            <div class="table-responsive">

                                <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100" id="Leavetable">

                                    <thead class="table-light">

                                        <tr>

                                            <th>SL</th>

                                            <th>Leave Name</th>

                                            <th>Total Days</th>

                                            <th>Action</th>

                                          

                                        </tr>

                                    </thead>


                                    <tbody> 

                                        @if(!empty($leaves))

                                        @foreach($leaves as $key => $value)

                                            <tr>

                                                <td>{{++$key}}</td>

                                                <td>{{$value->leave_name}}</td>

                                                <td>{{$value->no_of_days}} Days</td>

                                                <td>
                                                    
                                                    @can('LeaveType.Edit')
                                                    <a href="{{route('leave_type.edit', $value->id)}}" class="btn btn-primary rounded-pill btn-sm">Edit</a>
                                                    @endcan
                                                    
                                                </td>


                                            </tr>

                                        @endforeach

                                        @endif

                                        
                                    </tbody>


                                    <tfoot>

                                        <tr>

                                            <th>SL</th>

                                            <th>Leave Name</th>

                                            <th>Total Days</th>

                                            <th>Action</th>
                                          

                                        </tr>
                                        
                                    </tfoot>



                                </table> <!-- end table -->


                            </div><!-- end table responsive -->

                            {{ $leaves->links() }}
                            
                        </div>

                    </div>

                </div>
          

        </div>



    </div>


@endsection



@section('script')

    <!-- select2 js -->



    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>


    <script type="text/javascript">
          $(".myselect").select2();
    </script>




    <!-- Required datatable js -->



    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>



    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>







    <!-- Responsive examples -->



    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>



    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>



    <!-- ecommerce-customer-list init -->

    <script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

    <!-- Buttons JavaScript -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.flash.min.js"></script>


    <script>

        $(document).ready(function() {
            $('#Leavetable').DataTable({

                dom: 'lBfrtip',
                buttons: ['copy','csv']

            });
        });

    </script>



@endsection



