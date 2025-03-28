@extends('layouts.master')

@section('title')

@lang('Projects')

@endsection

@section('css')

<!-- select2 css -->

<link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->

<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->

<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



@endsection

@section('content')

@component('components.breadcrumb')

@slot('li_1')

Project Task Lists

@endslot

@slot('title')

Project Task Lists

@endslot

@endcomponent

<div class="row">

    @include('flash_msg')

    <div class="col-lg-6">

        <div class="card">

            <div class="card-body">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <div class="search-box me-2 mb-2 d-inline-block">

                            <div class="position-relative">

                                Project Task Lists

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6">

                        <div class="text-sm-end">

                            <a href="{{url('projects')}}">

                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i class="mdi mdi-arrow-left me-1"></i> Back</button>

                            </a>

                        </div>

                    </div><!-- end col-->

                </div>

                <!-- end row -->

                <div class="table-responsive">

                    <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="">

                        <thead class="table-light">

                            <tr>

                                <th scope="col">Project Title</th>

                                <th scope="col">Deadline</th>

                                <th scope="col">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @if($project->mark_done==1)

                            <tr>

                                <td style="background-color: #cbe9dd;">{{$project->name}}</td>

                                <td style="background-color: #cbe9dd;">{{ \Carbon\Carbon::parse($project->deadline)->format('d M') }}</td>

                                <td style="background-color: #cbe9dd;">
                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li>
                                            <div class="dropdown dropend">
                                                <a id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><i class="mdi mdi-dots-vertical"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-bs-auto-end="true">
                                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#addTask-{{ $project->id }}">Add Sub-task</a></li>

                                                    <li><a class="dropdown-item edit-project" onclick="editForm({{ $project->id }})">View/Edit</a></li>

                                                    <li>
                                                        <?php if ($project->mark_done == 1) : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeundoneTask-{{ $project->id }}">Mark as incomplete</a>
                                                        <?php else : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeTask-{{ $project->id }}">Mark as Done</a>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#removeItemModal">Delete</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>

                                </td>

                            </tr>

                            @else

                            <tr>

                                <td>{{$project->name}}</td>

                                <td>{{ \Carbon\Carbon::parse($project->deadline)->format('d M') }}</td>

                                <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li>
                                            <div class="dropdown dropend">
                                                <a id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><i class="mdi mdi-dots-vertical"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-bs-auto-end="true">
                                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#addTask-{{ $project->id }}">Add Sub-task</a></li>

                                                    <li><a class="dropdown-item edit-project" onclick="editForm({{ $project->id }})">View/Edit</a></li>


                                                    <li>
                                                        <?php if ($project->mark_done == 1) : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeundoneTask-{{ $project->id }}">Mark as incomplete</a>
                                                        <?php else : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeTask-{{ $project->id }}">Mark as Done</a>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#removeItemModal">Delete</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>

                                </td>

                            </tr>

                            @endif

                            <!-- make done in project -->

                            <div class="modal" id="makeTask-{{$project->id}}" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered modal-sm">

                                    <div class="modal-content">

                                        <div class="modal-body px-4 py-5 text-center">

                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <form action="{{ route('projects.task.done', ['id' => $project->id]) }}" method="post">
                                                {{ csrf_field() }}

                                                <p class="text-muted font-size-16 mb-4">Are you Sure You Want to Mark it as Complete?</p>

                                                <div class="hstack gap-2 justify-content-center mb-0">

                                                    <button type="submit" class="btn btn-danger" id="remove-item">Submit</button>

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- end removeItemModal -->


                            <!-- make undone in project -->

                            <div class="modal" id="makeundoneTask-{{$project->id}}" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered modal-sm">

                                    <div class="modal-content">

                                        <div class="modal-body px-4 py-5 text-center">

                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <form action="{{ route('projects.task.undone', ['id' => $project->id]) }}" method="post">
                                                {{ csrf_field() }}

                                                <p class="text-muted font-size-16 mb-4">Are you Sure You Want to Mark it as incomplete?</p>

                                                <div class="hstack gap-2 justify-content-center mb-0">

                                                    <button type="submit" class="btn btn-danger" id="remove-item">Submit</button>

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- end removeItemModal -->

                            <!-- Modal ADD Task -->
                            <div class="modal fade" id="addTask-{{$project->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header btns primary-btn">
                                            <h5 class="modal-title" id="editModalLabel">Add Task</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('projects.task.store', ['id' => $project->id]) }}" method="post">
                                            {{ csrf_field() }}

                                            <div class="modal-body">
                                                <div class="row">

                                                    <div class="form-group col-lg-12 mt-2">
                                                        <label>Task Title<span class="text-danger"></span></label>
                                                        <input type="text" class="form-control" name="title" value="" placeholder="Task Title" required />
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                        <label>Start Date <span class="text-danger"></span></label>
                                                        <input type="date" class="form-control" name="start_date" value="" placeholder="Select Date" />
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                        <label for="designation-input" class="form-label">End Date</label>
                                                        <input type="date" class="form-control" placeholder="" name="end_date" />
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                        <label>Assign To <span class="text-danger"></span></label>
                                                        <select class="form-control" name="assign_too"> <!-- Make sure the name attribute is "assign_to" -->
                                                            <option value="">Select</option> 
                                                            @foreach(json_decode($project->team_ids) as $id)
                                                                @php
                                                                    $user = \App\Models\User::find($id); 
                                                                @endphp
                                                                <option value="{{ $id }}">{{ $user ? $user->name : 'Unknown User' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                    <label>Developer Cost<span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="cost" value="" placeholder="Developer Cost" required />
                                                </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="modal" id="removeItemModal" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered modal-sm">

                                    <div class="modal-content">

                                        <div class="modal-body px-4 py-5 text-center">

                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <div class="avatar-sm mb-4 mx-auto">

                                                <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">

                                                    <i class="mdi mdi-trash-can-outline"></i>

                                                </div>

                                            </div>

                                            <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this Project ?</p>

                                            <div class="hstack gap-2 justify-content-center mb-0">

                                                <a href="{{ route('projects.delete', encrypt($project->id)) }}"><button type="button" class="btn btn-danger" id="remove-item">Remove Now</button></a>

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </tbody>

                    </table>

                </div>

                <div class="table-responsive mt-4">

                    <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="">

                        <div class="mb-3">
                            <h5>Tasks</h5>
                        </div>

                        <!-- <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Task Title</th>

                                    <th scope="col">Assign To</th>

                                    <th scope="col">Start Date</th>

                                    <th scope="col">End Date</th>

                                    <th scope="col">Action</th>

                                </tr>

                            </thead> -->


                        <tbody>

                            @if(!empty($tasks))

                            @foreach($tasks as $key=>$value)

                            @if($value->mark_done==1)

                            <tr>

                                <td style="background-color: #cbe9dd;">{{ ++$key }}</td>

                                <td style="background-color: #cbe9dd;">{{$value->title}}</td>

                                <td style="background-color: #cbe9dd;">{{ \Carbon\Carbon::parse($value->start_date)->format('d M') }}</td>

                                <td style="background-color: #cbe9dd;">{{ \Carbon\Carbon::parse($value->end_date)->format('d M') }}</td>


                                <td style="background-color: #cbe9dd;">

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li>
                                            <div class="dropdown dropend">
                                                <a id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><i class="mdi mdi-dots-vertical"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-bs-auto-end="true">


                                                    <li>
                                                        <?php if ($value->mark_done == 1) : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeundoneTask-{{ $value->id }}">Mark as incomplete?</a>
                                                        <?php else : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeTask-{{ $value->id }}">Mark as Done</a>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#editTask-{{ $value->id }}">View/Edit</a></li>


                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#removeItemModal-{{ $value->id }}">Delete</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                    </ul>
                                </td>

                            </tr>
                            @else

                            <tr>

                                <td>{{ ++$key }}</td>

                                <td>{{$value->title}}</td>

                                <td>{{ \Carbon\Carbon::parse($value->start_date)->format('d M') }}</td>

                                <td>{{ \Carbon\Carbon::parse($value->end_date)->format('d M') }}</td>


                                <td>

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li>
                                            <div class="dropdown dropend">
                                                <a id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><i class="mdi mdi-dots-vertical"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-bs-auto-end="true">



                                                    <li>
                                                        <?php if ($value->mark_done == 1) : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeundoneTask-{{ $value->id }}">Mark as incomplete?</a>
                                                        <?php else : ?>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#makeTask-{{ $value->id }}">Mark as Done</a>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#editTask-{{ $value->id }}">View/Edit</a></li>


                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#removeItemModal-{{ $value->id }}">Delete</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                    </ul>
                                </td>

                            </tr>

                            @endif



                            <!-- make done in project -->

                            <div class="modal" id="makeTask-{{$value->id}}" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered modal-sm">

                                    <div class="modal-content">

                                        <div class="modal-body px-4 py-5 text-center">

                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <form action="{{ route('projects.tasks.done', ['id' => $value->id]) }}" method="post">
                                                {{ csrf_field() }}

                                                <p class="text-muted font-size-16 mb-4">Are you Sure You Want to Mark it as Complete?</p>

                                                <div class="hstack gap-2 justify-content-center mb-0">

                                                    <button type="submit" class="btn btn-danger" id="remove-item">Submit</button>

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- make undone task in project -->

                            <div class="modal" id="makeundoneTask-{{$value->id}}" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered modal-sm">

                                    <div class="modal-content">

                                        <div class="modal-body px-4 py-5 text-center">

                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <form action="{{ route('projects.tasks.undone', ['id' => $value->id]) }}" method="post">
                                                {{ csrf_field() }}


                                                <p class="text-muted font-size-16 mb-4">Are you Sure You Want to Mark it as incomplete?</p>

                                                <div class="hstack gap-2 justify-content-center mb-0">

                                                    <button type="submit" class="btn btn-danger" id="remove-item">Submit</button>

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- end removeItemModal -->

                            <!-- Modal ADD Task -->
                            <div class="modal fade" id="editTask-{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header btns primary-btn">
                                            <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('projects.task.update', ['id' => $value->id]) }}" method="post">
                                            {{ csrf_field() }}

                                            <div class="modal-body">
                                                <div class="row">

                                                    <div class="form-group col-lg-12 mt-2">
                                                        <label>Task Title<span class="text-danger"></span></label>
                                                        <input type="text" class="form-control" name="title" value="{{ $value->title }}" placeholder="Task Title" required />
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                        <label>Start Date <span class="text-danger"></span></label>
                                                        <input type="date" class="form-control" name="start_date" value="{{ $value->start_date }}" placeholder="Select Date" />
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                        <label for="designation-input" class="form-label">End Date</label>
                                                        <input type="date" class="form-control" value="{{ $value->end_date }}" placeholder="" name="end_date" />
                                                    </div>

                                                    <div class="form-group col-lg-6 mt-2">
                                                        <label>Assign To<span class="text-danger"></span></label>
                                                        <select class="form-control" name="assign_to"> <!-- Make sure the name attribute is "assign_to" -->
                                                            <option value="">Select</option>
                                                            @foreach(json_decode($project->team_ids) as $id)
                                                                @php
                                                                    $user = \App\Models\User::find($id);
                                                                @endphp
                                                                <option value="{{ $id }}" @if($value->assign_to == $id) selected @endif>
                                                                    {{ $user ? $user->name : 'Unknown User' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="form-group col-lg-6 mt-2">
                                                    <label>Developer Cost<span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="cost" value="{{ $value->cost }}" placeholder="Developer Cost" required />
                                                </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- removeItemModal Create Project -->

                            <div class="modal" id="removeItemModal-{{ $value->id }}" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered modal-sm">

                                    <div class="modal-content">

                                        <div class="modal-body px-4 py-5 text-center">

                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <div class="avatar-sm mb-4 mx-auto">

                                                <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">

                                                    <i class="mdi mdi-trash-can-outline"></i>

                                                </div>

                                            </div>

                                            <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this Project ?</p>

                                            <div class="hstack gap-2 justify-content-center mb-0">
                                                <a href="">
                                                    <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>
                                                </a>

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- end removeItemModal -->

                            @endforeach

                            @if ($tasks->count() == 0)

                            <tr class="text-center">

                                <td colspan="6">No tasks to display.</td>

                            </tr>

                            @endif

                            @endif


                        </tbody>

                    </table>

                    <!-- end table -->

                </div>

                <!-- end table responsive -->

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card">

            <div class="card-body comment-section">

                <h5>Comments on <span class="project-name">{{$project->name}}</span></h5>

                <div class="row" id="projectForm">

                    <div class="col-sm-12 me-2 mb-2 d-inline-block">

                        <div class="position-relative">

                            <div class="input-group">
                                <input type="hidden" class="product_id" value="{{$project->id}}">
                                <textarea class="form-control comment" name="comments" aria-label="With textarea" placeholder="Write a comment, report progress or add files...." required></textarea>

                                <!-- File input group-prepend -->
                                <!-- File input group-prepend -->
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fileInput" style="cursor: pointer;">
                                        <i class="mdi mdi-paperclip"></i>
                                    </label>
                                </div>

                                <!-- File input (hidden) -->
                                <input type="file" id="fileInput" style="display: none;">

                                <div class="input-group-prepend">
                                    <button class="input-group-text btn btn-outline-success submit-comment">
                                        Submit
                                    </button>
                                </div>
                            </div>

                            <table class="table table-striped mt-4 comment-list">
                                <tbody id="comment-list">

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>


            <!-- edit project section -->
        <div class="card-body edit-project-section">

            <h5>Edit Project</h5>

            <span id="edit_form">
                
            </span>

        </div>

        </div>

    </div>

</div>



@endsection

@section('script')

<!-- Required datatable js -->

<script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Responsive examples -->

<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- ecommerce-customer-list init -->

<script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

<script>
    function addComment(itemid) {

        $("#projectForm").show();

        var pname = $('.pname' + itemid).val();

        $('.project-name').text(pname);

        $('.product_id').val(itemid);

        $('.comment-section').show();

        $('.edit-project-section').hide();

    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.submit-comment').click(function() {

        var $pid = $('.product_id').val();

        var $cmt = $('.comment').val();

        if ($pid && $cmt) {
            $.ajax({

                type: 'POST',

                url: "{{ route('comment.post') }}",

                data: {
                    pid: $pid,
                    cmt: $cmt
                },

                success: function(data) {

                    $('.comment').val('');

                    getComment($pid);

                }

            });

        }

    });
</script>

<script>
    function getComment(argument) {
        $.ajax({

            type: 'POST',

            url: "{{ route('get.comment') }}",

            data: {
                pid: argument
            },

            success: function(data) {

                $('#comment-list').html(data)

            }

        });
    }
</script>

<script>
    $(window).on('load', function() {
        var $pid = $('.product_id').val();

        getComment($pid);

        $('.edit-project-section').hide();

        $('.edit-project').click(function() {

            $('.comment-section').hide();
            $('.edit-project-section').show();
        });
    });
</script>


<script>
    document.getElementById('fileInput').addEventListener('change', function(e) {

        const selectedFile = e.target.files[0];
        const commentTextarea = document.querySelector('.comment');
        commentTextarea.value = selectedFile ? selectedFile.name : '';
    });
</script>

<script>
    $(document).ready(function() {
        $("#edit-button").on("click", function() {

            $.ajax({
                url: "",
                type: "Post",
                dataType: "html",
                success: function(response) {
                    $("#edit-form").html(response);
                },
                error: function() {
                    alert("Failed to load edit form.");
                }
            });
        });
    });
</script>

<script>
    function editForm(argument) {
       if(argument){
            $.ajax({
                url: "{{route('edit.project')}}",
                type: "Post",
                data: {id:argument},
                dataType: "html",
                success: function(response) {
                    console.log(response);
                    $("#edit_form").html('');
                    $("#edit_form").html(response);
                },
                error: function() {
                    alert("Failed to load edit form.");
                }
            });
       }
    }
</script>

@endsection