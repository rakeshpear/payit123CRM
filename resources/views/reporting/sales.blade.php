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

    <style type="text/css">
        
        p {
            font-size: 10px;
            line-height: 5px;
        }
    </style>    

@endsection



@section('content')

    @component('components.breadcrumb')

        @slot('li_1')

            Sales

        @endslot

        @slot('title')

            Adminstats

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title mb-3">Sales</h4>


                    <!-- Tab panes -->

                    <div class="tab-content p-3">

                        <div class="tab-pane active" id="all-order" role="tabpanel">

                            


                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <a class="btn btn-primary btn-sm" href="#">Excel</a>
                                    </div>
                                </div>

                                
                            </div>
                            <form action="" method="get">
                            <div class="row">

                                
                                    
                                
                                    <div class="col-md-2 form-group">
                                        <label for="s_date"> Date From</label>
                                        <!-- <input type="date" class="" name="s_date" value="{{ $request->s_date }}" placeholder="Enter Date" onchange="this.form.submit()"> -->
                                        <input type="text" placeholder="Date From" value="{{ $request->s_date ? $request->s_date : now()->toDateString() }}" name="s_date" onfocus="(this.type='date')" size="14" onchange="this.form.submit()">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="e_date">Date To</label>
                                        <input type="text" class="" name="e_date" value="{{ $request->e_date }}" placeholder="Date To"  onfocus="(this.type='date')" onchange="this.form.submit()">
                                    </div>

                                   
                                    <div class="col-lg-6">
                                        
                                    </div>

                               

                            </div>
                        </form>


                            <div class="table-responsive mt-2">

                                <table class="table table-hover datatable  nowrap"

                                    style="width: 100%; overflow-x: scroll;">

                                    <thead>

                                        <tr>

                                            <th>Client Name</th>
                                            <th>Status</th>
                                            <th>USD(Meps)</th>
                                            <th>USD(Fxcareer-Bank S)</th>
                                            <!--<th>USD(Imoxe-Stripe)</th>-->
                                            <th>EUR(Fxcareer-Bank S)</th>
                                            <!--<th>EUR(Imoxe-Stripe)</th>
                                            <th>GBP(Fxcareer-Stripe)</th>-->
                                            <!--<th>GBP(Imoxe-Stripe)</th>-->
                                            <th>USD (Total)</th>
                                            <th>EUR (Total)</th>
                                            <!--<th>GBP (Total)</th>-->

                                        </tr>



                                    </thead>



                                    <tbody>



                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapayments'])}}" >Verna1</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdv1}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdv1}} </td>

                                            <td> €{{$totaleurv1}} </td>


                                        </tr>
                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapaymentv1'])}}" >Verna2</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdv2}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdv2}} </td>

                                            <td> €{{$totaleurv2}} </td>


                                        </tr>

                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapaymentv3'])}}" >Verna3</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdv3}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdv3}} </td>

                                            <td> €{{$totaleurv3}} </td>


                                        </tr>
                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapaymentv4'])}}" >Verna4</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdv4}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdv4}} </td>

                                            <td> €{{$totaleurv4}} </td>


                                        </tr>

                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapaymentMRV'])}}" >MRV</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdmrv}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdmrv}} </td>

                                            <td> €{{$totaleurmrv}} </td>


                                        </tr>

                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapaymentMstreet'])}}" >Mstreet</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdmstreet}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdmstreet}} </td>

                                            <td> €{{$totaleurmstreet}} </td>


                                        </tr>

                                        <tr>

                                            <td> <a href="{{route('clients.data.pay_orders',['data' => 'vernapaymentRalself'])}}" >Ralseft</a> </td>

                                            <td>
                                                <p>Verna 1 Total Orders:8183 (100%)</p>
                                                <p>Success: 78.00%</p>
                                                <p>Your card does not support this type of purchase.: 0.88%</p>
                                                <p>  Your card has insufficient funds.: 6.70%</p>
                                                <p>Your card's security code is incorrect.: 1.83%</p>
                                                <p> Client did not complete 3d: 1.98%</p>
                                                <p> EARLY CHARGEBACK - REFUND RECORDED: 0.09%</p>
                                                <p>Your card has expired.: 0.05%</p>
                                               <p> Your card's security code is invalid.: 0.33%</p>
                                               <p> Invalid account.: 0.40%</p>
                                               <p> Previous chargeback by user (blocked): 0.46%</p>
                                                <p>Your card number is incorrect.: 0.13%</p>
                                                <p>CHARGEBACK: 0.01%</p>
                                               
                                            </td>

                                            <td>$0.00</td>

                                            <td>${{$totalusdralseft}}</td>

                                            <td>€0.00</td>

                                            <td> ${{$totalusdralseft}} </td>

                                            <td> €{{$totaleurralseft}} </td>


                                        </tr>


                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end row -->

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

