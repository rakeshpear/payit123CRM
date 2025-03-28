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

    .subTitle {
        color: red !important;
    }

    th {
        color: blueviolet !important;
    }
</style>

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


    <div class="col-md-2"></div>
    <div class="col-lg-8">
        <div class="mb-4">
            <h3 class="editPage_h3">Client - <span>{{$client->client_type === 'Legal Entity' ? $client->company_name : $client->first_name . ' ' . $client->last_name}}</span></h3>
            <h6 class="text-center text-uppercase">Client Type : <span class="text-danger">{{$client->client_type}}</span></h6>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>
                        <tr>
                            <td>Client Name</td>
                            <td>{{$client->first_name}} {{$client->middle_name}} {{ $client->last_name}}</td>
                        </tr>
                        <tr>
                            <td>Company Name</td>
                            <td>{{$client->company_name}}</td>
                        </tr>
                        <tr>
                            <td>Country of Incorporation</td>
                            <td>{{$client->country}}</td>
                        </tr>
                        <tr>
                            <td>Company Address</td>
                            <td>{{$client->company_address_first}} {{$client->company_address_second}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{$client->city}}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{$client->country1}}</td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>{{$client->zip_code}}</td>
                        </tr>
                        <tr>
                            <td>Client's Main Country 1</td>
                            <td>{{$client->client_main_country_1}}</td>
                        </tr>
                        <tr>
                            <td>Client's Country 1 Volume</td>
                            <td>{{$client->client_country_1_valume}}</td>
                        </tr>
                        <tr>
                            <td>Client's Main Country 2</td>
                            <td>{{$client->client_main_country_2}}</td>
                        </tr>
                        <tr>
                            <td>Client's Country 2 Volume</td>
                            <td>{{$client->client_country_2_valume}}</td>
                        </tr>
                        <tr>
                            <td>Client's Main Country 3</td>
                            <td>{{$client->client_main_country_3}}</td>
                        </tr>
                        <tr>
                            <td>Client's Country 3 Volume</td>
                            <td>{{$client->client_country_3_valume}}</td>
                        </tr>
                        <tr>
                            <td>Technical / Integration Email</td>
                            <td>{{$client->email}}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>{{$client->website}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>

                        <tr>
                            <td>Reporting Email</td>
                            <td>{{$client->reporting_email}}</td>
                        </tr>
                        <tr>
                            <td>Accounting Email</td>
                            <td>{{$client->accounting_email}}</td>
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
                            <td>{{$client->other_currencies}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{$client->payment_method}}</td>
                        </tr>
                        <tr>
                            <td>Wallet Address</td>
                            <td>{{$client->wallet_address}}</td>
                        </tr>
                        <tr>
                            <td>Bank Name</td>
                            <td>{{$client->bank_name}}</td>
                        </tr>
                        <tr>
                            <td>IBAN</td>
                            <td>{{$client->iban}}</td>
                        </tr>
                        <tr>
                            <td>BIC</td>
                            <td>{{$client->bic}}</td>
                        </tr>

                        @if($client->client_type === 'Legal Entity')
                        <tr>
                            <td>Company's UBO Passport</td>
                            <td><a href="{{url($client->passport)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Passport</a></td>
                        </tr>
                        @else
                        <tr>
                            <td>Client Passport</td>
                            <td><a href="{{url($client->passport)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Passport</a></td>
                        </tr>
                        @endif
                        <tr>
                            <td>Status :</td>
                            <td><span class="statusSpan">{{($client->status == 0) ? 'Active' : 'Pending'}}</span></td>
                        </tr>
                        <tr>
                            <td>Contract Document :</td>
                            <td>
                                @if($client->status == 0 && $kycDetails->contract !== null )
                                <a href="{{url($kycDetails->contract)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Contract Document</a>
                                @else
                                <p>--</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($client->client_type === 'Legal Entity')
            <div class="line"></div>
            <!--UBOs-->
            <div class="col-md-12 mt-3 mb-3">
                <h5 class="subTitle mt-3">UBOs</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Residence</th>
                            <th scope="col">Region</th>
                            <th scope="col">Province</th>
                            <th scope="col">Address</th>
                            <th scope="col">Country of Birth</th>
                            <th scope="col">Citizenship</th>
                            <th scope="col">Percentage of Shareholding</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ubos as $ubo)
                        <tr>
                            <td>{{$ubo['uboName']}}</td>
                            <td>{{$ubo['uboMName']}}</td>
                            <td>{{$ubo['uboSurName']}}</td>
                            <td>{{$ubo['uboResidence']}}</td>
                            <td>{{$ubo['uboRegion']}}</td>
                            <td>{{$ubo['uboProvince']}}</td>
                            <td>{{$ubo['uboAddress']}}</td>
                            <td>{{$ubo['uboCoBirth']}}</td>
                            <td>{{$ubo['uboCitizenship']}}</td>
                            <td>{{$ubo['uboShareHolding']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="line"></div>
            <!--Signatories-->
            <div class="col-md-12 mt-3 mb-3">
                <h5 class="subTitle mt-3">Authorized Signatories</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Position</th>
                            <th scope="col">Country of Residence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($signatory as $member)
                        <tr>
                            <td>{{$member['signatoryName']}}</td>
                            <td>{{$member['signatoryMName']}}</td>
                            <td>{{$member['signatorySurName']}}</td>
                            <td>{{$member['signatoryPosition']}}</td>
                            <td>{{$member['signatoryResidence']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="line"></div>
            <!--Board Members-->
            <div class="col-md-12 mt-3 mb-3">
                <h5 class="subTitle mt-3">Board Members</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boardMembers as $member)
                        <tr>
                            <td>{{$member['boardName']}}</td>
                            <td>{{$member['boardMName']}}</td>
                            <td>{{$member['boardSurName']}}</td>
                            <td>{{$member['boardPosition']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="line"></div>

            @endif
            <!--Economic PRofile of Client-->

            <div class="col-md-6">
                <h5 class="subTitle mt-3">Economic Profile of Client</h5>
                <table class="table viewTable">
                    <tbody>
                        <tr>
                            <td>Currency</td>
                            <td>{{$client->epCurrency}}</td>
                        </tr>
                        <tr>
                            <td>Account opened on</td>
                            <td>{{$client->epAccOpenedDate}}</td>
                        </tr>
                        <tr>
                            <td>Previous Deposits</td>
                            <td>{{$client->epPrevDeposits}}</td>
                        </tr>
                        <tr>
                            <td>Previous Withdrawals</td>
                            <td>{{$client->epPrevWithDrawals}}</td>
                        </tr>
                        <tr>
                            <td>Annual Income</td>
                            <td>{{$client->epAnnualIncome}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table viewTable">
                    <tbody>

                        <tr>
                            <td>Liquid Assets</td>
                            <td>{{$client->epLiquidAssets}}</td>
                        </tr>
                        <tr>
                            <td>Financial Liabilities</td>
                            <td>{{$client->epFinancialLiabilities}}</td>
                        </tr>
                        <tr>
                            <td>Source of Funds</td>
                            <td>{{$client->epSourceOfFunds}}</td>
                        </tr>
                        <tr>
                            <td>Business Field</td>
                            <td>{{$client->epBusinessField}}</td>
                        </tr>
                        <tr>
                            <td>Positions Held</td>
                            <td>{{$client->epPositionsHeld}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Company Table 2 -->

            <div class="col-lg-12">
                <div class="mb-4">
                    <h3 class="editPage_h3">Company Documents</span></h3>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <table class="table viewTable">
                            <tbody>
                                <tr>
                                    @if(!is_null($kycDetails->incorporation))
                                    <td><a href="{{url($kycDetails->incorporation)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Certificate of Incorporation</a></td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Certificate of Incorporation</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->shareHolding))
                                    <td><a href="{{url($kycDetails->shareHolding)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Certificate of Share Holding</a></td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Certificate of Share Holding</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->processing))
                                    <td><a href="{{url($kycDetails->processing)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Six Month Processing History</a></td>
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
                                    @if(!is_null($kycDetails->coro))
                                    <td><a href="{{url($kycDetails->coro)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Certificate of Registered Office</a></td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Certificate of Registered Office</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->refund))
                                    <td><a href="{{url($kycDetails->refund)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Six Month Refund History</a></td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Six Month Refund History</a></td>
                                    @endif
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            @if($kycDetails !== null)
            <!-- KYC Table 1 -->

            <div class="col-lg-12">
                <div class="mb-4">
                    <h3 class="editPage_h3">KYC Details</span></h3>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <table class="table viewTable">
                            <tbody>
                                <tr>
                                    <td>Full Name</td>
                                    <td>{{$kycDetails->eFullName}}</td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>{{$kycDetails->eDob}}</td>
                                </tr>
                                <tr>
                                    <td>Nationality</td>
                                    <td>{{$kycDetails->eNationality}}</td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{$kycDetails->eGender}}</td>
                                </tr>
                                <tr>
                                    <td>Contact</td>
                                    <td>{{$kycDetails->eContact}}</td>
                                </tr>
                                <tr>
                                    <td>Residential Address</td>
                                    <td>{{$kycDetails->eAddr1}} <br> {{$kycDetails->eAddr2}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table viewTable">
                            <tbody>

                                <tr>
                                    <td>Country</td>
                                    <td>{{$kycDetails->eCountry}}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{$kycDetails->eCity}}</td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td>{{$kycDetails->eZip}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$kycDetails->eEmail}}</td>
                                </tr>
                                <tr>
                                    <td>KYC Submission Date</td>
                                    <td>{{$kycDetails->declarationDate}}</td>
                                </tr>
                                <tr>
                                    <td>EDD Questionnaire Response</td>
                                    <td>
                                        @if($kycDetails->eddStatus !== null)
                                        <a href="{{route('kycrequests.viewEDD',encrypt($kycDetails->id)) }}" role="button" class="btn btn-sm btn-primary">View</a>
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


            <!-- KYC Table 2 -->
            <div class="col-lg-12">
                <div class="mb-4">
                    <h3 class="editPage_h3">KYC Documents</span></h3>
                </div>
                <div class="row mt-4">
                    <div class="col-md-8 mx-auto">
                        <table class="table viewTable">
                            <tbody>
                                <tr>
                                    @if(!is_null($client->passport))
                                    <td><a href="{{url($client->passport)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Passport</a></td>
                                    <td></td>
                                    <td></td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Passport</a></td>
                                    <td></td>
                                    <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->nationalID))
                                    <td><a href="{{url($kycDetails->nationalID)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">National ID</a></td>
                                    <td>Issue Date : {{$kycDetails->nationalIDIssue}}</td>
                                    <td>Expiry Date : {{$kycDetails->nationalIDExpiry}}</td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">National ID</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->license))
                                    <td><a href="{{url($kycDetails->license)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Driving License</a></td>
                                    <td>Issue Date : {{$kycDetails->licenseIssue}}</td>
                                    <td>Expiry Date : {{$kycDetails->licenseExpiry}}</td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Driving License</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->otherID))
                                    <td><a href="{{url($kycDetails->otherID)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Other ID</a></td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Other ID</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->utilityBill))
                                    <td><a href="{{url($kycDetails->utilityBill)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Utility Bill</a></td>
                                    <td>Issue Date : {{$kycDetails->utilityBillIssue}}</td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Utility Bill</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->bankStatement))
                                    <td><a href="{{url($kycDetails->bankStatement)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Bank Statement</a></td>
                                    <td>Issue Date : {{$kycDetails->bankStatementIssue}}</td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Bank Statement</a></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(!is_null($kycDetails->leaseAgreement))
                                    <td><a href="{{url($kycDetails->leaseAgreement)}}" target="_blank" style="text-decoration:none !important; font-weight:bold">Lease Agreement</a></td>
                                    <td>Issue Date : {{$kycDetails->leaseAgreementIssue}}</td>
                                    @else
                                    <td><a class="text-secondary disabled" style="text-decoration:none !important;">Lease Agreement</a></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            @endif

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