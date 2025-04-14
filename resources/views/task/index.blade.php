@extends('layouts.master')

@section('title')

@lang('Projects')

@endsection

@section('css')

<!-- select2 css -->

<link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />


<!-- DataTables -->

<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->

<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

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

Tasks

@endslot

@slot('title')

Tasks

@endslot

@endcomponent

<div class="card">

    @include('flash_msg')

    <form action="{{route('task_master_store')}}" method="post">

        @csrf
         
        <div class="card-body row">

            <div class="col-md-8">

                <label>Tasks</label>

                <input type="text" name="title" placeholder="Enter Task" class="form-control" required>
                
            </div>

            <div class="col-md-4 mt-4"> 

                <button type="submit" class="btn btn-primary">Submit</button>
                 
            </div>
            
        </div>
    
    </form>
    

</div>

<div class="card">

    <div class="card-body">

        <table class="table table-striped">

            <thead>
                
                <th>#</th>
                <th>Title</th>
                <th class="text-end">Action</th>

            </thead>

            <tbody>
                @if(!empty($tasks))

                    @foreach($tasks as $key=>$value)
                        <tr id="rowid{{$value->id}}">

                            <td>{{++ $key}}</td>
                            <td>{{$value->title}}</td>
                            <td class="text-end">

                               @can('Task.Update')
                                <button type="button" class="btn btn-success rounded-pill btn-sm" data-toggle="modal" data-target="#EditTaskModal{{$key}}"><i class='bi bi-alarm-fill'></i> Edit</button>
                               @endcan
                                
                               @can('Task.Remove')
                                <a href="{{route('taskMaster.delete',$value->id)}}" class="btn btn-danger rounded-pill btn-sm">Delete</a>
                               @endcan
                                

                            </td>

                                 <!-- Edit Task MODAL -->
                                <div class="modal fade EdittaskMdl" id="EditTaskModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="EditTaskModallabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="EditTaskModallabel">Edit Task</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form  action="{{route('task_master_update')}}" method="post">
                                        @csrf
                                          <div class="modal-body">
                                            <div class="row">                                        
                                                <label class="col-md-2 form-group">Task<span class="text-danger">*</span></label>  

                                                <div class="col-md-8">

                                                    <input type="hidden" name="task_id" value="{{ $value->id }}">
                                                    <input type="text" name="title" value="{{$value->title}}" class="form-control" placeholder="Enter Task" required> 

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
                                <!-- CLOSE Edit Task MODAL -->
                            
                        </tr>

                                
                    @endforeach

                @endif

                @if($tasks->count()==0)

                    <tr>
                        <td>No Tasks To Display</td>
                    </tr>

                @endif
                    
            </tbody>
            
        </table>
        
    </div>

    {{$tasks->links()}}
    
</div>


@endsection

@section('script')

<script type="text/javascript">
    
    function deleteTask(id)
   {
    if(confirm('Do you Want to delete this Task'))
    {
         $.ajax({
                type: 'DELETE',
                url: '/taskMaster/delete/' + id,
                data: {
                    _token: '{{ csrf_token() }}',
                },

                success: function (response) {
                    $("#rowid"+id).remove();
                },
                error: function (error) {
                    // Handle errors
                    console.log(error.responseJSON);
                }
            });
    }
   }

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