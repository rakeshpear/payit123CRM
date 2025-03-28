@extends('layouts.master')







@section('title')



    @lang('Request Payment')



@endsection



@section('css')



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



            Request Payment



        @endslot



        @slot('title')



            Request Payment



        @endslot



    @endcomponent







    <div class="row">



        <div class="col-lg-12">



            <div class="card">



                <div class="card-body">

                    <form autocomplete="off" action="{{ route('request.payment.post') }}" method="Post">
                        @csrf

                        <div class="row">
                            
                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                            
                                    <label>Existing Beneficiary</label><br>

                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="beneficiary" id="inlineRadio1" value="Yes" onclick="getBeneficiary('Yes')" checked>
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="beneficiary" id="inlineRadio2" value="No" onclick="getBeneficiary('No')">
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                            
                                    <label>Currency</label><br>

                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="currency" id="EUR" value="EUR">
                                      <label class="form-check-label" for="EUR">EUR</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="currency" id="USD" value="USD" checked>
                                      <label class="form-check-label" for="USD">USD</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="currency" id="GBP" value="GBP">
                                      <label class="form-check-label" for="GBP">GBP</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="currency" id="AED" value="AED">
                                      <label class="form-check-label" for="AED">AED</label>
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Customer <a href="{{ route('admin.client.create') }}"><b title="Create Customer" class="text-info"><i class="mdi mdi-plus me-1"></i></b></a> </label>

                                    <select class="form-control" name="customer_id" onchange="getCustomerPay(this.value)" required>
                                        <option>Select Customer</option>
                                        @foreach($customers as $Key => $cust)
                                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                            <div class="col-lg-6 mt-2">
                                
                                <div class="form-group">
                                    
                                    <label>Customer Payment</label>

                                    <select class="form-control payment_list" name="customer_payment_id" required>
                                        <option value="">Select Customer Payment</option>
                                    </select>

                                </div>

                            </div>

                            <div class="col-lg-6 mt-2 beneficiary_section">
                                
                                <div class="form-group">
                                    
                                    <label>Recipient Name</label>

                                    <input type="text" name="recipient_name" class="form-control" placeholder="Recipient Name">

                                </div>

                            </div>

                            <div class="col-lg-6 mt-2 beneficiary_section">
                                
                                <div class="form-group">
                                    
                                    <label>IBAN</label>

                                    <input type="text" name="iban" class="form-control" placeholder="IBAN">

                                </div>
                                
                            </div>

                            <div class="col-lg-6 mt-2 beneficiary_section">
                                
                                <div class="form-group">
                                    
                                    <label>BIC</label>

                                    <input type="text" name="bic" class="form-control" placeholder="BIC">

                                </div>
                                
                            </div>

                            

                        </div>

                        <div class="text-center mt-4">
                            
                            <button class="btn btn-success">Submit</button>

                        </div>

                    </form>

                </div>



            </div>



        </div>



    </div>



@endsection



@section('script')



    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>







    <!-- Required datatable js -->



    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>



    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>







    <!-- Responsive examples -->



    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>



    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>







    <!-- ecommerce-customer-list init -->



    <script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

    <script>

        function getBeneficiary(argument) {

            if(argument=='Yes'){
                $('.beneficiary_section').show();
            } else {
                $('.beneficiary_section').hide();
            }
        }
    </script>


@endsection



