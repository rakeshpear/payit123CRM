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

        @include('multiselect') 

        <div class="col-lg-12">

            <div class="row">

                <div class="col-md-9">
                    
                </div>

                <div class="col-md-3 text-end mb-2">

                    <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill btn-sm"><i

                class="mdi mdi-arrow-left me-1"></i>Back To Profile</a>
                    
                </div>
                
            </div>



            <div class="card">

                <div class="card-body">

                    <form action="" method="get">

                        <div class="row "> 

                            <div class="col-sm-3">

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

                            <div class="col-sm-3">
    
                                <select class="form-control myselect" name="month" onchange="this.form.submit()" required>

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

                            </div><!-- end col-->

                            <div class="col-sm-3 pt-2">

                                <h6>Total Time: {{$t_hours}}: {{$t_minutes}} Minutes</h6>
                            
                            </div>

                            <div class="col-sm-3">

                                <!-- <div class="col-sm-3">

                                    <div class="search-box me-2 mb-2 d-inline-block">

                                        <div class="position-relative">

                                            <input type="text" class="form-control" id="searchTableList" placeholder="Search...">

                                            <i class="bx bx-search-alt search-icon"></i>

                                        </div>

                                    </div>

                                </div> -->
                            
                            </div>

                        </div>

                    </form> 


                    <div class="row mt-2"> 

                        <div class="table-responsive">

                            <table class="table align-middle table-nowrap  dt-responsive nowrap w-100" id="userList-table">

                                <thead class="table-light">

                                    <tr>

                                        <th >SL</th>

                                        <th>Date</th>

                                        <th>Day</th>

                                        <th>Time In</th>

                                        <th>Time Out</th>

                                        <th>Label</th>

                                    </tr>

                                </thead>


                                <tbody> 

                                    @if(!empty($attendances))

                                    @foreach($attendances as $key => $value)

                                    @if($value->label=='Holiday')

                                        <tr style="background-color: #abd5f7;">

                                            <td>{{++$key}}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('d/m/Y') }}</td>

                                            <td>{{$value->day}}</td>  

                                            <td>{{$value->time_in}}</td>     

                                            <td>{{$value->time_out}}</td>                                    

                                            <td>{{$value->label}}</td>                                           

                                        </tr>

                                    @elseif($value->label=='Attendance')

                                        <tr style="background-color: #c6fa8e;">

                                            <td>{{++$key}}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('d/m/Y') }}</td>

                                            <td>{{$value->day}}</td>  

                                            <td>{{$value->time_in}}</td>     

                                            <td>{{$value->time_out}}</td>                                    

                                            <td>{{$value->label}}</td>                                           

                                        </tr>

                                    @elseif($value->label=='Absent')

                                        <tr style="background-color: #fc8b83;">

                                            <td>{{++$key}}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('d/m/Y') }}</td>

                                            <td>{{$value->day}}</td>  

                                            <td>{{$value->time_in}}</td>     

                                            <td>{{$value->time_out}}</td>                                    

                                            <td>{{$value->label}}</td>                                           

                                        </tr>

                                    @else

                                        <tr style="background-color: #fcfa77;">

                                            <td>{{++$key}}</td>

                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('d/m/Y') }}</td>

                                            <td>{{$value->day}}</td>  

                                            <td>{{$value->time_in}}</td>     

                                            <td>{{$value->time_out}}</td>                                    

                                            <td>{{$value->label}}</td>                                           

                                        </tr>   

                                    @endif    

                                    @endforeach

                                    @endif

                                    
                                </tbody>


                                <tfoot>

                                    <tr>

                                        <th >SL</th>

                                        <th>Date</th>

                                        <th>Day</th>

                                        <th>Time In</th>

                                        <th>Time Out</th>

                                        <th>Label</th>

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



