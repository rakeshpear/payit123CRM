<!-- RK -->

@extends('layouts.master')

@section('title')



@lang('Edit Clients Details')



@endsection

@section('css')

<style>
   .editPage_h3 {
      text-align: center !important;
      text-transform: uppercase;
   }

   .editPage_h3 span {
      color: red !important;
   }
</style>

<!--Bootstrap Icons-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<!-- select2 css -->
<link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



@endsection

@section('content')



@component('components.breadcrumb')



@slot('li_1')



Update Client



@endslot



@slot('title')



Onboardings


@endslot



@endcomponent

<div class="row mb-3">

   <div class="col-sm-4">


   </div>

   <div class="col-sm-8">

      <div class="text-sm-end">

         <a href="{{route('onboardings')}}">

            <button type="button" class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                  class="mdi mdi-arrow-left-bold-circle-outline"></i> Back</button>

         </a>

      </div>

   </div><!-- end col-->

</div>

<div class="row">


   <div class="col-md-3"></div>
   <div class="col-lg-6">



      <div class="card">



         <div class="card-body">


            <form action="{{ route('onboarding.update', $client->id) }}" method="Post" enctype="multipart/form-data">
               @csrf

               <div class="row mt-4">
                  <div class="mb-3">
                     <h3 class="editPage_h3">Client - <span>{{$client->client_type == 'Individual' ? $client->first_name . ' ' . $client->last_name :  $client->company_name}}</span></h3>
                  </div>
                  <div class="col-lg-4">

                     <div class="form-group">

                        <label>First Name <b class="text-danger">*</b> </label>

                        <input type="text" name="first_name" class="form-control mt-2" value="{{$client->first_name}}" required>

                     </div>

                  </div>

                  <div class="col-lg-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="middle_name" class="form-control mt-2" value="{{$client->middle_name}}">

                     </div>

                  </div>

                  <div class="col-lg-4">

                     <div class="form-group">

                        <label>Last Name <b class="text-danger">*</b> </label>

                        <input type="text" name="last_name" class="form-control mt-2" value="{{$client->last_name}}" required>

                     </div>

                  </div>

                  @if($client->client_type == 'Legal Entity')

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Company Name <b class="text-danger">*</b> </label>

                        <input type="text" name="company_name" class="form-control mt-2" value="{{$client->company_name}}" placeholder="Enter Company Name" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Company's Country of Incorporation <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="country" required>
                           <option value="">Select Country</option>
                           @foreach($country as $count)
                           @if($client->country === $count->name)
                           <option value="{{ $count->name }}" selected>{{ $count->name }}</option>
                           @else
                           <option value="{{ $count->name }}">{{ $count->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  @endif

                  <div class="col-lg-12 mt-4">

                     <div class="form-group">

                        <label>Address <b class="text-danger">*</b> </label>

                        <input type="text" name="company_address_first" class="form-control mt-2" value="{{$client->company_address_first}}" placeholder="Enter Address Line 1" required>

                        <input type="text" name="company_address_second" class="form-control mt-2" value="{{$client->company_address_second}}" placeholder="Enter Address Line 2">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>City <b class="text-danger">*</b> </label>

                        <input type="text" name="city" class="form-control mt-2" value="{{$client->city}}" placeholder="Enter City" required>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Country <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="country1" required>
                           <option value="">Select Country</option>
                           @foreach($country as $count)
                           @if($client->country1 === $count->name)
                           <option value="{{ $count->name }}" selected>{{ $count->name }}</option>
                           @else
                           <option value="{{ $count->name }}">{{ $count->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>


                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Zip Code <b class="text-danger">*</b> </label>

                        <input type="text" name="zip_code" class="form-control mt-2" value="{{$client->zip_code}}" placeholder="Enter Zip Code" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Technical / Integration Email <b class="text-danger">*</b> </label>

                        <input type="email" name="email" class="form-control mt-2" value="{{$client->email}}" placeholder="Enter Technical / Integration Email" required>

                     </div>

                  </div>

                  @if($client->client_type == 'Legal Entity')

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Website <b class="text-danger">*</b> </label>

                        <input type="text" name="website" class="form-control mt-2" value="{{$client->website}}" placeholder="Enter Website URL" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Reporting Email <b class="text-danger">*</b> </label>

                        <input type="email" name="reporting_email" class="form-control mt-2" value="{{$client->reporting_email}}" placeholder="Enter Reporting Email" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Accounting Email <b class="text-danger">*</b> </label>

                        <input type="email" name="accounting_email" class="form-control mt-2" value="{{$client->accounting_email}}" placeholder="Enter Accounting Email" required>

                     </div>

                  </div>

                  @endif


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Processing Currencies </label><br>

                        <div class="form-check form-check-inline">

                           @if(in_array('EURO', $client->processing_currencies))
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox1" value="EURO" checked>
                           @else
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox1" value="EURO">
                           @endif

                           <label class="form-check-label" for="inlineCheckbox1">EURO</label>

                        </div>

                        <div class="form-check form-check-inline">
                           @if(in_array('USD',$client->processing_currencies))
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox2" checked value="USD">
                           @else
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox2" value="USD">
                           @endif
                           <label class="form-check-label" for="inlineCheckbox2">USD</label>
                        </div>

                        <div class="form-check form-check-inline">
                           @if(in_array('JPY',$client->processing_currencies))
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox3" value="JPY" checked>
                           @else
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox3" value="JPY">
                           @endif
                           <label class="form-check-label" for="inlineCheckbox3">JPY</label>
                        </div>

                        <div class="form-check form-check-inline">
                           @if(in_array('GBP',$client->processing_currencies))
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox3" value="GBP" checked>
                           @else
                           <input class="form-check-input" name="processing_currencies[]" type="checkbox" id="inlineCheckbox3" value="GBP">
                           @endif
                           <label class="form-check-label" for="inlineCheckbox4">GBP</label>
                        </div>

                     </div>


                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Other Currencies Required <b class="text-danger">*</b> </label>

                        <input type="text" name="other_currencies" class="form-control mt-2" value="{{$client->other_currencies}}" placeholder="Enter Other Currencies Required" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' main country #1 <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="client_main_country_1" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           @if($client->client_main_country_1 === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' Country #1 Volume <b class="text-danger">*</b> </label>

                        <input type="text" name="client_country_1_valume" class="form-control mt-2" value="{{$client->client_country_1_valume}}" placeholder="Enter Clients' Country #1 Volume" required>

                     </div>

                  </div>


                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' main country #2 <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="client_main_country_2" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           @if($client->client_main_country_2 === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' Country #2 Volume <b class="text-danger">*</b> </label>

                        <input type="text" name="client_country_2_valume" class="form-control mt-2" value="{{$client->client_country_2_valume}}" placeholder="Enter Clients' Country #2 Volume" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' main country #3 <b class="text-danger">*</b> </label>

                        <select class="form-control mt-2" name="client_main_country_3" required>
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           @if($client->client_main_country_3 === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Clients' Country #3 Volume <b class="text-danger">*</b> </label>

                        <input type="text" name="client_country_3_valume" class="form-control mt-2" value="{{$client->client_country_3_valume}}" placeholder="Enter Clients' Country #3 Volume" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Payouts Method</label><br>
                        <div class="form-check form-check-inline">
                           @if($client->payment_method === 'USDT (% fee applies)')
                           <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio1" value="USDT (% fee applies)" onclick="paymentMethod('USDT')" checked>
                           @else
                           <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio1" value="USDT (% fee applies)" onclick="paymentMethod('USDT')">
                           @endif
                           <label class="form-check-label" for="inlineRadio1">USDT (% fee applies)</label>
                        </div>

                        <div class="form-check form-check-inline">
                           @if($client->payment_method === 'Bank Transfer')
                           <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio2" onclick="paymentMethod('Bank Transfer')" value="Bank Transfer" checked>
                           @else
                           <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio2" onclick="paymentMethod('Bank Transfer')" value="Bank Transfer">
                           @endif
                           <label class="form-check-label" for="inlineRadio2">Bank Transfer</label>
                        </div>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Wallet Address <b class="text-danger">*</b> </label>

                        <input type="text" name="wallet_address" class="form-control mt-2" value="{{$client->wallet_address}}" placeholder="Enter Wallet Address" required>

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4 bank_transfer">

                     <div class="form-group">

                        <label>Bank Name <b class="text-danger">*</b> </label>

                        <input type="text" name="bank_name" id='bank_name' class="form-control mt-2" value="{{$client->bank_name}}" placeholder="Enter Bank Name">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4 bank_transfer">

                     <div class="form-group">

                        <label>IBAN <b class="text-danger">*</b> </label>

                        <input type="text" name="iban" id='iban' class="form-control mt-2" value="{{$client->iban}}" placeholder="Enter IBAN">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4 bank_transfer">

                     <div class="form-group">

                        <label>BIC <b class="text-danger">*</b> </label>

                        <input type="text" name="bic" id='bic' class="form-control mt-2" value="{{$client->bic}}" placeholder="Enter BIC">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>When do you intend to go live?</label>

                        <input type="text" name="start_processing" class="form-control mt-2" value="{{$client->start_processing}}" placeholder="When do you intend to go live?">

                     </div>

                  </div>

               </div>

               <div class="row">

                  <!--@if($client->client_type == 'Legal Entity')-->

                  <!--<div class="col-lg-6 mt-4">-->

                  <!--   <div class="form-group">-->

                  <!--      <label>Company's Certificate of Incorporation </label>-->

                  <!--      <input type="file" name="certificate" class="form-control mt-2">-->

                  <!--   </div>-->

                  <!--</div>-->

                  <!--<div class="col-lg-6 mt-4">-->

                  <!--   <div class="form-group">-->

                  <!--      <label>Company's UBO Passport <b class="text-danger">*</b> </label>-->

                  <!--      <input type="file" name="passport" class="form-control mt-2">-->

                  <!--   </div>-->

                  <!--</div>-->

                  <!--@endif-->


                  <div class="col-lg-12 mt-4">

                     <div class="form-group">

                        <label>Comments </label>

                        <textarea
                           class="form-control mt-2"
                           name="comment"

                           placeholder="Enter Comments">{{$client->comment}}
                        </textarea>

                     </div>

                  </div>



               </div>

               @if($client->client_type == 'Legal Entity')

               @if($ubos !== null)
               <!--UBO ROW-->
               <h5 class="mt-3">UBOs</h5>

               @foreach($ubos as $ubo)
               <div class="row uboRow">



                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name </label>

                        <input type="text" name="uboName[]" value="{{$ubo['uboName']}}" class="form-control mt-2" placeholder="Name">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="uboMName[]" value="{{$ubo['uboMName']}}" class="form-control mt-2" placeholder="Middle Name">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname </label>

                        <input type="text" name="uboSurName[]" value="{{$ubo['uboSurName']}}" class="form-control mt-2" placeholder="Surname">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Residence </label>

                        <select class="form-control mt-2" name="uboResidence[]">
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           @if($ubo['uboResidence'] === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Region </label>

                        <input type="text" name="uboRegion[]" value="{{$ubo['uboRegion']}}" class="form-control mt-2" placeholder="Region">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Province </label>

                        <input type="text" name="uboProvince[]" value="{{$ubo['uboProvince']}}" class="form-control mt-2" placeholder="Province">

                     </div>

                  </div>

                  <div class="col-lg-12 mt-4">

                     <div class="form-group">

                        <label>Address </label>

                        <textarea type="text" name="uboAddress[]" value="{{$ubo['uboAddress']}}" class="form-control mt-2" rows="1" cols="50" placeholder="Address">{{$ubo['uboAddress']}}</textarea>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Date of Birth </label>

                        <input type="date" name="uboDob[]" value="{{$ubo['uboDob']}}" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Country of Birth </label>

                        <select class="form-control mt-2" name="uboCoBirth[]">
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           @if($ubo['uboCoBirth'] === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Citizenship </label>

                        <input type="text" name="uboCitizenship[]" value="{{$ubo['uboCitizenship']}}" class="form-control mt-2" placeholder="Citizenship">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Percentage of Share Holding </label>

                        <input type="text" name="uboShareHolding[]" value="{{$ubo['uboShareHolding']}}" placeholder="Percentage of Share Holding" class="form-control mt-2">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">
                        <label>Remove this UBO</label>
                        <a type="button" id="deleteUBO" href="{{ route('onboarding.deleteUbo', $ubo['id']) }}" class="btn btn-danger form-control mt-2"><i class="bi bi-person-x"></i></a>

                     </div>

                  </div>

                  <div class="line mt-3"></div>


               </div>
               @endforeach

               <div class="addHere mb-3"></div>

               <div class="col-lg-2 mt-4 mb-4">
                  <button type="button" value="" id="addUBO" onclick="addHere()" class="btn btn-primary form-control"><i class="bi bi-person-plus-fill"></i></button>
               </div>

               <div class="line mt-3"></div>
               <!--<div class="line mt-3"></div>-->
               @endif

               @if($signatory !== null)
               <!--Authorized Signatories-->
               <h5 class="mt-3">Authorized Signatories</h5>

               @foreach($signatory as $sig)
               <div class="row signatoryRow">



                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name </label>

                        <input type="text" name="signatoryName[]" value="{{$sig['signatoryName']}}" placeholder="Name" class="form-control mt-2">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="signatoryMName[]" value="{{$sig['signatoryMName']}}" placeholder="Middle Name" class="form-control mt-2">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname </label>

                        <input type="text" name="signatorySurName[]" value="{{$sig['signatorySurName']}}" placeholder="Surname" class="form-control mt-2">

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Position </label>

                        <input type="text" name="signatoryPosition[]" value="{{$sig['signatoryPosition']}}" class="form-control mt-2" placeholder="Position">

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Country of Residence </label>

                        <select class="form-control mt-2" name="signatoryResidence[]">
                           <option value="">Select Country</option>
                           @foreach($country as $c)
                           @if($sig['signatoryResidence'] === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Date of Birth </label>

                        <input type="date" name="signatoryDob[]" value="{{$sig['signatoryDob']}}" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}">

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">


                     <div class="form-group">
                        <label>Remove Signatory</label>
                        <a type="button" id="deleteSignatory" href="{{ route('onboarding.deleteSignatory', $sig['id']) }}" class="btn btn-danger form-control mt-2"><i class="bi bi-person-x"></i></a>

                     </div>


                  </div>

                  <div class="line mt-3"></div>

               </div>
               @endforeach


               <div class="addMore"></div>

               <div class="col-lg-2 mt-4 mb-4">
                  <button type="button" value="" id="addSignatory" onclick="addMore()" class="btn btn-primary form-control"><i class="bi bi-person-plus-fill"></i></button>
               </div>

               @endif



               @if($boardMembers !== null)
               <!--Board Members-->
               <h5 class="mt-3">Board Members</h5>

               @foreach($boardMembers as $board)
               <div class="row boardRow">

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Name </label>

                        <input type="text" name="boardName[]" value="{{$board['boardName']}}" class="form-control mt-2" placeholder="Name">

                     </div>

                  </div>

                  <div class="col-lg-6 mt-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="boardMName[]" value="{{$board['boardMName']}}" class="form-control mt-2" placeholder="Middle Name">

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Surname </label>

                        <input type="text" name="boardSurName[]" value="{{$board['boardSurName']}}" class="form-control mt-2" placeholder="Surname">

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Position </label>

                        <input type="text" name="boardPosition[]" value="{{$board['boardPosition']}}" class="form-control mt-2" placeholder="Position">

                     </div>

                  </div>

                  <div class="col-lg-3 mt-4">

                     <div class="form-group">

                        <label>Date of Birth </label>

                        <input type="date" name="boardDob[]" value="{{$board['boardDob']}}" class="form-control mt-2" placeholder="Date of Birth" max="{{date('Y-m-d')}}">

                     </div>

                  </div>

                  <div class="col-md-3 mt-4">
                     <div class="form-group">
                        <label>Remove Member</label>
                        <a type="button" id="deleteBoard" href="{{ route('onboarding.deleteBoard', $board['id']) }}" class="btn btn-danger form-control mt-2"><i class="bi bi-person-x"></i></a>

                     </div>

                  </div>


                  <div class="line mt-3"></div>

               </div>
               @endforeach

               <div class="addBoard"></div>

               <div class="col-lg-2 mt-4 mb-4">
                  <button type="button" value="" id="addBoard" onclick="addRow()" class="btn btn-primary form-control"><i class="bi bi-person-plus-fill"></i></button>
               </div>
               @endif

               @endif

               <!--Economic Profile of Client-->
               <div class="row economicRow">

                  <h5 class="mt-2">Economic Profile of Client</h5>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Currency </label>

                        <select class="form-control mt-2" name="epCurrency">
                           <option value="">Select Currency</option>
                           @foreach($currency as $c)
                           @if($client->epCurrency === $c->name)
                           <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                           @else
                           <option value="{{ $c->name }}">{{ $c->name }}</option>
                           @endif
                           @endforeach
                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Account opened on </label>

                        <input type="date" name="epAccOpenedDate" value="{{$client->epAccOpenedDate}}" class="form-control mt-2" max="{{date('Y-m-d')}}">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4"></div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Previous Deposits </label>

                        <input type="text" name="epPrevDeposits" value="{{$client->epPrevDeposits}}" class="form-control mt-2" placeholder="Previous Deposits">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Previous Withdrawals </label>

                        <input type="text" name="epPrevWithDrawals" value="{{$client->epPrevWithDrawals}}" class="form-control mt-2" placeholder="Previous Withdrawals">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4"></div>

                  <div class="col-lg-4 mt-4 mb-4">

                     <div class="form-group">

                        <label>Annual Income </label>

                        <input type="text" name="epAnnualIncome" value="{{$client->epAnnualIncome}}" class="form-control mt-2" placeholder="Annual Income">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4 mb-4">

                     <div class="form-group">

                        <label>Liquid Assets </label>

                        <input type="text" name="epLiquidAssets" value="{{$client->epLiquidAssets}}" class="form-control mt-2" placeholder="Liqued Assets">

                     </div>

                  </div>

                  <div class="col-lg-4 mt-4 mb-4">

                     <div class="form-group">

                        <label>Monthly Financial Liabilities </label>

                        <input type="text" name="epFinancialLiabilities" value="{{$client->epFinancialLiabilities}}" class="form-control mt-2" placeholder="Monthly Financial Liabilities">

                     </div>

                  </div>

                  <div class="col-lg-4 mb-4">

                     <div class="form-group">

                        <label>Source of Funds </label>

                        <select class="form-control mt-2" name="epSourceOfFunds">
                           <option value="">Select</option>
                           <option value="Salary" {{$client->epSourceOfFunds === "Salary" ? 'selected' : ''}}>Salary</option>
                           <option value="Rental Income" {{$client->epSourceOfFunds === "Rental Income" ? 'selected' : ''}}>Rental Income</option>
                           <option value="Sale of Property or Other Assets" {{$client->epSourceOfFunds === "Sale of Property or Other Assets" ? 'selected' : ''}}>Sale of Property or Other Assets</option>
                           <option value="Loan from Individuals" {{$client->epSourceOfFunds === "Loan from Individuals" ? 'selected' : ''}}>Loan from Individuals</option>
                           <option value="Gift" {{$client->epSourceOfFunds === "Gift" ? 'selected' : ''}}>Gift</option>
                           <option value="Inheritance" {{$client->epSourceOfFunds === "Inheritance" ? 'selected' : ''}}>Inheritance</option>
                           <option value="Dividends" {{$client->epSourceOfFunds === "Dividends" ? 'selected' : ''}}>Dividends</option>
                           <option value="Profits from Other Brokers" {{$client->epSourceOfFunds === "Profits from Other Brokers" ? 'selected' : ''}}>Profits from Other Brokers</option>
                           <option value="Savings" {{$client->epSourceOfFunds === "Savings" ? 'selected' : ''}}>Savings</option>
                           <option value="Legal Entity" {{$client->epSourceOfFunds === "Legal Entity" ? 'selected' : ''}}>Legal Entity</option>

                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mb-4">

                     <div class="form-group">

                        <label>Main Field of Business </label>

                        <select class="form-control mt-2" name="epBusinessField">
                           <option value="">Select</option>
                           <option value="Administration/Secretarial" {{$client->epBusinessField === "Administration/Secretarial" ? 'selected' : ''}}>Administration/Secretarial</option>
                           <option value="Agriculture/Environmental Sciences" {{$client->epBusinessField === "Agriculture/Environmental Sciences" ? 'selected' : ''}}>Agriculture/Environmental Sciences</option>
                           <option value="Banking/Insurance" {{$client->epBusinessField === "Banking/Insurance" ? 'selected' : ''}}>Banking/Insurance</option>
                           <option value="Construction/Real Estate" {{$client->epBusinessField === "Construction/Real Estate" ? 'selected' : ''}}>Construction/Real Estate</option>
                           <option value="Culture/Arts/Entertainment" {{$client->epBusinessField === "Culture/Arts/Entertainment" ? 'selected' : ''}}>Culture/Arts/Entertainment</option>
                           <option value="Education/Science" {{$client->epBusinessField === "Education/Science" ? 'selected' : ''}}>Education/Science</option>
                           <option value="Electronics/Telecommunication" {{$client->epBusinessField === "Electronics/Telecommunication" ? 'selected' : ''}}>Electronics/Telecommunication</option>
                           <option value="Energetics/Electricity" {{$client->epBusinessField === "Energetics/Electricity" ? 'selected' : ''}}>Energetics/Electricity</option>
                           <option value="Finance/Accounting" {{$client->epBusinessField === "Finance/Accounting" ? 'selected' : ''}}>Finance/Accounting</option>
                           <option value="Health Care/Social Care" {{$client->epBusinessField === "Health Care/Social Care" ? 'selected' : ''}}>Health Care/Social Care</option>
                           <option value="Information Technology" {{$client->epBusinessField === "Information Technology" ? 'selected' : ''}}>Information Technology</option>
                           <option value="Law/Legal Aid" {{$client->epBusinessField === "Law/Legal Aid" ? 'selected' : ''}}>Law/Legal Aid</option>
                           <option value="Marketing/Advertising" {{$client->epBusinessField === "Marketing/Advertising" ? 'selected' : ''}}>Marketing/Advertising</option>
                           <option value="Media/Public Relations" {{$client->epBusinessField === "Media/Public Relations" ? 'selected' : ''}}>Media/Public Relations</option>
                           <option value="Organization and Management" {{$client->epBusinessField === "Organization and Management" ? 'selected' : ''}}>Organization and Management</option>
                           <option value="Production/Manufacturing" {{$client->epBusinessField === "Production/Manufacturing" ? 'selected' : ''}}>Production/Manufacturing</option>
                           <option value="Sales" {{$client->epBusinessField === "Sales" ? 'selected' : ''}}>Sales</option>
                           <option value="Security/Rescue Services" {{$client->epBusinessField === "Security/Rescue Services" ? 'selected' : ''}}>Security/Rescue Services</option>
                           <option value="State and Public Administration" {{$client->epBusinessField === "State and Public Administration" ? 'selected' : ''}}>State and Public Administration</option>
                           <option value="Technical Engineering" {{$client->epBusinessField === "Technical Engineering" ? 'selected' : ''}}>Technical Engineering</option>
                           <option value="Tourism/Hotels/Catering" {{$client->epBusinessField === "Tourism/Hotels/Catering" ? 'selected' : ''}}>Tourism/Hotels/Catering</option>
                           <option value="Trade/Purchase/Supply" {{$client->epBusinessField === "Trade/Purchase/Supply" ? 'selected' : ''}}>Trade/Purchase/Supply</option>
                           <option value="Transport/Logistics" {{$client->epBusinessField === "Transport/Logistics" ? 'selected' : ''}}>Transport/Logistics</option>
                           <option value="N/A" {{$client->epBusinessField === "N/A" ? 'selected' : ''}}>N/A</option>


                        </select>

                     </div>

                  </div>

                  <div class="col-lg-4 mb-4">

                     <div class="form-group">

                        <label>Positions Held </label>
                        <input type="text" name="epPositionsHeld" value="{{$client->epPositionsHeld}}" class="form-control mt-2" placeholder="Posisions Held">

                     </div>

                  </div>

               </div>

               <div class="text-canter mb-4 mt-2">
                  <button class="btn btn-info" type="submit">Submit</button>
               </div>

            </form>



         </div>



      </div>



   </div>
   <div class="col-md-3"></div>



</div>


@endsection


@section('script')

<script>
   function paymentMethod(argument) {
      if (argument == 'Bank Transfer') {
         $('.bank_transfer').show(1000);
      } else {
         $("#bank_name").val("");
         $("#iban").val("");
         $("#bic").val("");
         $('.bank_transfer').hide(1000);

      }
   }
</script>

<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>


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

<!--for Signatory-->
<script>
   function addMore() {

      var html = `
            <div class="row">
            
            <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Name <b class="text-danger">*</b> </label>

                        <input type="text" name="signatoryName[]" placeholder="Name" class="form-control mt-2" required >

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Middle Name </label>

                        <input type="text" name="signatoryMName[]" placeholder="Middle Name" class="form-control mt-2">

                     </div>

                  </div>
                  
                  <div class="col-lg-4 mt-4">

                     <div class="form-group">

                        <label>Surname <b class="text-danger">*</b> </label>

                        <input type="text" name="signatorySurName[]" placeholder="Surname" class="form-control mt-2" required >

                     </div>

                  </div>
                  
                  <div class="col-lg-3 mt-4">

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
                  <div class="col-lg-3 mt-4"> 
                   <div class="mb-3">
                    <label for="addSignatory" class="form-label">Remove</label>
                    <button type="button" value="addSignatory" id="addSignatory" onclick="removeField(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
                    </div>
                  </div>
                  <div class="line mt-4"></div>
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
                  
                  <div class="col-lg-3 mt-4">

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
                  
                  <div class="col-md-3 mt-4">
                  <div class="mb-3 mt-2">
                    <label for="removeBoard" class="form-label">Remove</label>
                    <button type="button" value="removeBoard" id="removeBoard" onclick="removeRow(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
                    </div>    
                  </div>
                  <div class="line mt-4"></div>
                  </div>
                  
                  </div>
            
                  `;
      $('.addBoard').append(html);
   }

   function removeRow(btn) {
      $(btn).closest('.row').remove();
   }
</script>


@endsection


<!-- RK -->