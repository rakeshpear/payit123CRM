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

      .noBg {
         background-color: #9f9f9f !important;
      }

      .greenBorder {
         border-color: lawngreen !important;
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

      <h1>UPLOAD CONTRACT DOCUMENT</h1>


      <div class="row">

         <div class="col-lg-3"></div>

         <div class="col-lg-6">

            @include('flash_msg')

            <h6>PayIT123CRM Onboarding - Client Contract Document</h6>

            <form action="{{ route('kycrequests.storeContract', $kycRequest->id) }}" method="Post" enctype="multipart/form-data">
               @csrf

               <div class="row mt-4">
                  <h3 class="head-h3">Greetings <span>{{$kycRequest->userName->company_name}} </span>!</h3>
                  <p>Please upload the signed Contract form received in the email</p>
               </div>

               <div class="row">

                  <div class="ol-lg-6 mt-4">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="okCheckBox" id="okCheckBox" onclick="callOnClick()">
                        <label class="form-check-label" for="flexCheckChecked">
                           Are you ok with the Contract ?
                        </label>
                     </div>
                  </div>

                  <!-- Contract Document -->
                  <div class="col-lg-6 mt-4">

                     <div class="form-group ">

                        <label>Signed Contract Document <b class="text-danger">*</b> </label>
                        <input type="file" name="contract" id="contract" class="form-control mt-2">
                        @error('contract')
                        <div class="alertMessage">{{ $message }}</div>
                        @enderror
                     </div>

                  </div>

                  <!-- comments -->
                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Comments, if any</label>
                        <input type="text" name="comments" id="comments" class="form-control mt-2">

                     </div>

                  </div>


                  <div class="col-lg-12 mt-4">

                     <div class="mb-3">

                        <label>Points to Note <span class="text-danger">**</span></label>
                        <h6> <span class="text-danger">**</span>{{$kycRequest->comments}}</h6>

                     </div>

                  </div>

                  <p class="mt-4">Once documents uploaded, please wait for further updates from our side.</p>

               </div>

               <div class="text-canter mb-4 mt-2">
                  <button class="btn btn-info" type="submit">Submit</button>
               </div>

            </form>

         </div>

         <div class="col-lg-3"></div>


         <p class="bottom-content">FINFORTUNE INTERNATIONAL LIMITED (PayIT123CRM) is not an EMI or an Acquirer. It provides consultancy services in order for your company to be connected with the best matching acquirer. The Bank accounts, payment services and card processing are provided by FINFORTUNE INTERNATIONAL LIMITED's partners: EMIs, Acquirers and PSPs.</p>

         <p class="footer-content mb-4">Copyright © 2023 | PayIT123CRM - Fast Secured Payments. | All rights reserved. <a href="javscript:">Privacy Policy</a> | <a href="javascript:">Terms of Use</a> | <a href="javascript:">Cookie Policy</a> | <a href="javascript:">Data Processing Policy</a> </p>

      </div>


   </div>

   <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

   <script>
      $(document).ready(function() {
         $("#okCheckBox").prop("checked", true);
         $("#comments").prop("disabled", true);
         $("#contract").prop("disabled", false);
         $("#contract").prop("required", true);
         $('#contract').addClass("greenBorder");

      });

      function callOnClick() {
         if ($('#okCheckBox').is(":checked")) {
            $('#comments').attr("disabled", true);
            $('#comments').addClass("noBg");
            $('#comments').val("");
            $('#contract').attr("disabled", false);
            $('#contract').addClass("greenBorder");
            $('#comments').removeClass("greenBorder");
            $("#contract").prop("required", true);
            $("#comments").prop("required", false);

         } else {
            $('#comments').attr("disabled", false);
            $('#comments').removeClass("noBg");
            $('#comments').addClass("greenBorder");
            $('#contract').val("");
            $('#contract').attr("disabled", true);
            $('#contract').removeClass("greenBorder");
            $("#contract").prop("required", false);
            $("#comments").prop("required", true);
         }
      }
   </script>

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>



</body>

</html>