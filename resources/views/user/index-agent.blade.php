@extends('layouts.master')

@section('title')

    @lang('User List')

@endsection

@section('css')


    <!-- select2 css -->

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- bootstrap-datepicker css -->

    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables -->

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"

        type="text/css" />

    <style>
        .flex-1{
                display: none;
           }
         .w-5{
          display: none;
         }   
    </style>    

@endsection

@section('content')

    @component('components.breadcrumb')


        @slot('li_1')

           Agents

        @endslot

        @slot('title')

            Agents Account

        @endslot

    @endcomponent



    <div class="row">
        
        @include('flash_msg')

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">

                        <div class="col-sm-4">

                            <div class="search-box me-2 mb-2 d-inline-block">

                                <div class="position-relative">

                                    <input type="text" class="form-control" id="searchTableList" placeholder="Search...">

                                    <i class="bx bx-search-alt search-icon"></i>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-8">

                            <div class="text-sm-end">

                                @can('Agent.Create')

                                   <a href="{{route('agentcreate')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-plus me-1"></i> New  Agent</button>

                                    </a>

                                @endcan    

                            </div>

                        </div><!-- end col-->

                    </div>

                    <!-- end row -->

                    <div class="table-responsive">

                        <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100">

                            <thead class="table-light">

                                <tr>

                                    <th scope="col">#</th>

                                    <!-- <th scope="col" style="width: 40px;">Image</th> -->

                                    <th scope="col">Name</th>

                                    <th scope="col">Email</th>

                                    <th scope="col">Phone</th>

                                    <th scope="col">PendingPayout</th>
                                
                                    <th scope="col">History</th>

                                    <th scope="col" style="width: 200px;">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(!empty($users))

                                @foreach($users as $key=>$value)

                                <tr>

                                    <td>{{ ++$key }}</td>
                                    
                                    <!-- <td> <img src="{{ $value->avatar }}" alt="" class="member-img img-fluid d-block rounded-circle" /> </td> -->

                                    <td>{{ $value->name }}</td>

                                    <td>{{ $value->email }}</td>

                                    <td>{{ $value->phone }}</td>

                                    <td class="text-end">${{ $value->payout ?? 0 }}</td>
                                
                                    <td>
                                     <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#logModal{{$value->id}}">
                                        <i class="bi bi-info"></i>
                                    </button>
                                
                                    <!-- Modal -->
                                    <div class="modal modal-lg fade" id="logModal{{$value->id}}" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="logModalLabel">{{$value->name}} - Commission History - Amount to Pay - <strong>${{$value->payout}}</strong></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Client</th>
                                                        <th scope="col">Start Date</th>
                                                        <th scope="col">End Date</th>
                                                        <th scope="col">TotalTrxAmt</th>
                                                        <th scope="col">Commission Amt</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($agentSettlementLogs as $entry)
                                                        @if($entry->agent_id == $value->id)
                                                            <tr>
                                                                <td>{{$entry->clientName}}</td>
                                                                <td>{{$entry->startDate}}</td>
                                                                <td>{{$entry->endDate}}</td>
                                                                <td style="color: green !important">{{$entry->trxSuccessAmt}}</td>
                                                                <td style="color: red !important">{{$entry->commissionAmt}}</td>
                                                                <td>{{$entry->status}}</td>
                                                            </tr>
                                                            @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>                                
                             
                                </td>

                                    <td>

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        @can('Agent.Edit')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">

                                            <a href="{{ route('agent.edit',encrypt($value->id)) }}" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                        </li>
                                        @endcan

                                        @can('Agent.Delete')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                            <a href="{{ route('agentdelete', encrypt($value->id)) }}" class="delete-link text-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="mdi mdi-delete-outline"></i></a>

                                        </li>
                                        @endcan


                                        @can('Agent.Account')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View Account">

                                            <a href="{{ route('agent.view.more',encrypt($value->id)) }}" class="btn btn-sm btn-soft-info"><i class='fas fa-user-alt'></i> View Account</a>

                                        </li>
                                        @endcan

                                    </ul>

                                      </td>

                                </tr>

                                @endforeach

                                    @if ($users->count() == 0)

                                    <tr class="text-center">

                                        <td colspan="5">No User to display.</td>

                                    </tr>

                                    @endif

                                @endif

                            </tbody>

                        </table>

                        <!-- end table -->

                    </div>

                    <div>{{ $users->links() }}</div>

                    <!-- end table responsive -->

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

    <!-- init js -->

    <script src="{{ URL::asset('build/js/pages/crypto-orders.init.js') }}"></script>



@endsection



