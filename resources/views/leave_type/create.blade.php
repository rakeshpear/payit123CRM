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



            Leave Type



        @endslot



        @slot('title')



           Leave Type Form



        @endslot



    @endcomponent



    <div class="row">



        <div class="col-lg-12">

            <div class="row mb-2">

                <div class="col-sm-10">
                    
                </div>

                <div class="col-sm-2 text-end">

                    <a href="{{url('leave_types/index/')}}" class="btn btn-primary rounded-pill btn-sm"> Back</a>
                    
                </div>
                
            </div>



            <div class="card">


                <form id="myForm" action="{{url('leave_type/store/')}}" method="post" enctype="multipart/form-data">

                @csrf
                    
                    <div class="card-body mt-3">

                        <div class="form-group row mt-2">

                            <label for="leave_name" class="col-sm-2 col-form-label"><strong>Leave Type Name<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-4">

                                <input type="text" name="leave_name" placeholder="Enter Leave Type" class="form-control" required>

                                @error('leave_name')

                                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>

                                @enderror
                                
                            </div>

                            <label for="no_of_days" class="col-sm-2 col-form-label"><strong>No Of Days<span class="text-danger">*</span></strong></label>
                            <div class="col-sm-4">

                                <input type="text" name="no_of_days" placeholder="Enter Days" class="form-control" required>

                                @error('no_of_days')

                                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>

                                @enderror
                                
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



