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

        .m-0{
            margin: 0px;
        }
        .p-0{
            padding: 0px;
        }
        .pt-5{
            padding-top:5px;
        }
        .mt-10{
            margin-top:10px;
        }
        .text-center{
            text-align:center !important;
        }
        .w-100{
            width: 100%;
        }
        .w-50{
            width:50%;
        }

        .w-85{
            width:85%;
        }
        .w-15{
            width:15%;
        }
        .logo img{
            width:45px;
            height:45px;
            padding-top:30px;
        }
        .logo span{
            margin-left:8px;
            top:19px;
            position: absolute;
            font-weight: bold;
            font-size:25px;
        }
        .gray-color{
            color:#5D5D5D;
        }
        .text-bold{
            font-weight: bold;
        }
        .border{
            border:1px solid black;
        }
        table tr,th,td{
            border: 1px solid #d2d2d2;
            border-collapse:collapse;
            padding:7px 8px;
        }
        table tr th{
            background: #F4F4F4;
            font-size:15px;
        }
        table tr td{
            font-size:13px;
        }
        table{
            border-collapse:collapse;
        }
        .box-text p{
            line-height:10px;
        }
        .float-left{
            float:left;
        }
        .total-part{
            font-size:16px;
            line-height:12px;
        }
        .total-right p{
            padding-right:20px;
        }

        .section{
        border: 4px solid #ccc;
        padding: 50px;
        margin-top: 20px;
        margin-bottom: 20px;
        }
        .row{
            text-align: float;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .row1{
            margin-top: 40px;
        }

        .right{
            text-align: end;
        }

        .left{
            text-align: start;
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


<main id="main" class="main">

    <button type="button" onclick="printPageArea('print')" class="btn btn-link float-right">Print<i class="bi bi-printer"></i></button>

    <div class="row page-titles mx-0">


        <div class="col-sm-6 p-md-0">

            <div class="breadcrumb-range-picker">

               
            </div>

        </div>

        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

            <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill ">

               Back

           </a>

       </div>

    </div>

    <div class="section">
        <h2 class="text-center m-0 p-0">Invoice</h2>

        <div class="row">
            <div class="col-6 left" style="text-align:left;">
                <p><Strong></Strong></p>
               
                

            </div>
            <div class="col-6 right" style="text-align:right;">
                <h5><Strong>DATE</Strong>-<Strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $inv->orderDate)->format('d/m/Y h:i A') }}</Strong></h5>
                <h5><Strong>INVOICE</Strong>-<Strong>{{$inv->invoiceNumber}}</Strong></h5>
                <h5><Strong>Status</Strong>-<Strong></Strong></h5>

            </div>
        </div>

        <div class="row">
            <div class="col-6 left" style="text-align:left;">
                <h3><strong>To </strong></h3>
                <h5><Strong>Name : {{$inv->fullName}}</Strong></h5>
                <h5><Strong>Tel: {{$inv->phone}}</Strong></h5>
               

            </div>
            <div class="col-6 right" style="text-align:right;">
                

            </div>
        </div>

        <div>
            <h6>Due:</h6>
        </div>

        
        <div class="table-section bill-tbl w-100 mt-15">
            <table class="table w-100 mt-15">
                <tr align="center">
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                   
                </tr>

                <tr align="center">

                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>${{$inv->amount}}</th>
                    <th>${{$inv->amount}}</th>
                    
                </tr>
               
                <tr>
                    <td colspan="3" align="right">

                               <strong>Subtotal</strong>
                            
                    </td>
                    <td align="center"><strong>$  </strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">

                               <strong>Tax</strong>
                            
                    </td>
                    <td align="center"><strong>$  </strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">

                               <strong>BALANCE DUE</strong>
                            
                    </td>
                    <td align="center"><strong>$  </strong></td>
                </tr>
            </table>

            <div>

            <strong><p>Notes</p></strong>
            <p>Tranaction ID : {{$inv->transactionID}}</p>
            <p>Order Paid : {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $inv->orderPaid)->format('d/m/Y h:i A') }}</p>
                
            </div>
        </div>
    </div>

    <div class="section" id="print">

         
        <h2 class="text-center m-0 p-0">Invoice</h2>

        <div class="row">
            <div class="col-6 left" style="text-align:left;">
                <p><Strong></Strong></p>
               
                

            </div>
            <div class="col-6 right" style="text-align:right;">
                <h5><Strong>DATE</Strong>-<Strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $inv->orderDate)->format('d/m/Y h:i A') }}</Strong></h5>
                <h5><Strong>INVOICE</Strong>-<Strong>{{$inv->invoiceNumber}}</Strong></h5>
                <h5><Strong>Status</Strong>-<Strong></Strong></h5>

            </div>
        </div>

        <div class="row">
            <div class="col-6 left" style="text-align:left;">
                <h3><strong>To</strong></h3>
                <h5><Strong>Name: {{$inv->fullName}}</Strong></h5>
                <h5><Strong>Tel:  {{$inv->phone}}</Strong></h5>
               

            </div>
            <div class="col-6 right" style="text-align:right;">
                

            </div>
        </div>

        <div>
            <h6>Due:</h6>
        </div>

        
        <div class="table-section bill-tbl w-100 mt-15">
            <table class="table w-100 mt-15">
                <tr align="center">
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                   
                </tr>

                <tr align="center">

                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>{{$inv->amount}}</th>
                    <th>{{$inv->amount}}</th>

                </tr>
               
                <tr>
                    <td colspan="3" align="right">

                               <strong>Subtotal</strong>
                            
                    </td>
                    <td align="center"><strong>$  </strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">

                               <strong>Tax</strong>
                            
                    </td>
                    <td align="center"><strong>$  </strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">

                               <strong>BALANCE DUE</strong>
                            
                    </td>
                    <td align="center"><strong>$  </strong></td>
                </tr>
            </table>

            <div>

            <strong><p>Notes</p></strong>
            <p>Tranaction ID : {{$inv->transactionID}}</p>
            <p>Order Paid : {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $inv->orderPaid)->format('d/m/Y h:i A') }}</p>
                
            </div>
        </div>
    
        
    </div>

    


</main><!-- End #main -->

@endsection

@section('script')

    <script type="text/javascript">
        $('#print').hide();
        function printPageArea(print) 
        {
            $('#print').show();
         var printContents = document.getElementById(print).innerHTML;
         var originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;

         window.print();

         document.body.innerHTML = originalContents;

        $('#print').hide();
         
        }

       
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
