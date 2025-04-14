@extends('layouts.master')



@section('title')

    @lang('Reporting')

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

            Reporting

        @endslot

        @slot('title')

            Reporting

        @endslot

    @endcomponent



    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title mb-3">Reportings</h4>


                    <!-- Tab panes -->

                    <div class="tab-content p-3">

                        <div class="tab-pane active" id="all-order" role="tabpanel">

                            <form>

                                <div class="row">



                                    <div class="col-xl col-sm-6">

                                        <div class="mb-3">

                                            <label class="form-label">Date :</label>

                                            <input type="text" class="form-control" id="orderid-input"

                                                placeholder="Select date" data-date-format="dd M, yyyy"

                                                data-date-orientation="bottom auto" data-provide="datepicker"

                                                data-date-autoclose="true">

                                        </div>

                                    </div>



                                    <div class="col-xl col-sm-6">

                                        <div class="mb-3">

                                            <label class="form-label">Coin :</label>

                                            <select class="form-control select2-search-disable">

                                                <option value="BTC" selected>Bitcoin</option>

                                                <option value="ETH">Ethereum</option>

                                                <option value="LTC">litecoin</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-xl col-sm-6">

                                        <div class="mb-3">

                                            <label class="form-label">Name :</label>

                                            <select class="form-control select2-search-disable">

                                                <option value="BU" selected>Buy</option>

                                                <option value="SE">Sell</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-xl col-sm-6">

                                        <div class="mb-3">

                                            <label class="form-label">Status :</label>

                                            <select class="form-control select2-search-disable">

                                                <option value="CO" selected>Completed</option>

                                                <option value="PE">Pending</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-xl col-sm-6 align-self-end">

                                        <div class="mb-3">

                                            <button type="button" class="btn btn-primary w-md">Add Reporting</button>

                                        </div>

                                    </div>

                                </div>

                            </form>


                             <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <a class="btn btn-primary w-md" href="{{ url('download_excel') }}">Download Excel</a>
                                    </div>
                                </div>

                                <div class="col-10">
                                    <div class="mb-3">
                                        <a class="btn btn-primary w-md" href="{{ url('download_pdf') }}">Download Pdf</a>
                                    </div>
                                </div>
                            </div>




                            <div class="table-responsive mt-2">

                                <table class="table table-hover datatable dt-responsive nowrap"

                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>

                                        <tr>

                                            <th scope="col">Name</th>

                                            <th scope="col">User_id</th>

                                            <th scope="col">Deposite</th>

                                            <th scope="col">Commission</th>

                                            <th scope="col">Balance</th>

                                            <th scope="col">Status</th>

                                        </tr>



                                    </thead>



                                    <tbody>

                                        <tr>

                                            <td>03 Mar, 2020</td>

                                            <td>Buy</td>

                                            <td>Bitcoin</td>

                                            <td>1.00952 BTC</td>

                                            <td>$ 9067.62</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>Pending</a>

                                            </td>

                                        </tr>



                                        <tr>

                                            <td>04 Mar, 2020</td>

                                            <td>Sell</td>

                                            <td>Ethereum</td>

                                            <td>0.00413 ETH</td>

                                            <td>$ 2123.01</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>Completed</a>

                                            </td>

                                        </tr>



                                        <tr>

                                            <td>04 Mar, 2020</td>

                                            <td>Buy</td>

                                            <td>Bitcoin</td>

                                            <td>0.00321 BTC</td>

                                            <td>$ 1802.62</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>download</a>

                                            </td>

                                        </tr>



                                        <tr>

                                            <td>05 Mar, 2020</td>

                                            <td>Buy</td>

                                            <td>Litecoin</td>

                                            <td>0.00224 LTC</td>

                                            <td>$ 1773.01</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>Completed</a>

                                            </td>

                                        </tr>



                                        <tr>

                                            <td>06 Mar, 2020</td>

                                            <td>Buy</td>

                                            <td>Ethereum</td>

                                            <td>1.04321 ETH</td>

                                            <td>$ 9423.73</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>Pending</a>

                                            </td>

                                        </tr>



                                        <tr>

                                            <td>07 Mar, 2020</td>

                                            <td>Sell</td>

                                            <td>Bitcoin</td>

                                            <td>0.00413 ETH</td>

                                            <td>$ 2123.01</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>download</a>

                                            </td>

                                        </tr>


                                        <tr>

                                            <td>08 Mar, 2020</td>

                                            <td>Sell</td>

                                            <td>Ethereum</td>

                                            <td>0.00413 ETH</td>

                                            <td>$ 2123.01</td>

                                            <td>

                                                <a href=""><span class="badge bg-success font-size-10"></span>Pending</a>

                                            </td>

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

