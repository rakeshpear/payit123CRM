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



            Leave



        @endslot



        @slot('title')



           Leave Application Form



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">

            <div class="row mb-2">

                <div class="col-sm-10">
                    
                </div>

                <div class="col-sm-2 text-end">

                    <a href="{{url('/employee/leaves')}}" class="btn btn-primary rounded-pill btn-sm"> Back</a>
                    
                </div>
                
            </div>



            <div class="card">


                <form id="myForm" action="{{url('leave/store')}}" method="post" enctype="multipart/form-data">

                @csrf
                    
                    <div class="card-body mt-3">

                        <div class="form-group row mt-2">

                            <label for="emp_name" class="col-sm-2 col-form-label"><strong>Employee Name<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-4">

                                <input type="text" name="emp_name" value="{{Auth::user()->name}}" class="form-control" readonly>
                                <input type="hidden" name="employee_id" value="{{Auth::user()->id}}">
                                
                            </div>

                            <label for="leave_type" class="col-sm-2 col-form-label"><strong>Leave Type<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-4">

                                <select name="leave_type" class="form-control myselect" required>

                                    <option value="">Leave Type</option>
                                    @foreach($leaveType as $leave)
                                        <option value="{{$leave->id}}"> {{$leave->leave_name}} </option>
                                    @endforeach
                                </select>
                                
                            </div>
                            
                        </div>

                        <div class="form-group row mt-2">

                            <label for="application_start_date" class="col-sm-2 col-form-label"><strong>Application Start Date<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-4">

                                <input type="date" name="application_start_date" value="" id="sdate"  class="form-control" required>
                                
                            </div>

                            <label for="application_end_date" class="col-sm-2 col-form-label"><strong>Application End Date<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-4">

                                <input type="date" name="application_end_date"  onchange="calculateDayDifference()" value="" id="edate" class="form-control" required>
                                
                            </div>
                            
                        </div>

                        <div class="form-group row mt-2">

                            <label for="apply_day" class="col-sm-2 col-form-label"><strong>Apply Day<span class="text-danger"></span></strong></label>
                            <div class="col-sm-4">

                                <input type="text" name="apply_day" value="" placeholder="Apply Day" class="form-control" id="applyday" readonly>
                                
                            </div>

                            <!-- <label for="application_hardcopy" class="col-sm-2 col-form-label"><strong>Application Hardcopy <span class="text-danger"></span></strong></label>
                            <div class="col-sm-4">

                                <input type="file" name="application_hardcopy" class="form-control">
                                
                            </div> -->
                            
                        </div>

                       <!--  <div class="form-group row mt-2">

                            <label for="approve_start_date" class="col-sm-2 col-form-label"><strong>Approve Start Date<span class="text-danger"></span></strong></label>
                            <div class="col-sm-4">

                                <input type="date" name="approve_start_date" value="" class="form-control" >
                                
                            </div>

                            <label for="approve_end_date" class="col-sm-2 col-form-label"><strong>Approve End Date<span class="text-danger"></span></strong></label>
                            <div class="col-sm-4">

                                <input type="date" name="approve_end_date" value="" class="form-control" >
                                
                            </div>
                            
                        </div> -->

                       <!--  <div class="form-group row mt-2">

                            <label for="approve_day" class="col-sm-2 col-form-label"><strong>Approve Day<span class="text-danger"></span></strong></label>
                            <div class="col-sm-4">

                                <input type="text" name="approve_day" placeholder="Approve Day" value="" class="form-control" readonly>
                                
                            </div>

                            <label for="approve_by" class="col-sm-2 col-form-label"><strong>Approve By<span class="text-danger"></span></strong></label>
                            <div class="col-sm-4">

                                <select name="approve_by" class="form-control myselect" >

                                    <option value="">Select</option>
                                   
                                </select>
                                
                            </div>
                            
                        </div> -->

                        <div class="form-group row mt-2">

                            <label for="reason" class="col-sm-2 col-form-label"><strong>Reason:<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-10">

                                <textarea type="text" name="reason" value="" placeholder="Reason" class="form-control" ></textarea>
                                
                            </div>

                           
                        </div>

                        <div class="form-group row mt-4 text-end">

                            <div class="col-sm-8">
                                
                            </div>

                             <div class="col-sm-4">

                                <button type="button" onclick="resetForm()" class="btn btn-primary">Reset</button>

                                <button type="submit" class="btn btn-success ">Submit</button>
  
                            </div>
                            
                        </div>
            
                       

                    </div>

                </form>



            </div>


        </div>


    </div>



@endsection



@section('script')

    <script>

        function resetForm() 
        {
            document.getElementById("myForm").reset();
        }

    </script>

    <script type="text/javascript">
        
        function calculateDayDifference() 
        {
            var startDate = document.getElementById('sdate').value;
            var endDate = document.getElementById('edate').value;



            // Convert the date strings to Date objects
            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);

            // Calculate the difference in milliseconds
            var differenceMs = endDateObj - startDateObj;

            // Convert the difference to days
            var differenceDays = differenceMs / (1000 * 60 * 60 * 24);

            document.getElementById('applyday').value= differenceDays+1;
        }

    </script>

    <!-- select2 js -->

    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <script type="text/javascript">
            
        $(document).ready(function() {
            $('.myselect').select2();
        });

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



