<!doctype html>
<html lang="en">

<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <title>KYC Uploads | PayIT123CRM</title>
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
         margin-top: 3%;
      }

      .head-h3 span {
         color: red !important;
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

      a {
         text-decoration: none !important;
         color: #9f9f9f !important;
      }

      .alertMessage {
         color: yellow !important;
         padding-top: 5px !important;
      }

      .alertTab {
         border-color: red !important;
      }

      .help-block {
         color: yellow !important;
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

      <h1>KYC PROCESS</h1>


      <div class="row">

         <div class="col-lg-2"></div>

         <div class="col-lg-8">

            <!-- @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul>
                        @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                        @endforeach
                     </ul>
                  </div>
            @endif -->

            <h6>PayIT123CRM Processing Client - <span style="color: yellow;">Documents Re-Submission Form</span></h6>

            <form action="{{ route('kycrequests.storeDoc', $kycRequest->id) }}" method="Post" enctype="multipart/form-data">
               @csrf

               <div class="row mt-4">
                  <h3 class="head-h3">Greetings <span>{{$kycRequest->userName->company_name}} </span>!</h3>
                  <p>Please re-upload the necessary documents for the onboarding process</p>
                  <p style="color:yellow !important">Only PDF, JPG, JPEG, PNG files will be accepted</p>
               </div>

               <div class="row">
                  <div class="col-md-12 row">
                     <!-- Passport -->
                     <!-- @if(in_array('Passport', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="form-label mb-3">Passport <b class="text-danger">*</b></label>
                              <input type="file" name="passport" class="form-control @if($errors->has('passport')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->passportt_reason}}</span>
                              @error('passport')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label for="passportIssue" class="form-label mb-3">Date of Issue</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->passportIssue}}" name="passportIssue" id="passportIssue" max="{{date('Y-m-d')}}">
                              @error('passportIssue')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label for="passportExpiry" class="form-label mb-3">Date of Expiry</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->passportExpiry}}" name="passportExpiry" id="passportExpiry" min="{{date('Y-m-d')}}">
                              @error('passportExpiry')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif -->

                     <!-- National ID -->
                     @if(in_array('National ID', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>National ID <b class="text-danger">*</b></label>
                              <input type="file" name="nationalID" class="form-control mt-3 @if($errors->has('nationalID')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->nationalID_reason}}</span>
                              @error('nationalID')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label for="nationalIDIssue" class="form-label mb-3">Date of Issue</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->nationalIDIssue}}" name="nationalIDIssue" id="nationalIDIssue" max="{{date('Y-m-d')}}" required>
                              @error('nationalIDIssue')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label for="nationalIDExpiry" class="form-label mb-3">Date of Expiry</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->nationalIDExpiry}}" name="nationalIDExpiry" id="nationalIDExpiry" min="{{date('Y-m-d')}}" required>
                              @error('nationalIDExpiry')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif

                     <!-- Driving License -->
                     @if(in_array('Driving License', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>Driving License <b class="text-danger">*</b></label>
                              <input type="file" name="license" class="form-control mt-3 @if($errors->has('license')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->license_reason}}</span>
                              @error('license')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label for="licenseIssue" class="form-label mb-3">Date of Issue</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->licenseIssue}}" name="licenseIssue" id="licenseIssue" max="{{date('Y-m-d')}}" required>
                              @error('licenseIssue')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label for="licenseExpiry" class="form-label mb-3">Date of Expiry</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->licenseExpiry}}" name="licenseExpiry" id="licenseExpiry" min="{{date('Y-m-d')}}" required>
                              @error('licenseExpiry')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif

                     <!-- Other IDs -->
                     @if(in_array('Other ID', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Other ID <b class="text-danger">*</b></label>
                              <input type="file" name="otherID" class="form-control mt-3 @if($errors->has('otherID')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->otherID_reason}}</span>
                              @error('otherID')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif

                     <!-- Utility Bill -->
                     @if(in_array('Utility Bill', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Utility Bill <b class="text-danger">*</b></label>
                              <input type="file" name="utilityBill" class="form-control mt-3 @if($errors->has('utilityBill')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->utilityBill_reason}}</span>
                              @error('utilityBill')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label for="utilityBillIssue" class="form-label mb-3">Date of Issue</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->utilityBillIssue}}" name="utilityBillIssue" id="utilityBillIssue" max="{{date('Y-m-d')}}" required>
                              @error('utilityBillIssue')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif

                     <!-- Bank Statement -->
                     @if(in_array('Bank Statement', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Bank Statement <b class="text-danger">*</b></label>
                              <input type="file" name="bankStatement" class="form-control mt-3 @if($errors->has('bankStatement')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->bankStatement_reason}}</span>
                              @error('bankStatement')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label for="bankStatementIssue" class="form-label mb-3">Date of Issue</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->bankStatementIssue}}" name="bankStatementIssue" id="bankStatementIssue" max="{{date('Y-m-d')}}" required>
                              @error('bankStatementIssue')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif

                     <!-- Lease Agreement -->
                     @if(in_array('Lease Agreement', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-12 row mt-4">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Lease Agreement <b class="text-danger">*</b></label>
                              <input type="file" name="leaseAgreement" class="form-control mt-3 @if($errors->has('leaseAgreement')) alertTab @endif">
                              <span class="help-block mt-2">** {{$kycRequest->leaseAgreement_reason}}</span>
                              @error('leaseAgreement')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label for="leaseAgreementIssue" class="form-label mb-3">Date of Issue</label> <b class="text-danger">*</b> </label>
                              <input type="date" class="form-control mb-3" value="{{$kycRequest->leaseAgreementIssue}}" name="leaseAgreementIssue" id="leaseAgreementIssue" max="{{date('Y-m-d')}}" required>
                              @error('leaseAgreementIssue')
                              <div class="alertMessage">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     @endif

                     <!-- Certificate of Incorporation -->
                     @if(in_array('Certificate of Incorporation', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-6 mt-4">
                        <div class="form-group">
                           <label>Company's Certificate of Incorporation <b class="text-danger">*</b> </label>
                           <input type="file" name="incorporation" value="{{ old('incorporation') }}" class="form-control mt-2 mb-2 @if($errors->has('incorporation')) alertTab @endif">
                           <span class="help-block mt-2">** {{$kycRequest->incorporation_reason}}</span>

                           @error('incorporation')
                           <div class="alertMessage">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     @endif

                     <!-- certificate_of_share_holding -->
                     @if(in_array('Certificate of Share Holding', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-6 mt-4">
                        <label>Certificate of Share Holding <b class="text-danger">*</b></label>
                        <input type="file" name="shareHolding" class="form-control mt-2 mb-2 @if($errors->has('shareHolding')) alertTab @endif">
                        <span class="help-block mt-2">** {{$kycRequest->shareHolding_reason}}</span>
                        @error('shareHolding')
                        <div class="alertMessage">{{ $message }}</div>
                        @enderror
                     </div>
                     @endif


                     <!-- Certificate of Registered Office -->
                     @if(in_array('Certificate of Registered Office', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-6 mt-4">


                        <label>Certificate of Registered Office <b class="text-danger">*</b></label>
                        <input type="file" name="coro" class="form-control mt-2 mb-2 @if($errors->has('coro')) alertTab @endif">
                        <span class="help-block">** {{$kycRequest->coro_reason}}</span>
                        @error('coro')
                        <div class="alertMessage">{{ $message }}</div>
                        @enderror

                     </div>
                     @endif

                     <!-- 6_months_processing_history -->
                     @if(in_array('6 Months Processing History', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-6 mt-4">
                        <label>Six Months Processing History <b class="text-danger">*</b></label>
                        <input type="file" name="processing" class="form-control mt-2 mb-2 @if($errors->has('processing')) alertTab @endif">
                        <span class="help-block">** {{$kycRequest->processing_reason}}</span>

                        @error('processing')
                        <div class="alertMessage">{{ $message }}</div>
                        @enderror
                     </div>
                     @endif

                     <!-- 6_months_refund_history -->
                     @if(in_array('6 Months Refund History', json_decode($kycRequest->requiredDocs)))
                     <div class="col-lg-6 mt-4">
                        <label>Six Months Refund History <b class="text-danger">*</b></label>
                        <input type="file" name="refund" class="form-control mt-2 mb-2 @if($errors->has('refund')) alertTab @endif">
                        <span class="help-block">** {{$kycRequest->refund_reason}}</span>

                        @error('refund')
                        <div class="alertMessage">{{ $message }}</div>
                        @enderror
                     </div>
                     @endif

                     <!-- comments -->
                     <div class="col-lg-12 mt-4">

                        <div class="form-group">

                           <label>Comments, if any</label>
                           <input type="text" name="comments" class="form-control mt-2 @if($errors->has('comments')) alertTab @endif">
                           @error('comments')
                           <div class="alertMessage">{{ $message }}</div>
                           @enderror
                        </div>

                     </div>


                     <div class="col-lg-12 mt-4">

                        <div class="mb-3">

                           <label>Points to Note <span class="text-danger">**</span></label>
                           <h6> <span class="text-danger">**</span>{{$kycRequest->comments}}</h6>

                        </div>

                     </div>

                     <p class="mt-4">Once upload the documents, please wait for further updates from our side.</p>

                  </div>
               </div>

               <div class="text-canter mb-4 mt-2">
                  <button class="btn btn-info" type="submit">Submit</button>
               </div>

            </form>

         </div>

         <div class="col-lg-2"></div>


         <p class="bottom-content">FINFORTUNE INTERNATIONAL LIMITED (PayIT123CRM) is not an EMI or an Acquirer. It provides consultancy services in order for your company to be connected with the best matching acquirer. The Bank accounts, payment services and card processing are provided by FINFORTUNE INTERNATIONAL LIMITED's partners: EMIs, Acquirers and PSPs.</p>

         <p class="footer-content mb-4">Copyright © 2023 | PayIT123CRM - Fast Secured Payments. | All rights reserved. <a href="javscript:">Privacy Policy</a> | <a href="javascript:">Terms of Use</a> | <a href="javascript:">Cookie Policy</a> | <a href="javascript:">Data Processing Policy</a> </p>

      </div>


   </div>


   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>



</body>

</html>