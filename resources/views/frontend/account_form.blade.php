<!doctype html>
<html lang="en">

<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <!--Bootstrap Icons-->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

   <title>Apply Now | PayIT123CRM</title>
   <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
</head>

<body>
   <style>
      body {
         background-color: black;
         color: white;
      }

      .black {
         background-color: black;
      }

      h1 {
         font-weight: 100;
         text-align: center;
         padding-bottom: 50px;
         margin-top: 5%;
      }

      .w-inline-block {
         float: inline-end;
         color: white;
         text-decoration: none;
         margin-top: 9%;
      }

      .bottom-content {
         color: #9f9f9f;
         font-size: 13px;
      }

      .footer-content {
         color: #9f9f9f;
         font-size: 16px;
      }

      /* a {
         text-decoration: none !important;
         color: #9f9f9f !important;
      } */

      .uboRow,
      .signatoryRow,
      .boardRow,
      .economicRow {
         border: #686D76 solid 1px !important;
         margin: 3em 0px 2em !important;
         border-radius: 10px !important;
      }

      .mt-3 {
         font-size: 1rem !important;
      }

      .line {
         width: 100%;
         height: 1px;
         background-color: #686D76 !important;
         border: none;
      }
   </style>

   <nav class="navbar black">
      <div class="container-fluid">
         <a class="navbar-brand" href="{{ route('account.form') }}">
            <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="Logo" height="80" class="d-inline-block align-text-top">
         </a>
      </div>
   </nav>

   <div class="container">

      <h1>Apply Now</h1>


      <div class="row">

         <div class="col-lg-2"></div>

         <div class="col-lg-8">

            @include('flash_msg')

            <h6>PayIT123 CRM Processing Client - <span style="color:yellow !important">Legal Entity</span> Onboarding Form</h6>

            <form action="{{ route('store.account') }}" method="Post" enctype="multipart/form-data">
               @csrf

               <!-- <a type="button" class="btn btn-sm btn-secondary disabled" href="#">Legal Entity</a>  -->
               <a role="button" class="btn btn-sm btn-primary" href="{{route('account.form1')}}">Switch to "Individual Client" Form</a>
               <!-- <h5 class="mt-3"><span class="text-warning">**</span> Please select to switch form type </h5> -->

               <div class="row mt-4">

                  <div class="col-lg-4">

                     <div class="form-group">

                        <label>First Name <b class="text-danger">*</b> </label>

                        <input type="text" name="first_name" class="form-control mt-2" placeholder="Enter First Name" required>
                        <input type="hidden" name="clientType" value="Legal Entity">
                     </div>

                  </div>

                  <div class="col-lg-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="middle_name" class="form-control mt-2" placeholder="Enter Middle Name">

                     </div>

                  </div>

                  <div class="col-lg-4">

                     <div class="form-group">

                        <label>Last Name <b class="text-danger">*</b> </label>

                        <input type="text" name="last_name" class="form-control mt-2" placeholder="Enter Last Name" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Company Name <b class="text-danger">*</b> </label>

                        <input type="text" name="company_name" class="form-control mt-2" placeholder="Enter Company Name" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Company's Country of Incorporation <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="country" required>
                           <option value="">Select Country</option>
                           @foreach($country as $count)
                           <option value="{{ $count->name }}">{{ $count->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-12 mt-4">

                     <div class="form-group">

                        <label>Company Address <b class="text-danger">*</b> </label>

                        <input type="text" name="company_address_first" class="form-control mt-2" placeholder="Enter Address Line 1" required>

                        <input type="text" name="company_address_second" class="form-control mt-2" placeholder="Enter Address Line 2">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>City <b class="text-danger">*</b> </label>

                        <input type="text" name="city" class="form-control mt-2" placeholder="Enter City" required>

                     </div>

                  </div>

                  <div class="col-md-4 mt-4">
                     <div class="form-group">

                        <label>Country <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="country1" required>
                           <option value="">Select Country</option>
                           @foreach($country as $count)
                           <option value="{{ $count->name }}">{{ $count->name }}</option>
                           @endforeach
                        </select>

                     </div>
                  </div>


                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Zip Code <b class="text-danger">*</b> </label>

                        <input type="text" name="zip_code" class="form-control mt-2" placeholder="Enter Zip Code" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Technical / Integration Email <b class="text-danger">*</b> </label>

                        <input type="email" name="email" class="form-control mt-2" placeholder="Enter Technical / Integration Email" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Website <b class="text-danger">*</b> </label>

                        <input type="text" name="website" class="form-control mt-2" placeholder="Enter Website URL" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Reporting Email <b class="text-danger">*</b> </label>

                        <input type="email" name="reporting_email" class="form-control mt-2" placeholder="Enter Reporting Email" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Accounting Email <b class="text-danger">*</b> </label>

                        <input type="email" name="accounting_email" class="form-control mt-2" placeholder="Enter Accounting Email" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Processing Currencies </label><br>

                        <div class="form-check form-check-inline">

                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox1" value="EURO">

                           <label class="form-check-label" for="inlineCheckbox1">EURO</label>

                        </div>

                        <div class="form-check form-check-inline">

                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox2" value="USD">

                           <label class="form-check-label" for="inlineCheckbox2">USD</label>

                        </div>

                        <div class="form-check form-check-inline">

                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox3" value="JPY">

                           <label class="form-check-label" for="inlineCheckbox3">JPY</label>

                        </div>

                        <div class="form-check form-check-inline">

                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox4" value="GBP">

                           <label class="form-check-label" for="inlineCheckbox4">GBP</label>

                        </div>

                     </div>


                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Other Currencies Required </label>

                        <input type="text" name="other_currencies" class="form-control mt-2" placeholder="Enter Other Currencies Required">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' main country #1 <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="client_main_country_1" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' Country #1 Volume <b class="text-danger">*</b> </label>

                        <input type="text" name="client_country_1_valume" class="form-control mt-2" placeholder="Enter Clients' Country #1 Volume" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' main country #2</label>

                        <select class="form-control mt-2" name="client_main_country_2">
                           <option value="">Select Country</option>
                           @foreach($country as $cou)
                           <option value="{{ $cou->name }}">{{ $cou->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' Country #2 Volume</label>

                        <input type="text" name="client_country_2_valume" class="form-control mt-2" placeholder="Enter Clients' Country #2 Volume">

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' main country #3</label>

                        <select class="form-control mt-2" name="client_main_country_3">
                           <option value="">Select Country</option>
                           @foreach($country as $co)
                           <option value="{{ $co->name }}">{{ $co->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' Country #3 Volume</label>

                        <input type="text" name="client_country_3_valume" class="form-control mt-2" placeholder="Enter Clients' Country #3 Volume">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Payouts Method</label><br>

                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio1" value="USDT (% fee applies)" onclick="paymentMethod('USDT')" checked required>
                           <label class="form-check-label" for="inlineRadio1">USDT (% fee applies)</label>
                        </div>

                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio2" onclick="paymentMethod('Bank Transfer')" value="Bank Transfer" required>
                           <label class="form-check-label" for="inlineRadio2">Bank Transfer</label>
                        </div>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Wallet Address <b class="text-danger">*</b> </label>

                        <input type="text" name="wallet_address" class="form-control mt-2" placeholder="Enter Wallet Address" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4 bank_transfer">

                     <div class="form-group">

                        <label>Bank Name <b class="text-danger">*</b> </label>

                        <input type="text" name="bank_name" class="form-control mt-2" placeholder="Enter Bank Name">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4 bank_transfer">

                     <div class="form-group">

                        <label>IBAN <b class="text-danger">*</b> </label>

                        <input type="text" name="iban" class="form-control mt-2" placeholder="Enter IBAN">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4 bank_transfer">

                     <div class="form-group">

                        <label>BIC <b class="text-danger">*</b> </label>

                        <input type="text" name="bic" class="form-control mt-2" placeholder="Enter BIC">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>When do you intend to go live?</label>

                        <input type="text" name="start_processing" class="form-control mt-2" placeholder="When do you intend to go live?">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Company's UBO Passport <b class="text-danger">*</b> </label>

                        <input type="file" name="passport" class="form-control mt-2" required>

                     </div>
                     @error('passport')
                     <div class="alertMessage">{{ $message }}</div>
                     @enderror

                  </div>

               </div>










               <!--UBO ROW-->
               <div class="row uboRow">

                  <h5 class="mt-2">UBOs</h5>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="uboName[]" class="form-control mt-2" placeholder="Name" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name</label>

                        <input type="text" name="uboMName[]" class="form-control mt-2" placeholder="Middle Name">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="uboSurName[]" class="form-control mt-2" placeholder="Surname" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Residence <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="uboResidence[]" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Region <b class="text-danger">*</b> </label>

                        <input type="text" name="uboRegion[]" class="form-control mt-2" placeholder="Region" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Province <b class="text-danger">*</b> </label>

                        <input type="text" name="uboProvince[]" class="form-control mt-2" placeholder="Province" required>

                     </div>

                  </div>

                  <div class="col-lg-12 mt-4">

                     <div class="form-group">

                        <label>Address <b class="text-danger">*</b> </label>

                        <textarea type="text" name="uboAddress[]" class="form-control mt-2" rows="1" cols="50" placeholder="Address" required></textarea>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Date of Birth <b class="text-danger">*</b> </label>

                        <input type="date" name="uboDob[]" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Country of Birth <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="uboCoBirth[]" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Citizenship <b class="text-danger">*</b> </label>

                        <input type="text" name="uboCitizenship[]" class="form-control mt-2" placeholder="Citizenship" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Percentage of Share Holding <b class="text-danger">*</b> </label>

                        <input type="text" name="uboShareHolding[]" placeholder="Percentage of Share Holding" class="form-control mt-2" required>

                     </div>

                  </div>

                  <div class="addHere mb-3"></div>

                  <div class="col-lg-2 mt-4 mb-4">
                     <button type="button" value="" id="addUBO" onclick="addHere()" class="btn btn-primary form-control"><i class="bi bi-person-plus-fill"></i></button>
                  </div>

               </div>

               <!--Authorized Signatories-->
               <div class="row signatoryRow">

                  <h5 class="mt-2">Authorized Signatories</h5>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="signatoryName[]" placeholder="Name" class="form-control mt-2" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name</label>

                        <input type="text" name="signatoryMName[]" placeholder="Middle Name" class="form-control mt-2">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="signatorySurName[]" placeholder="Surname" class="form-control mt-2" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Position <b class="text-danger">*</b> </label>

                        <input type="text" name="signatoryPosition[]" class="form-control mt-2" placeholder="Position" required>

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Country of Residence <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="signatoryResidence[]" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Date of Birth <b class="text-danger">*</b> </label>

                        <input type="date" name="signatoryDob[]" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}" required>

                     </div>

                  </div>

                  <div class="col-lg-2 mt-4"></div>

                  <div class="addMore"></div>

                  <div class="col-lg-2 mt-4 mb-4">
                     <button type="button" value="" id="addSignatory" onclick="addMore()" class="btn btn-primary form-control"><i class="bi bi-person-plus-fill"></i></button>
                  </div>

               </div>

               <!--Board Members-->
               <div class="row boardRow">

                  <h5 class="mt-2">Board Members</h5>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="boardName[]" class="form-control mt-2" placeholder="Name" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Middle Name</label>

                        <input type="text" name="boardMName[]" class="form-control mt-2" placeholder="Middle Name">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="boardSurName[]" class="form-control mt-2" placeholder="Surname" required>

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Position <b class="text-danger">*</b> </label>

                        <input type="text" name="boardPosition[]" class="form-control mt-2" placeholder="Position" required>

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Date of Birth <b class="text-danger">*</b> </label>

                        <input type="date" name="boardDob[]" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}" required>

                     </div>

                  </div>

                  <div class="col-md-2 mt-4">


                  </div>

                  <div class="addBoard"></div>

                  <div class="col-lg-2 mt-4 mb-4">
                     <button type="button" value="" id="addBoard" onclick="addRow()" class="btn btn-primary form-control"><i class="bi bi-person-plus-fill"></i></button>
                  </div>


               </div>

               <!--Economic Profile of Client-->
               <div class="row economicRow">

                  <h5 class="mt-2">Economic Profile of Client</h5>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Currency <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="epCurrency" required>
                           <option value="">Select Currency</option>
                           @foreach($currency as $c)
                           <option value="{{ $c->name }}" {{$c->name === old('epCurrency') ? 'selected' : ''}}>{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Account opened on <b class="text-danger">*</b> </label>

                        <input type="date" name="epAccOpenedDate" value="{{ old('epAccOpenedDate') }}" class="form-control mt-2" required max="{{date('Y-m-d')}}">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4"></div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Previous Deposits <b class="text-danger">*</b> </label>

                        <input type="text" name="epPrevDeposits" value="{{ old('epPrevDeposits') }}" class="form-control mt-2" placeholder="Previous Deposits" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Previous Withdrawals <b class="text-danger">*</b> </label>

                        <input type="text" name="epPrevWithDrawals" value="{{ old('epPrevWithDrawals') }}" class="form-control mt-2" placeholder="Previous Withdrawals" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4"></div>

                  <div class="col-lg-4 mt-4 mb-4">

                     <div class="form-group">

                        <label>Annual Income <b class="text-danger">*</b> </label>

                        <input type="text" name="epAnnualIncome" value="{{ old('epAnnualIncome') }}" class="form-control mt-2" placeholder="Annual Income" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4 mb-4">

                     <div class="form-group">

                        <label>Liquid Assets <b class="text-danger">*</b> </label>

                        <input type="text" name="epLiquidAssets" value="{{ old('epLiquidAssets') }}" class="form-control mt-2" placeholder="Liqued Assets" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4 mb-4">

                     <div class="form-group">

                        <label>Monthly Financial Liabilities <b class="text-danger">*</b> </label>

                        <input type="text" name="epFinancialLiabilities" value="{{ old('epFinancialLiabilities') }}" class="form-control mt-2" placeholder="Monthly Financial Liabilities" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mb-4">

                     <div class="form-group">

                        <label>Source of Funds <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="epSourceOfFunds" required>
                           <option value="">Select</option>
                           <option value="Salary" {{old('epSourceOfFunds' === 'Salary') ? 'selected' : ''}}>Salary</option>
                           <option value="Rental Income" {{old('epSourceOfFunds' === 'Rental Income') ? 'selected' : ''}}>Rental Income</option>
                           <option value="Sale of Property or Other Assets" {{old('epSourceOfFunds' === 'Sale of Property or Other Assets') ? 'selected' : ''}}>Sale of Property or Other Assets</option>
                           <option value="Loan from Individuals" {{old('epSourceOfFunds' === 'Loan from Individuals') ? 'selected' : ''}}>Loan from Individuals</option>
                           <option value="Gift" {{old('epSourceOfFunds' === 'Gift') ? 'selected' : ''}}>Gift</option>
                           <option value="Inheritance" {{old('epSourceOfFunds' === 'Inheritance') ? 'selected' : ''}}>Inheritance</option>
                           <option value="Dividends" {{old('epSourceOfFunds' === 'Dividends') ? 'selected' : ''}}>Dividends</option>
                           <option value="Profits from Other Brokers" {{old('epSourceOfFunds' === 'Profits from Other Brokers') ? 'selected' : ''}}>Profits from Other Brokers</option>
                           <option value="Savings" {{old('epSourceOfFunds' === 'Savings') ? 'selected' : ''}}>Savings</option>
                           <option value="Legal Entity" {{old('epSourceOfFunds' === 'Legal Entity') ? 'selected' : ''}}>Legal Entity</option>

                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mb-4">

                     <div class="form-group">

                        <label>Main Field of Business <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="epBusinessField" required>
                           <option value="">Select</option>
                           <option value="Administration/Secretarial" {{old('epBusinessField' === 'Administration/Secretarial') ? 'selected' : ''}}>Administration/Secretarial</option>
                           <option value="Agriculture/Environmental Sciences" {{old('epBusinessField' === 'Agriculture/Environmental Sciences') ? 'selected' : ''}}>Agriculture/Environmental Sciences</option>
                           <option value="Banking/Insurance" {{old('epBusinessField' === 'Banking/Insurance') ? 'selected' : ''}}>Banking/Insurance</option>
                           <option value="Construction/Real Estate" {{old('epBusinessField' === 'Construction/Real Estate') ? 'selected' : ''}}>Construction/Real Estate</option>
                           <option value="Culture/Arts/Entertainment" {{old('epBusinessField' === 'Culture/Arts/Entertainment') ? 'selected' : ''}}>Culture/Arts/Entertainment</option>
                           <option value="Education/Science" {{old('epBusinessField' === 'Education/Science') ? 'selected' : ''}}>Education/Science</option>
                           <option value="Electronics/Telecommunication" {{old('epBusinessField' === 'Electronics/Telecommunication') ? 'selected' : ''}}>Electronics/Telecommunication</option>
                           <option value="Energetics/Electricity" {{old('epBusinessField' === 'Energetics/Electricity') ? 'selected' : ''}}>Energetics/Electricity</option>
                           <option value="Finance/Accounting" {{old('epBusinessField' === 'Finance/Accounting') ? 'selected' : ''}}>Finance/Accounting</option>
                           <option value="Health Care/Social Care" {{old('epBusinessField' === 'Health Care/Social Care') ? 'selected' : ''}}>Health Care/Social Care</option>
                           <option value="Information Technology" {{old('epBusinessField' === 'Information Technology') ? 'selected' : ''}}>Information Technology</option>
                           <option value="Law/Legal Aid" {{old('epBusinessField' === 'Law/Legal Aid') ? 'selected' : ''}}>Law/Legal Aid</option>
                           <option value="Marketing/Advertising" {{old('epBusinessField' === 'Marketing/Advertising') ? 'selected' : ''}}>Marketing/Advertising</option>
                           <option value="Media/Public Relations" {{old('epBusinessField' === 'Media/Public Relations') ? 'selected' : ''}}>Media/Public Relations</option>
                           <option value="Organization and Management" {{old('epBusinessField' === 'Organization and Management') ? 'selected' : ''}}>Organization and Management</option>
                           <option value="Production/Manufacturing" {{old('epBusinessField' === 'Production/Manufacturing') ? 'selected' : ''}}>Production/Manufacturing</option>
                           <option value="Sales" {{old('epBusinessField' === 'Sales') ? 'selected' : ''}}>Sales</option>
                           <option value="Security/Rescue Services" {{old('epBusinessField' === 'Security/Rescue Services') ? 'selected' : ''}}>Security/Rescue Services</option>
                           <option value="State and Public Administration" {{old('epBusinessField' === 'State and Public Administration') ? 'selected' : ''}}>State and Public Administration</option>
                           <option value="Technical Engineering" {{old('epBusinessField' === 'Technical Engineering') ? 'selected' : ''}}>Technical Engineering</option>
                           <option value="Tourism/Hotels/Catering" {{old('epBusinessField' === 'Tourism/Hotels/Catering') ? 'selected' : ''}}>Tourism/Hotels/Catering</option>
                           <option value="Trade/Purchase/Supply" {{old('epBusinessField' === 'Trade/Purchase/Supply') ? 'selected' : ''}}>Trade/Purchase/Supply</option>
                           <option value="Transport/Logistics" {{old('epBusinessField' === 'Transport/Logistics') ? 'selected' : ''}}>Transport/Logistics</option>
                           <option value="N/A" {{old('epBusinessField' === 'N/A') ? 'selected' : ''}}>N/A</option>


                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mb-4">

                     <div class="form-group">

                        <label>Positions Held <b class="text-danger">*</b> </label>
                        <input type="text" name="epPositionsHeld" value="{{ old('epPositionsHeld') }}" class="form-control mt-2" placeholder="Posisions Held" required>

                     </div>

                  </div>

               </div>



               <div class="col-lg-12 mt-4">

                  <div class="form-group">

                     <label>Comments </label>

                     <textarea class="form-control mt-2" name="comment" placeholder="Enter Comments"></textarea>

                  </div>

               </div>

               <p class="mt-4">Maximum chargebacks rate: 0.05% of transactions number in a week. Chargebacks mean the non-resolved ones (We will notify you of any chargeback via email, and you will have 15 days to negotiate with your client for the chargeback to be cancelled).</p>
               <div class="text-canter mb-4 mt-2">
                  <button class="btn btn-info" type="submit">Submit</button>
               </div>

         </div>

         </form>



         <div class="col-lg-2"></div>

         <div class="col-lg-6">

            <div class="text-left mt-4">
               <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="Logo" height="80" class="d-inline-block align-text-top">
            </div>

         </div>

         <div class="col-lg-6">

            <div class="text-right mt-4">
               <a href="mailto:info@payit123CRM.com" class="w-inline-block">
                  <h5>info@payit123CRM.com</h5>
               </a>
            </div>

         </div>

         <div class="col-lg-12">
            <hr class="mt-4 mb-4">
            <p class="bottom-content">FINFORTUNE INTERNATIONAL LIMITED (PayIT123CRM) is not an EMI or an Acquirer. It provides consultancy services in order for your company to be connected with the best matching acquirer. The Bank accounts, payment services and card processing are provided by FINFORTUNE INTERNATIONAL LIMITED's partners: EMIs, Acquirers and PSPs.</p>
            <p class="footer-content mb-4">Copyright © 2023 | PayIT123CRM - Fast Secured Payments. | All rights reserved. <a href="javscript:">Privacy Policy</a> | <a href="javascript:">Terms of Use</a> | <a href="javascript:">Cookie Policy</a> | <a href="javascript:">Data Processing Policy</a> </p>
         </div>

      </div>
   </div>





   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

   <script>
      $('.bank_transfer').hide();

      function paymentMethod(argument) {
         if (argument == 'Bank Transfer') {
            $('.bank_transfer').show(1000);
         } else {
            $('.bank_transfer').hide(1000);
         }
      }
   </script>

   <!--for Signatory-->
   <script>
      function addMore() {

         var html = `
            <div class="row">
            <div class="line mt-4"></div>
            <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="signatoryName[]" placeholder="Name" class="form-control mt-2" required >

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name</label>

                        <input type="text" name="signatoryMName[]" placeholder="Middle Name" class="form-control mt-2">

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="signatorySurName[]" placeholder="Surname" class="form-control mt-2" required >

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Position <b class="text-danger">*</b> </label>

                        <input type="text" name="signatoryPosition[]" class="form-control mt-2" placeholder="Position" required >

                     </div>

                  </div>
                  
                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Country of Residence <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="signatoryResidence[]" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>
                  <div class="col-lg-3 mt-4">
                        <div class="form-group">

                        <label>Date of Birth <b class="text-danger">*</b> </label>

                        <input type="date" name="signatoryDob[]" class="form-control mt-2" placeholder="Date of Birth"  max="{{date('Y-m-d')}}"  required>

                     </div>
                    </div>
                  <div class="col-lg-2 mt-4"> 
                   <div class="mb-3">
                    <label for="addSignatory" class="form-label">Remove</label>
                    <button type="button" value="addSignatory" id="addSignatory" onclick="removeField(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
                    </div>
                  </div>
                  </div>
                  `
         $('.addMore').append(html);
      }

      function removeField(btn) {
         $(btn).closest('.row').remove();
      }
   </script>

   <!--for Board Members-->
   <script>
      function addRow() {

         var html = `
            <div class="row mb-4">
            <div class="line mt-4"></div>
                    <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="boardName[]" class="form-control mt-2" placeholder="Name" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="boardMName[]" class="form-control mt-2" placeholder="Middle Name">

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="boardSurName[]" class="form-control mt-2" placeholder="Surname" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Position <b class="text-danger">*</b> </label>

                        <input type="text" name="boardPosition[]" class="form-control mt-2" placeholder="Position" required>

                     </div>

                  </div>
                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Date of Birth <b class="text-danger">*</b> </label>

                        <input type="date" name="boardDob[]" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}" required>

                     </div>

                  </div>
                  
                  <div class="col-md-2 mt-4">
                  <div class="mb-3">
                    <label for="removeBoard" class="form-label">Remove</label>
                    <button type="button" value="removeBoard" id="removeBoard" onclick="removeRow(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
                    </div>    
                  </div>
                  
                  </div>
                  </div>
            
                  `;
         $('.addBoard').append(html);
      }

      function removeRow(btn) {
         $(btn).closest('.row').remove();
      }
   </script>

   <!--for UBOs-->
   <script>
      function addHere() {

         var html = `
            <div class="row">
            <div class="line mt-4"></div>
            <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="uboName[]" class="form-control mt-2" placeholder="Name" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="uboMName[]" class="form-control mt-2" placeholder="Middle Name">

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="uboSurName[]" class="form-control mt-2" placeholder="Surname" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Residence <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="uboResidence[]" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Region <b class="text-danger">*</b> </label>

                        <input type="text" name="uboRegion[]" class="form-control mt-2" placeholder="Region" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Province <b class="text-danger">*</b> </label>

                        <input type="text" name="uboProvince[]" class="form-control mt-2" placeholder="Province" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-12 mt-4">

                     <div class="form-group">

                        <label>Address <b class="text-danger">*</b> </label>

                        <textarea type="text" name="uboAddress[]" class="form-control mt-2" rows="1" cols="50" placeholder="Address" required></textarea>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Date of Birth <b class="text-danger">*</b> </label>

                        <input type="date" name="uboDob[]" class="form-control mt-2" placeholder="Date of Birth"  max="{{date('Y-m-d')}}" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Country of Birth <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="uboCoBirth[]" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endforeach
                        </select>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Citizenship <b class="text-danger">*</b> </label>
 
                        <input type="text" name="uboCitizenship[]" class="form-control mt-2" placeholder="Citizenship" required>

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Percentage of Share Holding <b class="text-danger">*</b> </label>

                        <input type="text" name="uboShareHolding[]" placeholder="Percentage of Share Holding" class="form-control mt-2" required>

                     </div>

                  </div>
                  <div class="col-lg-2 mt-4">
                  <div class="mb-3">
                    <label for="" class="form-label">Remove</label>
                    <button type="button" value="" id="" onclick="removeHere(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
                    </div>
                  </div>
            </div>
            `;
         $('.addHere').append(html);
      }

      function removeHere(btn) {
         $(btn).closest('.row').remove();
      }
   </script>

</body>

</html>