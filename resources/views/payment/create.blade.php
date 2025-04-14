@extends('layouts.master')



@section('title')



    @lang('User Add')



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



            Payments



        @endslot



        @slot('title')



        Add New Payments



        @endslot



    @endcomponent


    <div class="content-wrapper" style="margin-top: 15px">

    <div class="row">

        @include('multiselect')

        <div class="col-12">

            <div class="card">

                <div class="card-body">

                     <div class="row mb-2">



                        <div class="col-sm-4">



                            <div class="search-box me-2 mb-2 d-inline-block">



                            </div>



                        </div>



                        <div class="col-sm-8">



                            <div class="text-sm-end">


                                   <a href="{{url()->previous()}}">

                                       <button type="button" class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                                       class="mdi mdi-arrow-left me-1"></i> Back</button>

                                    </a>



                            </div>



                        </div><!-- end col-->



                    </div>

                       <form autocomplete="off" action="{{ route('payments.store') }}" method="Post">

                        @csrf

                        <!-- Modal body -->
                        <div class="row">
                          
                            <div class="form-group col-lg-3 mt-2">
                                    <label>Customers <span class="text-danger"></span></label>
                                     <select class="form-control" name="customer">
                                        <option value="">Select Customers</option>
                                        @foreach($customers as $customer)
                                         <option value="{{$customer->id}}">{{$customer->name}}</option>   
                                        @endforeach
                                      </select>
                            </div>

                            <div class="form-group col-lg-3 mt-2">
                                <label>Amount <span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" oninput="calculateConvertedAmount()" required/>
                            </div>

                            <div class="form-group col-lg-2 mt-2">
                                <label>Convert From<span class="text-danger"></span></label>
                                <select class="form-control" name="currency" id="from_currency" oninput="calculateConvertedAmount()" required>
                                    <option value="usd">($) USD</option>
                                    <option value="eur">(€) EURO</option>
                                    <option value="gbp">(£) GBP</option>
                                    <option value="inr">(₹) INR</option>
                                    <option value="aud">($) AUD</option>

                                    
                                </select>
                            </div>


                            <div class="form-group col-lg-2 mt-2">
                                <label>Convert In<span class="text-danger"></span></label>
                                <select class="form-control" name="crypto" id="to_crypto" oninput="calculateConvertedAmount()" required>
                                    <option value="tether">Tether USDT</option>
                                    <option value="bitcoin">Bitcoin</option>
                                    <option value="ethereum">Ethereum</option>
                                    <option value="usdc">USDC</option>
                                    <option value="dogecoin">Dogecoin</option>
                                    <option value="solana">Solana</option>
                                    <option value="tron">Tron</option>
                                    <option value="polygon">Polygon</option>
                                    
                                </select>
                            </div>
                        

                            <div class="form-group col-lg-2 mt-2">
                                <label>Convert Amount<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="convert_amount" name="convert_amount" readonly>
                            </div>

                            

                            <div id="resultContainer">
                                <!-- Conversion result will be displayed here -->
                            </div>

                        </div>

                        <div class="text-center" style="margin-top:20px">

                            <button type="submit" class="btn btn-success">Submit</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

      </div>


@endsection


@section('script')

<script>

    function calculateConvertedAmount() {
        const amountInput = document.getElementById('amount').value;
        const fromCurrencySelect = document.getElementById('from_currency');
        const toCryptoSelect = document.getElementById('to_crypto');
        const convertAmount = document.getElementById('convert_amount');
        const resultContainer = document.getElementById('resultContainer'); // Define resultContainer
        const fromCurrency = fromCurrencySelect.value;
        const toCrypto = toCryptoSelect.value;
        // const toCrypto = 'tether';

        // alert(toCrypto);
        // Construct the API URL with the provided parameters.
        const apiUrl = `https://api.coingecko.com/api/v3/simple/price?ids=${toCrypto}&vs_currencies=${fromCurrency}`;

        // Make an HTTP request to the API endpoint.
        fetch(apiUrl)
          .then(response => response.json())
          .then(data => {
            // Handle the response data.
            console.log(`Current price of ${toCrypto} in ${fromCurrency}: ${data[toCrypto][fromCurrency]}`);

            const conversionRate = data[toCrypto][fromCurrency];
            const convertedAmount = (amountInput * (1/conversionRate));

            convertAmount.value = convertedAmount.toFixed(2);


          })
          .catch(error => {
            // Handle errors.
            console.error('Error fetching data:', error);
          });
    


                // try {
                //     const response = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${toCrypto}&vs_currencies=${fromCurrency}`);

                //     const exchangeRates = await response.json();

                //      // console.log('Exchange Rates:', exchangeRates);
                    
                //     if (!exchangeRates[fromCurrency]) {
                //         resultContainer.innerHTML = '<p class="text-danger">Invalid currency or cryptocurrency selected.</p>';
                //         return;
                //     }

                //     const conversionRate = exchangeRates[fromCurrency][toCrypto];
                //     const convertedAmount = amountInput * conversionRate;

                //     // Use convertAmount instead of convert_amount
                //     convertAmount.value = convertedAmount.toFixed(2);
                // } 
                // catch (error) {
                //     resultContainer.innerHTML = `<p class="text-danger">Error fetching exchange rates: ${error.message}</p>`;
                // }

    }

    // Initial call to calculateConvertedAmount when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        calculateConvertedAmount();

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



