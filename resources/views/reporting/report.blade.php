@extends('layouts.master')



@section('title')

    @lang('Adminstats')

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

    <style>

        .flex-1
        {
            display: none;
        }
        .w-5
        {
          display: none;
        } 

        th, td
        {
          white-space: nowrap;
        }
        thead
        {
            background-color: #e8edea;
        }

    </style>    

@endsection



@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Report

        @endslot

        @slot('title')

            Adminstats

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title mb-3">Report</h4>


                    <!-- Tab panes -->

                    <div class="tab-content p-3">

                        <div class="tab-pane active" id="all-order" role="tabpanel">

                            <!-- <div class="tab">
                                
                                <button class="tablinks" onclick="openCity(event, 'London')">Chargeback Filters</button>
                               
                            </div>

                            <div id="London" class="tabcontent">
                                 
                            </div> -->

                           

                            <div class="row">
                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <a class="btn btn-primary btn-sm " href="{{ url('download_report_excel') }}">Excel</a>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <a class="btn btn-warning btn-sm " href="{{url('/adminstatsreports')}}">Refresh</a>
                                    </div>
                                </div>
                            </div>

                            <form method="GET" action="">

                                <div class="row">

                                    <div class="col-md-2 form-group">
                                        <label for="order_date_from">Order Date From </label>
                                        <input type="date" name="order_date_from" class="" value="{{ $request->order_date_from }}">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="order_date_to">Order Date To</label>
                                        <input type="date" class="" name="order_date_to" value="{{ $request->order_date_to }}" onchange="this.form.submit()">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="s_date">Charge Back From</label>
                                        <input type="date" class="" name="s_date" value="{{ $request->s_date }}" placeholder="Enter Date">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="e_date">Charge Back To</label>
                                        <input type="date" class="" name="e_date" value="{{ $request->e_date }}" placeholder="Chargeback To date" onchange="this.form.submit()">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="cardtype">CardType</label>
                                        <select class="mt-1" name="cardtype" onchange="this.form.submit()">
                                            <option value="">Select CardType</option>
                                            <option value="Visa" @selected($request->cardtype=='Visa')>Visa</option>
                                            <option value="Mastercard" @selected($request->cardtype=='Mastercard')>Mastercard</option>
                                            <option value="American Express" @selected($request->cardtype=='American Express')>American Express</option>
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="currency">Currency</label>
                                        <select class="mt-1" name="currency" onchange="this.form.submit()">
                                            <option value="">Select Currency</option>
                                            <option value="USD" @selected($request->currency=='USD')>USD</option>
                                            <option value="EUR" @selected($request->currency=='EUR')>EUR</option>
                                            <option value="GBP" @selected($request->currency=='GBP')>GBP</option>
                                            <option value="JPY" @selected($request->currency=='JPY')>JPY</option>
                                            
                                        </select>
                                    </div>

                                </div>


                                <br>

                                <div class="row">

                                    <div class="col-md-2">

                                        <input type="text" name="cardnum" placeholder="Card Number" size="17" value="{{$request->cardnum}}">

                                    </div>

                                    <div class="col-md-2">

                                        <input type="text" name="amount" placeholder="Amount" size="17" value="{{$request->amount}}">
                                        
                                    </div>


                                </div>

                                <br>

                                <div class="row">

                                   <div class="col-md-8">
                                       
                                   </div>

                                    <div class="col-md-4 text-end">

                                         <input type="text" class="" name="search" value="{{$request->search}}" placeholder="Search">
                                         <button type="submit" class="btn btn-outline-info btn-sm">Search</button>

                                    </div>

                                </div>

                            </form>



                            <div class="table-responsive mt-2">

                                <table class="table table-hover dt-responsive nowrap"

                                    style="border-collapse: collapse; width:100%;">

                                    <thead>

                                        <tr>

                                            <th>
                                                <input name="category_all" class="select_all" type="checkbox">
                                                 {{__('All') }}
                                            </th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Charge Back Date</th>
                                            <th>Refund Status</th>
                                            <th>Included Report</th>
                                            <th>Merchant Name</th>
                                            <th>Fullname</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th>Phone</th>
                                            <th>Card Num</th>
                                            <th>Bank Name</th>
                                            <th>Descriptor</th>
                                            <th>Profile Name</th>
                                            <th>Card Type</th>
                                            <th>Amount</th>
                                            <th>Invoice Number</th>
                                            <th>Client</th>
                                            <th>Payment Result</th>
                                            <th>Transaction Id</th>
                                            <th>Order Paid</th>

                                        </tr>



                                    </thead>



                                    <tbody>
                                       

                                        @foreach($reports as $key => $value)

                                        <tr>

                                            <td>
                                                <input type="checkbox" name="records_id[]" class="checkbox gst form-check-inline" value="{{$value->orderId}}"></td>
                                            </td>

                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->orderDate)->format('d/m/Y h:i A') }}</td>


                                            <td>
                                                @if($value->orderStatus==200)
                                                Success
                                                @else
                                                Failed
                                                @endif
                                               
                                            </td>

                                            <td>{{$value->chargeback_date}}</td>

                                            <td></td>

                                            <td>@if($value->included_in_report==0)
                                                No
                                                @else
                                                Yes
                                                @endif
                                            </td>

                                            <td>{{$value->merchantName}}</td>

                                            <td>{{$value->fullName}}</td>

                                            <td>{{$value->email}}</td>

                                            <td>{{$value->country}}</td>

                                            <td>{{$value->phone}}</td>

                                            <td>{{$value->cardnum}}</td>

                                            <td>{{$value->bank_name}}</td>

                                            <td>{{$value->descriptor}}</td>

                                            <td></td>

                                            <td>{{$value->card_type}}</td>

                                            <td>{{$value->amount}}</td>

                                            <td>{{$value->invoiceNumber}}</td>

                                            <td></td>

                                            <td>{{$value->orderMessage}}</td>

                                            <td>{{$value->transactionID}}</td>

                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->orderPaid)->format('d/m/Y h:i A') }}</td>
                                            
                                        </tr>

                                        @endforeach

                                    </tbody>

                                </table>
                                {{$reports->links()}}
                            </div>
                            <!-- <div class="pagination">
                                <ul class="pagination-list">
                                    @if ($reports->currentPage() > 1)
                                        <li class="pagination-item">
                                            <a href="{{ $reports->appends(request()->all())->previousPageUrl() }}" class="pagination-link">&lt;</a>
                                        </li>
                                    @endif

                                    @if ($reports->currentPage() > 3)
                                        <li class="pagination-item">
                                            <a href="{{ $reports->appends(request()->all())->url(1) }}" class="pagination-link">1</a>
                                        </li>
                                        <li class="pagination-item disabled">
                                            <span class="pagination-link">...</span>
                                        </li>
                                    @endif

                                    @foreach(range(max(1, $reports->currentPage() - 2), min($reports->lastPage(), $reports->currentPage() + 2)) as $page)
                                        <li class="pagination-item {{ $page == $reports->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $reports->appends(request()->all())->url($page) }}" class="pagination-link">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($reports->currentPage() < $reports->lastPage() - 2)
                                        <li class="pagination-item disabled">
                                            <span class="pagination-link">...</span>
                                        </li>
                                        <li class="pagination-item">
                                            <a href="{{ $reports->appends(request()->all())->url($reports->lastPage()) }}" class="pagination-link">{{ $reports->lastPage() }}</a>
                                        </li>
                                    @endif

                                    @if ($reports->hasMorePages())
                                        <li class="pagination-item">
                                            <a href="{{ $reports->appends(request()->all())->nextPageUrl() }}" class="pagination-link">&gt;</a>
                                        </li>
                                    @endif
                                </ul>
                            </div> -->

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end row -->

@endsection

@section('script')

    <script type="text/javascript">

            $('.select_all').on('change', function() {     
                    $('.checkbox').prop('checked', $(this).prop("checked"));              
            });

            //deselect "checked all", if one of the listed checkbox category is unchecked amd select "checked all" if all of the listed checkbox category is checked

            $('.checkbox').change(function(){ //".checkbox" change 
                if($('.checkbox:checked').length == $('.checkbox').length){
                       $('.select_all').prop('checked',true);
                }else{
                       $('.select_all').prop('checked',false);
                }
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

