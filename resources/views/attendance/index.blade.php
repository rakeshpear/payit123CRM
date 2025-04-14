@extends('layouts.master')

@section('title')



    @lang('Attendance')



@endsection



@section('css')



    <!-- select2 css -->



    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- DataTables -->



    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



@endsection



@section('content')



    @component('components.breadcrumb')



        @slot('li_1')



            Home



        @endslot



        @slot('title')



           Attendance



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">



            <div class="card">



                <div class="card-body">



                    <div class="row mb-2">

                        <div class="col-sm-9">

                        </div><!-- end col-->

                        <div class="col-sm-3">



                            <div class="search-box me-2 mb-2 d-inline-block">



                                <div class="position-relative">



                                    <input type="text" class="form-control" id="searchTableList" placeholder="Search...">



                                    <i class="bx bx-search-alt search-icon"></i>



                                </div>



                            </div>



                        </div>


                    </div><!-- end row -->


                    <div class="card mt-2">

                        <ul class="nav nav-tabs" id="myTabs">

                            <li class="nav-item">
                                <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1"><button class="btn btn-success">Check In</button></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2"><button class="btn btn-success">Check Out</button></a>
                            </li>
                            
                        </ul>


                        <div class="tab-content mt-2">

                            <div class="tab-pane fade show active" id="tab1">

                                <form action="{{route('attendance.in.time')}}" method="post" enctype="multipart/form-data">

                                @csrf    

                                    <div class="">

                                        <div class="form-group row mb-2">

                                            <label for="employee_name" class="col-sm-4 col-form-label">Employee Name<span class="text-danger">*</span></label>
                                                
                                            <div class="col-sm-4">

                                                <input type="text" class="form-control" name="employee_name" value="{{Auth::user()->name}}" readonly>
                                                <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">

                                            </div>
                                            

                                        </div>

                                        <div class="form-group row mb-2">

                                            <label for="punch_in_time" class="col-sm-4 col-form-label">Punch Time<span class="text-danger">*</span></label>

                                    
                                            <div class="col-sm-4">

                                                <input type="datetime-local" class="form-control" name="punch_in_time" required>

                                            </div>

                                            <div class="col-sm-2"></div>

                                            <div class="col-sm-2">

                                                <button type="submit" class="btn btn-primary btn-soft ">Check In</button>
                 
                                            </div>


                                        </div>    
                                         
                                    </div>

                                </form>

                            </div>

                            <div class="tab-pane fade" id="tab2">

                                <form action="{{route('attendance.out.time')}}" method="post" enctype="multipart/form-data">

                                @csrf 

                                    <div class="">

                                        <div class="form-group row mb-2">

                                            <label for="employee_name" class="col-sm-4 col-form-label">Employee Name<span class="text-danger">*</span></label>
                                                
                                            <div class="col-sm-4">

                                                <input type="text" class="form-control" name="employee_name" value="{{Auth::user()->name}}" readonly>
                                                <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">

                                            </div>
                                            

                                        </div>

                                        <div class="form-group row mb-2">

                                            <label for="punch_out_time" class="col-sm-4 col-form-label">Punch Time<span class="text-danger">*</span></label>

                                    
                                            <div class="col-sm-4">

                                                <input type="datetime-local" class="form-control" name="punch_out_time" required>

                                            </div>

                                            <div class="col-sm-2"></div>

                                            <div class="col-sm-2">

                                                <button type="submit" class="btn btn-primary btn-soft ">Check Out</button>
                 
                                            </div>


                                        </div>    
                                         
                                    </div>

                                </form>

                            </div>

                        </div>         

                    </div><!-- end row -->

                    <hr>
                    <br>


                

                    <div class="row mt-2"> 

                        <div class="table-responsive">

                            <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100" id="userList-table">

                                <thead class="table-light">

                                    <tr>

                                        <th >SL</th>

                                        <th>Employee Name</th>

                                        <th>In Time</th>

                                        <th>Date</th>

                                        <th>Last In Time</th>

                                        <th>Last Out Time</th>

                                        <th>Worked Hours</th>

                                       

                                    </tr>

                                </thead>


                                <tbody> 

                                    @if(!empty($attendances))

                                    @foreach($attendances as $key => $value)

                                        <tr>

                                            <td>{{++$key}}</td>

                                            <td>{{$value->userName->name}}</td>

                                            <td>{{$value->time_in}}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('d-m-Y') }}</td>

                                            <td>{{$value->time_in}}</td>

                                            <td>{{$value->time_out}}</td>

                                            <td>{{$value->working_hours}}:{{$value->working_minutes}} Minutes</td>

                                           

                                        </tr>

                                    @endforeach

                                    @endif

                                    
                                </tbody>


                                <tfoot>

                                    <tr>

                                        <th >SL</th>

                                        <th>Employee Name</th>

                                        <th>In Time</th>

                                        <th>Date</th>

                                        <th>Last In Time</th>

                                        <th>Last Out Time</th>

                                        <th>Worked Hours</th>

                                      

                                    </tr>
                                    
                                </tfoot>



                            </table> <!-- end table -->


                        </div><!-- end table responsive -->

                        {{ $attendances->links() }}
                        
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



@endsection



