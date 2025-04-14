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



          Monthly Attendance



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">



            <div class="card">

                <div class="card-body">


                    <div class="row mt-2">

                        <form action="" method="" >

                        @csrf

                            <div class="">

                                <div class="form-group row mb-2">

                                    <label for="employee_name" class="col-sm-4 col-form-label"><strong>Employee Name<span class="text-danger">*</span></strong></label>
                                    @if($users) 

                                        <div class="col-sm-4">

                                            <select class="form-control" name="employee_id" required>

                                                <option value="">Select Employee</option>
                                                @foreach($users as $user)

                                                    @if($user->id==$request->employee_id)

                                                        <option value="{{$user->id}}" selected>{{$user->name}}</option>

                                                    @else

                                                        <option value="{{$user->id}}" >{{$user->name}}</option>

                                                    @endif

                                                @endforeach
                                    
                                            </select>
                                            
                                        </div>  
                                        
                                    @else

                                        <div class="col-sm-4">

                                            <input type="text" class="form-control" name="employee_name" value="{{Auth::user()->name}}" readonly>
                                            <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">

                                        </div>
                                        
                                    @endif

                                </div>

                                <div class="form-group row mb-2">

                                    <label for="year" class="col-sm-4 col-form-label"><strong>Year<span class="text-danger">*</span></strong></label>
                                        
                                    <div class="col-sm-4">

                                        <select class="form-control myselect" name="year" required>
                                            <option value="">Select Year</option>
                                            <option value="2019" @selected('2019'==$request->year)>2019</option>
                                            <option value="2020" @selected('2020'==$request->year)>2020</option>
                                            <option value="2021" @selected('2021'==$request->year)>2021</option>
                                            <option value="2022" @selected('2022'==$request->year)>2022</option>
                                            <option value="2023" @selected('2023'==$request->year)>2023</option>
                                            <option value="2024" @selected('2024'==$request->year)>2024</option>
                                            <option value="2025" @selected('2025'==$request->year)>2025</option>
                                            <option value="2026" @selected('2026'==$request->year)>2026</option>
                                            <option value="2027" @selected('2027'==$request->year)>2027</option>
                                            <option value="2028" @selected('2028'==$request->year)>2028</option>
                                            <option value="2029" @selected('2029'==$request->year)>2029</option>
                                            <option value="2030" @selected('2030'==$request->year)>2030</option>
                                        </select>

                                    </div>

                                </div>

                                <div class="form-group row mb-2">

                                    <label for="month" class="col-sm-4 col-form-label"><strong>Month<span class="text-danger">*</span></strong></label>
                                        
                                    <div class="col-sm-4">

                                        <select class="form-control myselect" name="month" required>
                                            <option value="">Select Month</option>
                                            <option value="01" @selected('01'==$request->month)>January</option>
                                            <option value="02" @selected('02'==$request->month)>February</option>
                                            <option value="03" @selected('03'==$request->month)>March</option>
                                            <option value="04" @selected('04'==$request->month)>April</option>
                                            <option value="05" @selected('05'==$request->month)>May</option>
                                            <option value="06" @selected('06'==$request->month)>June</option>
                                            <option value="07" @selected('07'==$request->month)>July</option>
                                            <option value="08" @selected('08'==$request->month)>August</option>
                                            <option value="09" @selected('09'==$request->month)>September</option>
                                            <option value="10" @selected('10'==$request->month)>October</option>
                                            <option value="11" @selected('11'==$request->month)>November</option>
                                            <option value="12" @selected('12'==$request->month)>December</option>

                                        </select>

                                    </div>

                                </div>

                                <!-- <div class="form-group row mb-2">

                                    <label for="in_time" class="col-sm-4 col-form-label"><strong>In Time<span class="text-danger">*</span></strong></label>
                                        
                                    <div class="col-sm-4">

                                        <select class="form-control myselect" name="in_time" required>

                                            <option value="">--:--</option>

                                            <?php
                                                for ($hour = 0; $hour <= 23; $hour++) {
                                                    for ($minute = 0; $minute <= 59; $minute += 5) {
                                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                                        echo "<option value=\"$time\">$time</option>";
                                                    }
                                                }
                                            ?>
                                            
                                        </select>

                                    </div>

                                </div> -->


                                <!-- <div class="form-group row mb-2">

                                    <label for="out_time" class="col-sm-4 col-form-label"><strong>Out Time<span class="text-danger">*</span></strong></label>
                                        
                                    <div class="col-sm-4">

                                        <select class="form-control myselect" name="out_time" required>

                                           
                                            <option value="">--:--</option>

                                            
                                            <?php
                                                for ($hour = 0; $hour <= 23; $hour++) {
                                                    for ($minute = 0; $minute <= 59; $minute += 5) {
                                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                                        echo "<option value=\"$time\">$time</option>";
                                                    }
                                                }
                                            ?>
                                            
                                       
                                            
                                        </select>

                                    </div>

                                </div> -->

                                <div class="form-group row mb-2">

                                   
                                    <div class="col-sm-7">

                                        

                                    </div>

                                    <div class="col-sm-2">

                                        <button type="submit" class="btn btn-success ">Details</button>
                                        
                                    </div>

                                </div>   
                                 
                            </div>

                        </form>
                    </div><!-- end row -->

                 
                </div>

            </div>

            @if($attendances)
                <!-- Table Card Start -->
                <div class="card">

                    <div class="card-body">

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

                                        @if ($attendances->count() == 0)

                                            <tr class="text-center">

                                                <td colspan="6">No Attendance to display.</td>

                                            </tr>

                                        @endif

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
            @endif


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



@endsection



