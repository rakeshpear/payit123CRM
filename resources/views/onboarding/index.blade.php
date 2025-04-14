@extends('layouts.master')







@section('title')



@lang('Onboardings')



@endsection



@section('css')


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- select2 css -->



<link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />







<!-- DataTables -->



<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />







<!-- Responsive datatable examples -->



<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"



    type="text/css" />



@endsection



@section('content')



@component('components.breadcrumb')



@slot('li_1')



Onboardings



@endslot



@slot('title')



Onboardings



@endslot



@endcomponent







<div class="row">
    @include('flash_msg')


    <div class="col-lg-12">



        <div class="card">



            <div class="card-body">


                <div class="table-responsive">

                    <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100 display" id="example">

                        <thead class="table-light">

                            <tr>

                                <th scope="col">#</th>

                                <th scope="col">Full Name</th>

                                <th scope="col">Email</th>

                                <th scope="col">Company Name</th>

                                <th scope="col">City</th>

                                <th scope="col">Country</th>

                                <th scope="col">Client Type</th>

                                <th scope="col">Status</th>
                                <!-- RK -->
                                <th scope="col">View</th>

                                <th scope="col">Edit</th>
                                <!-- RK -->
                                <th scope="col" style="width: 200px;">Applied On</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($datas as $key => $data)

                            <tr>

                                <td>{{ ++$key }}</td>

                                <td>{{ $data->first_name }} {{ $data->last_name }}</td>

                                <td>{{ $data->email }}</td>

                                <td>{{ $data->company_name }}</td>

                                <td>{{ $data->city }}</td>

                                <td>{{ $data->country }}</td>

                                <td>{{ $data->client_type }}</td>

                                <td>
                                    @if($data->rejectionFlag === 0)
                                    @if($data->status=='0')
                                    <h3 class="badge bg-success">Approved</h3>
                                    @else
                                    <h3 class="badge bg-danger">Pending</h3>
                                    @endif
                                    @else
                                    <h3 class="badge bg-danger">Rejected</h3> <a href="{{route('kycrequests.revertRejection',encrypt($data->id))}}" type="button" class="btn btn-sm btn-success">Revert?</a>
                                    @endif
                                </td>

                                <!-- RK -->

                                <td>
                                    <a href="{{ route('onboarding.view', encrypt($data->id)) }}" class="btn-sm btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                                </td>

                                <td>
                                    <a href="{{ route('onboarding.edit', encrypt($data->id)) }}" class="btn-sm btn btn-warning">Edit</a>
                                </td>


                                <!-- RK -->

                                <td>{{$data->created_at}}</td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <!-- end table -->

                </div>



            </div>



        </div>



    </div>



</div>



@endsection



@section('script')

<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
<script>
    jQuery(document).ready(function() {
        new DataTable('#example');
    });
</script>

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