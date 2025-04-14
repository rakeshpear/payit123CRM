<!-- RK -->

@extends('layouts.master')

@section('title')

@lang('Clients View')

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

    td:nth-child(2) {
        font-weight: bold;
    }

    td:nth-child(3) {
        font-weight: bold;
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



View Client



@endslot



@slot('title')



KYC Requests


@endslot



@endcomponent
<div class="row mb-3">

    <div class="col-sm-4">


    </div>

    <div class="col-sm-8">

        <div class="text-sm-end">

            <a href="{{route('kycrequests')}}">

                <button type="button" class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2"><i

                        class="mdi mdi-arrow-left-bold-circle-outline"></i> Back</button>

            </a>

        </div>

    </div><!-- end col-->

</div>


<div class="row">

    <!-- Company Table 1 -->
    <div class="col-md-2"></div>
    <div class="col-lg-8">
        <div class="mb-4">
            <h3 class="editPage_h3">Client - <span>{{$client->userName->client_type == 'Individual' ? $client->userName->first_name . ' ' . $client->userName->last_name : $client->userName->company_name}}</span></h3>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>
                        <tr>
                            <td>Client Name</td>
                            <td>{{$client->userName->first_name}} {{ $client->userName->last_name}}</td>
                        </tr>
                        <tr>
                            <td>Company Name</td>
                            <td>{{$client->userName->company_name}}</td>
                        </tr>
                        <tr>
                            <td>Country of Incorporation</td>
                            <td>{{$client->userName->country}}</td>
                        </tr>
                        <tr>
                            <td>Company Address</td>
                            <td>{{$client->userName->company_address_first}} {{$client->userName->company_address_second}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{$client->userName->city}}</td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>{{$client->userName->zip_code}}</td>
                        </tr>
                        <tr>
                            <td>Client's Main Country 1</td>
                            <td>{{$client->userName->client_main_country_1}}</td>
                        </tr>
                        <tr>
                            <td>Client's Country 1 Volume</td>
                            <td>{{$client->userName->client_country_1_valume}}</td>
                        </tr>
                        <tr>
                            <td>Client's Main Country 2</td>
                            <td>{{$client->userName->client_main_country_2}}</td>
                        </tr>
                        <tr>
                            <td>Client's Country 2 Volume</td>
                            <td>{{$client->userName->client_country_2_valume}}</td>
                        </tr>
                        <tr>
                            <td>Client's Main Country 3</td>
                            <td>{{$client->userName->client_main_country_3}}</td>
                        </tr>
                        <tr>
                            <td>Client's Country 3 Volume</td>
                            <td>{{$client->userName->client_country_3_valume}}</td>
                        </tr>
                        <tr>
                            <td>Technical / Integration Email</td>
                            <td>{{$client->userName->email}}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>{{$client->userName->website}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>

                        <tr>
                            <td>Reporting Email</td>
                            <td>{{$client->userName->reporting_email}}</td>
                        </tr>
                        <tr>
                            <td>Accounting Email</td>
                            <td>{{$client->userName->accounting_email}}</td>
                        </tr>
                        <tr>
                            <td>Processing Currencies</td>
                            <td>
                                @if($client->processing_currencies)
                                @foreach($client->processing_currencies as $cur)
                                <p style="display: inline-block;">{{$cur}}</p><br>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Other Currencies Required</td>
                            <td>{{$client->userName->other_currencies}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{$client->userName->payment_method}}</td>
                        </tr>
                        <tr>
                            <td>Wallet Address</td>
                            <td>{{$client->userName->wallet_address}}</td>
                        </tr>
                        <tr>
                            <td>Bank Name</td>
                            <td>{{$client->userName->bank_name}}</td>
                        </tr>
                        <tr>
                            <td>IBAN</td>
                            <td>{{$client->userName->iban}}</td>
                        </tr>
                        <tr>
                            <td>BIC</td>
                            <td>{{$client->userName->bic}}</td>
                        </tr>

                        <tr>
                            <td>Status :</td>
                            <td><span class="statusSpan">{{$client->status}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>

    <!-- Company Table 2 -->
    <div class="col-md-2"></div>
    <div class="col-lg-8">
        <div class="mb-4">
            <h3 class="editPage_h3">Company Documents</span></h3>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>
                        <tr>
                            @if(!is_null($client->incorporation))
                            <td><a href="{{url($client->incorporation)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Certificate of Incorporation</a></td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Certificate of Incorporation</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->shareHolding))
                            <td><a href="{{url($client->shareHolding)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Certificate of Share Holding</a></td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Certificate of Share Holding</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->processing))
                            <td><a href="{{url($client->processing)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Six Month Processing History</a></td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Six Month Processing History</a></td>
                            @endif
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>

                        <tr>
                            @if(!is_null($client->coro))
                            <td><a href="{{url($client->coro)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Certificate of Registered Office</a></td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Certificate of Registered Office</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->refund))
                            <td><a href="{{url($client->refund)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Six Month Refund History</a></td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Six Month Refund History</a></td>
                            @endif
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>

    <!-- KYC Table 1 -->
    <div class="col-md-2"></div>
    <div class="col-lg-8">
        <div class="mb-4">
            <h3 class="editPage_h3">KYC Details</span></h3>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>
                        <tr>
                            <td>Full Name</td>
                            <td>{{$client->eFullName}}</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>{{$client->eDob}}</td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td>{{$client->eNationality}}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>{{$client->eGender}}</td>
                        </tr>
                        <tr>
                            <td>Contact</td>
                            <td>{{$client->eContact}}</td>
                        </tr>
                        <tr>
                            <td>Residential Address</td>
                            <td>{{$client->eAddr1}} <br> {{$client->eAddr2}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>

                        <tr>
                            <td>Country</td>
                            <td>{{$client->eCountry}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{$client->eCity}}</td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>{{$client->eZip}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$client->eEmail}}</td>
                        </tr>
                        <tr>
                            <td>KYC Submission Date</td>
                            <td>{{$client->declarationDate}}</td>
                        </tr>
                        <tr>
                            <td>EDD Questionnaire Response</td>
                            <td>
                                @if($client->eddStatus !== null)
                                <a href="{{route('kycrequests.viewEDD',encrypt($client->id)) }}" role="button" class="btn btn-sm btn-primary">View</a>
                                @else
                                <a href="#" role="button" class="btn btn-sm btn-secondary disabled">View</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>

    <!-- KYC Table 2 -->
    <div class="col-md-2"></div>
    <div class="col-lg-8">
        <div class="mb-4">
            <h3 class="editPage_h3">KYC Documents</span></h3>
        </div>
        <div class="row mt-4">
            <div class="col-md-8 mx-auto">
                <table class="table viewTable">
                    <tbody>
                        <tr>
                            @if(!is_null($client->passportt))
                            <td><a href="{{url($client->passportt)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Passport</a></td>
                            <td>Issue Date : {{$client->passportIssue}}</td>
                            <td>Expiry Date : {{$client->passportExpiry}}</td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Passport</a></td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->nationalID))
                            <td><a href="{{url($client->nationalID)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">National ID</a></td>
                            <td>Issue Date : {{$client->nationalIDIssue}}</td>
                            <td>Expiry Date : {{$client->nationalIDExpiry}}</td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">National ID</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->license))
                            <td><a href="{{url($client->license)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Driving License</a></td>
                            <td>Issue Date : {{$client->licenseIssue}}</td>
                            <td>Expiry Date : {{$client->licenseExpiry}}</td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Driving License</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->otherID))
                            <td><a href="{{url($client->otherID)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Other ID</a></td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Other ID</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->utilityBill))
                            <td><a href="{{url($client->utilityBill)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Utility Bill</a></td>
                            <td>Issue Date : {{$client->utilityBillIssue}}</td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Utility Bill</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->bankStatement))
                            <td><a href="{{url($client->bankStatement)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Bank Statement</a></td>
                            <td>Issue Date : {{$client->bankStatementIssue}}</td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Bank Statement</a></td>
                            @endif
                        </tr>
                        <tr>
                            @if(!is_null($client->leaseAgreement))
                            <td><a href="{{url($client->leaseAgreement)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Lease Agreement</a></td>
                            <td>Issue Date : {{$client->leaseAgreementIssue}}</td>
                            @else
                            <td><a class="text-secondary disabled" style="text-decoration:none !important;">Lease Agreement</a></td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="col-md-2"></div>

</div>


@endsection


@section('script')

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



@endsection

<!-- RK -->