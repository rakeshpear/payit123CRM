@extends('layouts.master')

@section('title')



    @lang('Leave')



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




@endsection



@section('content')



    @component('components.breadcrumb')



        @slot('li_1')



            Home



        @endslot



        @slot('title')



           Leave



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">



            <div class="card">



                <div class="card-body">

                    <div class="row">

                        @if($users)
                        <div class="col-md-2">

                            <form action="" method="get">
                                <select class="form-control" name="user"  onchange="this.form.submit()" required>
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" @selected($request->user==$user->id)>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </form>
                            
                        </div>
                        @else
                        <div class="col-md-2"></div>
                        @endif

                        <div class="col-md-7">
                            
                        </div>

                        <div class="col-md-3 text-end">
                            @can('Leave.Create')
                            <a href="{{url('leave/application')}}" class="btn btn-primary rounded-pill btn-sm"><strong>+ Leave Application</strong></a>
                            @endcan
                            
                        </div>
                    </div>


                    <div class="row mt-2"> 

                        <div class="table-responsive">

                            <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100" id="Leavetable">

                                <thead class="table-light">

                                    <tr>

                                        <th >SL</th>

                                        <th>Employee Name</th>

                                        <th>Leave Type</th>

                                        <th>Application Start Date</th>

                                        <th>Application End Date</th>

                                        <th>Apply Day</th>

                                        <th>Approve Start Date</th>

                                        <th>Approved End Date</th>

                                        <th>Approved Day</th>

                                    </tr>

                                </thead>


                                <tbody> 

                                    @if(!empty($leaves))

                                    @foreach($leaves as $key => $value)

                                        <tr>

                                            <td>{{++$key}}</td>

                                            <td>{{$value->userName->name}}</td>

                                            <td>{{$value->LeaveType->leave_name}}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->application_start_date)->format('d/m/Y') }}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->application_end_date)->format('d/ m/Y') }}</td>

                                            <td>{{$value->apply_day}} Days</td>

                                            <td>{{$value->approve_start_date}}</td>

                                            <td>{{$value->approve_end_date}}</td>

                                            <td>{{$value->approve_day}}</td>

                                        </tr>

                                    @endforeach

                                    @endif

                                    
                                </tbody>


                                <tfoot>

                                    <tr>

                                        <th >SL</th>

                                        <th>Employee Name</th>

                                        <th>Leave Type</th>

                                        <th>Application Start Date</th>

                                        <th>Application End Date</th>

                                        <th>Approve Start Date</th>

                                        <th>Approved End Date</th>

                                        <th>Apply Day</th>

                                        <th>Approved Day</th>

                                    </tr>
                                    
                                </tfoot>



                            </table> <!-- end table -->


                        </div><!-- end table responsive -->

                        
                        
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

    
    <!-- Buttons JavaScript -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.flash.min.js"></script>


    <script>

        $(document).ready(function() {
            $('#Leavetable').DataTable({

                dom: 'lBfrtip',
                buttons: ['csv']

            });
        });

    </script>



@endsection



