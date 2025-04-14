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

           User More Details

        @endslot

        @slot('title')

            User More Details

        @endslot

    @endcomponent

    <section>

        <div class="col-sm-12 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

               <a href="{{url('users')}}">

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

                                    <h5 class="text-primary">Welcome Back !<h5>

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

                                <p><strong>Phone:&nbsp;&nbsp;</strong>{{ $users->phone }}</p>
                                <p><strong>Email:&nbsp;&nbsp;</strong>{{ $users->email }}</p>
                               
                                <p><strong>Role:&nbsp;&nbsp;</strong>{{ $users->Role->name }}</p>
                                <p><strong>Status:&nbsp;&nbsp;</strong>{{ $users->status == 1 ? 'Active' : 'Inactive' }}</p> 

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-8">

                <div class="row">

                    <!-- <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Projects</p>

                                        <h4 class="mb-0">1,235</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class="bx bx-copy-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> -->

                    <!-- <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Average Price</p>

                                        <h4 class="mb-0">$16.2</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> -->

                    

                    <!-- <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Reports</p>

                                        <h4 class="mb-0">$16.2</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> -->

                </div>

                <div class="row">

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Working Hours</p>

                                        <h4 class="mb-0">{{$totalhours}}</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center">

                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">

                                            <span class="avatar-title">

                                                <i class='bi bi-alarm-fill font-size-24'></i>

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

                                        <h4 class="mb-0"></h4>

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

                    <div class="col-md-4">

                        <div class="card mini-stats-wid">

                            <div class="card-body">

                                <div class="d-flex">

                                    <div class="flex-grow-1">

                                        <p class="text-muted fw-medium">Tasks</p>

                                        <h4 class="mb-0">{{$tasks->count()}}</h4>

                                    </div>



                                    <div class="flex-shrink-0 align-self-center ">

                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">

                                            <span class="avatar-title rounded-circle bg-primary">

                                                <i class="bx bx-copy-alt font-size-24"></i>

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
            <button class="tablinks active" onclick="openCity(event, 'London')">Project Tasks</button>
            <button class="tablinks" onclick="openCity(event, 'Paris')">Time</button>
        </div>

    <div id="London" class="tabcontent Active active">
        <h5>Tasks</h5>
         <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="">
                <thead class="table-light">
                     <tr>
                        <th scope="col">S.no</th>
                        <th scope="col">Name</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Action</th>
                      </tr>
                </thead>

                <tbody>
                    @if(!empty($tasks))
                        @foreach($tasks as $key=>$value)
                            <tr>

                                <td>{{ ++$key }}</td>

                                <td>{{$value->title}}</td>

                                <td>{{ \Carbon\Carbon::parse($value->start_date)->format('d M Y') }}</td>

                                <td class="{{ $value->mark_done == 1 ? 'text-success' : 'text-danger' }}">
                                {{ $value->mark_done == 1 ? 'completed' : 'pending' }}
                                </td>

                                <td class="text-end">

                                    <button type="button" class="btn btn-sm btn-soft-info" data-toggle="modal" data-target="#AddHoursModal{{$key}}"><i class='bi bi-alarm-fill'></i> Add Hours</button>

                                    <button type="button" class="btn btn-sm btn-soft-info" data-toggle="modal" data-target="#ViewHoursModal{{$key}}"><i class="bi bi-eye-fill"></i>View Hours</button>

                                    <button type="button" class="btn btn-sm btn-soft-info" data-toggle="modal" data-target="#ShowCommentsModal{{$key}}"><i class="bi bi-chat-dots-fill"></i> Comments</button>

                                   
                                
                                </td>


                                <!-- Show Comments modal start -->

                                <div class="modal fade " id="ShowCommentsModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="ShowCommentsModallabel" aria-hidden="true" style="height:500px;">
                                  <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="ShowCommentsModallabel">Tasks Comments </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                     
                                          <div class="modal-body">
                                            
                                                @if($value->TaskComment!=null)
                                                @foreach($value->TaskComment as $comment)
                                                <div class="row" style="background-color:#e8eaed; margin:1px;">

                                                <div class="col-md-3 mt-1">
                                                    <p>{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y') }}</p>
                                                </div>

                                                <div class="col-md-9 mt-1">    

                                                    <p>{{$comment->comments}}</p>
                                                    
                                                </div>

                                                </div>
                                                @endforeach 
                                                @endif  
                                                @if($value->TaskComment->count()==0)
                                                  <div class="text-center">No Cooments Found!</div>
                                                @endif
                                             
                                          </div>

                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                           <!-- <button type="submit" class="btn btn-info">Submit</button> -->
                                          </div> 
                                    </div>
                                  </div>
                                </div>

                                <!-- close Show Comments Modal -->


                                <!-- ADD HOURS MODAL -->
                                <div class="modal fade AddHoursMdl" id="AddHoursModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="AddHoursModallabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="AddHoursModallabel">Add Working Task Hours</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form id="hoursForm" action="{{route('SaveTaskWorkingHours')}}" method="post">
                                        @csrf
                                          <div class="modal-body">
                                            <div class="row">                                        
                                                <label class="col-md-2 form-group">Hours<span class="text-danger">*</span></label>  

                                                <div class="col-md-8">

                                                    <input type="hidden" name="task_id" value="{{ $value->id }}">
                                                    

                                                    <select class="form-control" name="hours" required>

                                                        <option value="">Working Hours</option>
                                                        <?php
                                                            for ($hour = 0; $hour <= 23; $hour++) {
                                                                for ($minute = 0; $minute <= 59; $minute += 30) {
                                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                                    echo "<option value=\"$time\">$time</option>";
                                                                }
                                                            }
                                                        ?>

                                                    </select>

                                                </div> 
                                            </div> 
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info">Submit</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- CLOSE ADD HOURS MODAL -->

                                <!-- view HOURS MODAL -->
                                <div class="modal fade" id="ViewHoursModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="ViewHoursModallabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="ViewHoursModallabel">Total Working Task Hours&nbsp;
                                        @if($value->TaskHours!=null) 
                                            <strong>{{$value->taskhours}} Minutes, {{ $value->taskcost }}({{$value->currency}})</strong>  
                                        @endif    
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                     
                                      <div class="modal-body">
                                         
                                            @if($value->TaskHours!=null)
                                                @foreach($value->TaskHours as $taskhour)
                                                <div class="row" style="background-color:#e8eaed; margin:1px;">
                                                    
                                                    <div class="col-md-3 mt-1">
                                                        <p>{{ \Carbon\Carbon::parse($taskhour->created_at)->format('d M Y') }}</p>
                                                    </div>
                                                    <div class="col-md-9 mt-1">
                                                        <p>{{$taskhour->hours}} Hours</p>
                                                    </div>

                                                </div>
                                                @endforeach
                                            @endif

                                            @if($value->TaskHours->count()==0)
                                            <div class="text-center">No Hours!</div>
                                            @endif
                                        
                                      
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <!-- <button type="submit" class="btn btn-info">Submit</button> -->
                                      </div>
                                      
                                    </div>
                                  </div>
                                </div>
                                <!-- CLOSE view HOURS MODAL -->
                                
                            </tr>
                         
                        @endforeach

                        @if ($tasks->count() == 0)
                            <tr class="text-center">
                                <td colspan="6">No Tasks to display.</td>
                            </tr>

                        @endif

                    @endif
                </tbody>
        </table>
    </div>

    <div id="Paris" class="tabcontent">
        <h5>Times</h5>

        <div class="table-responsive">

            <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">

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

