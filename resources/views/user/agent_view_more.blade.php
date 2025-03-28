@extends('layouts.master')

@section('title')

    @lang('User')

@endsection

@section('css')

    <!-- select2 css -->

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- bootstrap-datepicker css -->

    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">



    <!-- DataTables -->

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Add Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@endsection

@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

           Agent More Details

        @endslot

        @slot('title')

            Agent More Details

        @endslot

    @endcomponent

    <section>

        <div class="col-sm-12 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

              <a href="{{url('/create_customer_from_agent/'.$users->id)}}" class="me-1">

               <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2">+ Add Merchant</button>

              </a>

               <a href="{{url('/agent/users')}}">

               <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                class="mdi mdi-arrow-left me-1"></i> Back</button>

              </a>

        </div>

        <div class="row">

            <div class="col-xl-4">

                <div class="card overflow-hidden">

                    <div class="bg-primary-subtle">

                        <div class="row">

                            <div class="col-7">

                                <div class="text-primary p-3">

                                    <h5 class="text-primary">Welcome Back !</h5>

                                    <p>PayIT</p>

                                </div>

                            </div>

                            <div class="col-5 align-self-end">

                                <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">

                            </div>

                        </div>

                    </div>

                    <div class="card-body pt-0">

                        <div class="row">

                            <div class="col-sm-12">

                                <div class="avatar-md profile-user-wid mb-2">

                                    <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('build/images/users/profile.png') }}" alt="" class="img-thumbnail rounded-circle">

                                </div>

                                <h4 class="font-size-20 mb-1 text-truncate">{{ $users->name }}</h4>

                                <p class="p-0 m-0"><strong>Phone:&nbsp;&nbsp;</strong>{{ $users->phone }}</p>
                                <p class="p-0 m-0"><strong>Email:&nbsp;&nbsp;</strong>{{ $users->email }}</p>
                               
                                <!-- <p class="p-0 m-0"><strong>Role:&nbsp;&nbsp;</strong>{{ $users->Role->name }}</p> -->
                                <p class="p-0 m-0"><strong>Status:&nbsp;&nbsp;</strong>{{ $users->status == 1 ? 'Active' : 'Inactive' }}</p> 

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-8">

                <div class="row">

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Merchant Commission(10%)</p>

                                        <h4 class="mb-0">${{1194*10/100}}</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class='bi bi-cash-coin font-size-24'></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Agent Commission(1%)</p>

                                        <h4 class="mb-0">${{1194*1/100}}</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center ">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bi bi-cash-coin  font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>    

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Revenue</p>

                                        <h4 class="mb-0">{{$revenue}}</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center ">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-archive-in font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>                

                </div>

                <div class="row">

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium"><a href="{{url('/customer/index/'.$users->id)}}" class="text-muted">View Merchants</a></p>

                                        <h4 class="mb-0">{{$agent_client}}</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class="bx bx-user font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="tab">
            <!-- <button class="tablinks active" onclick="openCity(event, 'London')">Project Tasks</button> -->
            <button class="tablinks active" onclick="openCity(event, 'Paris')">Time</button>
            <button class="tablinks" onclick="openCity(event, 'USA')">Customer Payments</button>

        </div>

   

        <div id="Paris" class="tabcontent Active active">
            <h5>Times</h5>

            <div class="table-responsive">

                <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100 display" id="example">

                    <thead class="table-light">

                        <tr>

                            <th scope="col">#</th>

                            <th scope="col">Name</th>

                            <th scope="col">Date</th>

                            <th scope="col">Time In</th>

                            <th scope="col">Time Out</th>

                            <th scope="col">Total Hours</th>

                        </tr>

                    </thead>

                    <tbody>

                            @if(!empty($timers))

                            @foreach($timers as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>
       
                                    <td>{{ $value->User->name }}</td>

                                    <td>{{ \Carbon\Carbon::parse($value->date)->format('j M Y') }}</td>

                                    <td>
                                        @if ($value->start_time)
                                        {{\Carbon\Carbon::parse($value->start_time)->format('H:i:s')
                                                }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($value->end_time)
                                        {{ \Carbon\Carbon::parse($value->end_time)->format('H:i:s') }}
                                            @endif
                                    </td>

                                    <td>
                                    {{ floor($value->total_hours / 60) }} hrs {{ $value->total_hours % 60 }} min
                                    </td>

                                </tr>

                            @endforeach

                            @if ($timers->count() == 0)

                                        <tr class="text-center">

                                            <td colspan="6">No Timer to display.</td>

                                        </tr>

                            @endif

                            @endif

                    </tbody>

                </table><!-- end table -->

            </div>

        </div><!-- end row -->

        <div id="USA" class="tabcontent">
            <h5>Customer</h5>

            <div class="table-responsive">

                <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">

                    <thead class="table-light">

                        <tr>

                            <th scope="col">#</th>

                            <th scope="col">Name</th>

                            <th scope="col">Amount</th>

                            <th scope="col">Convert Amount</th>

                            <th scope="col">Date</th>


                        </tr>

                    </thead>

                    <tbody>

                            @if(!empty($customer_payments))

                            @foreach($customer_payments as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>
       
                                    <td>{{ $value->Customer->name }}</td>

                                    <td>{{$value->amount}}</td>

                                    <td>{{$value->convert_amount}}</td>

                                    <td>{{ \Carbon\Carbon::parse($value->date)->format('j M Y') }}</td>

                                </tr>

                            @endforeach

                            @if (count($customer_payments) > 0)

                                        <tr class="text-center">

                                            <td colspan="6">No Payments to display.</td>

                                        </tr>

                            @endif

                            @endif

                    </tbody>

                </table><!-- end table -->

            </div>
        </div><!-- end row -->

    </section>

@endsection



<script type="text/javascript">
   
  
        $('#hoursForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(), // Serialize the form data
                success: function (response) {
                
                     $(".AddHoursMdl").hide();

                    // Handle the success response (e.g., display a success message)
                }
            });
        });
   

</script>

<script>
        function openCity(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }
</script>

<script type="text/javascript">
    
    function setActiveTabByDefault() {
    var defaultTab = document.querySelector('.tablinks.active');
    var defaultContent = document.querySelector('.tabcontent.active');
    
    if (defaultTab && defaultContent) {
        defaultTab.className += '';
        defaultContent.style.display = 'block';
    }
}

window.addEventListener('load', setActiveTabByDefault);
</script>

@section('script')

<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script>
        jQuery(document).ready(function(){
            new DataTable('#example');
        });
    </script>

    <!-- select2 -->

    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <!-- bootstrap-datepicker js -->

    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Required datatable js -->

    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->

    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- init js -->

    <script src="{{ URL::asset('build/js/pages/crypto-orders.init.js') }}"></script>

@endsection

