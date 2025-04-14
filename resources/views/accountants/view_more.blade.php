@extends('layouts.master')



@section('title')

    @lang('Bill')

@endsection



@section('css')

    <!-- select2 css -->

    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- bootstrap-datepicker css -->

    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">



    <!-- DataTables -->

    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



    <!-- Responsive datatable examples -->

    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"

        type="text/css" />

@endsection



@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

           Customer Bill

        @endslot

        @slot('title')

            Customer Bill

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">



                        <div class="col-sm-6">

                            <div class="user-details">
                                <p><strong>Name:</strong> {{ $user->name }}</p>
                                <p><strong>Phone No:</strong> {{ $user->phone }}</p>
                            </div>



                        </div>



                        <div class="col-sm-6">



                            <div class="text-sm-end">


                       
                                 <div>
                                   <a href="{{url('accounts')}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>
                                    </div>

                                    <div>
                                   <button type="button" data-bs-toggle="modal" data-bs-target="#newContactModal"

                                    class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                        class="mdi mdi-plus me-1"></i> Currency Exchange</button>
                                    </div>

                            </div>


                            </div>

                        </div><!-- end col-->


                    </div>


                    <div class="tab-content p-3">

                        <div class="tab-pane active" id="all-order" role="tabpanel">

                                <div class="row">

                                    <div class="col-xl col-sm-6 align-self-end">

                                        <div class="mb-3">

                                            

                                        </div>

                                    </div>

                                </div>


                            <div class="table-responsive mt-2">

                                <table class="table table-hover datatable dt-responsive nowrap"

                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>

                                        <tr>

                                            <th scope="col">Vendor</th>

                                            <th scope="col">Bill Date</th>

                                            <th scope="col">Bill</th>

                                            <th scope="col">Due Date</th>

                                            <th scope="col">Currency</th>

                                            <th scope="col">Note</th>

                                            <th scope="col">Action</th>

                                        </tr>



                                    <tbody>

                                @foreach(App\Models\CurrencyExchange::all() as $key => $currency)

                                <tr>


                                    <td>{{ $currency->vendor }}</td>

                                    <td>{{ $currency->bill_date }}</td>

                                    <td>{{ $currency->bill }}</td>

                                    <td>{{ $currency->due_date }}</td>

                                    <td>{{ $currency->currency }}</td>

                                    <td>{{ $currency->note }}</td>


                                    <td>

                                    <ul class="list-unstyled hstack gap-1 mb-0">

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">

                                            <a href="" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>

                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">

                                            <a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="mdi mdi-delete-outline"></i></a>

                                        </li>
                                    </ul>

                                      </td>

                                </tr>

                                @endforeach



                            </tbody>

      

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <!-- end row -->

    <!-- Modal -->

    <div class="modal fade" id="newContactModal" tabindex="-1" aria-labelledby="newContactModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="newContactModalLabel">Currency Exchange</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form autocomplete="off" action="{{ route('accounts.store') }}" method="Post">

                        @csrf

                        <div class="row">

                            <div class="row">

                                <!-- <div class="col-lg-6 mb-3">

                                    <label>Vendor<span class="text-danger">*</span></label>
                                   <select class=" form-control dropdown-toggle" name="vendor" type="button" data-toggle="dropdown">
                                        
                                    </select>

                                </div> -->

                                <div class="col-lg-6 mb-3">

                                    <label>Vendor<span class="text-danger">*</span></label>
                                   <input class=" form-control" name="vendor"></input>

                                </div>

                                <div class=" col-lg-6 mb-3">

                                    <label>Bill Date<span class="text-danger"></span></label>
                                   <input type="date" class="form-control" name="bill_date" value="" placeholder="" required/>

                                </div>

                                </div>

                                <div class="row">

                                <div class="col-lg-6 mb-3">
   
                                   <label>Bill<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="bill" value="" placeholder="" required/>

                                </div>

                                <div class=" col-lg-6 mb-3">

                                   <label>Due Date<span class="text-danger"></span></label>
                                   <input type="date" class="form-control" name="due_date" value="" placeholder="" required/>

                                </div>

                                </div>

                                <div class="row">

                               <!--  <div class="col-lg-6 mb-3">
                                      <label>Currency<span class="text-danger"></span></label>
                                   <select class=" form-control dropdown-toggle" name="currency" type="button" data-toggle="dropdown">
                                        
                                    </select>

                                </div> -->

                                <div class="col-lg-6 mb-3">

                                    <label>Currency<span class="text-danger">*</span></label>
                                   <input class=" form-control" name="currency"></input>

                                </div>

                                <div class="col-lg-6 mb-3">

                                     <label>P.O/S.O<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="po_so" value="" placeholder="" required/>

                                </div>

                                </div>

             
                            <div class="col-lg-12 mb-3">
                                <label for="exampleFormControlTextarea1">Note</label>
                                   <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>

                                
                            </div>


                            <div class="col-lg-12">

                                <div class="text-end">

                                    <button type="button" class="btn btn-outline-secondary"

                                        data-bs-dismiss="modal">Cancel</button>

                                    <button type="submit" id="addContact-btn" class="btn btn-success">Submit</button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <!-- end modal body -->

            </div>

            <!-- end modal-content -->

        </div>

        <!-- end modal-dialog -->

    </div>

    <!-- end newContactModal -->

@endsection

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

