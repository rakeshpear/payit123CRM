<!-- RK -->

@extends('layouts.master')

@section('title')

@lang('EDD Response')

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

    /* td:nth-child(2) {
        font-weight: bold;
    }

    td:nth-child(3) {
        font-weight: bold;
    } */

    .accordion-button {
        color: black !important;
        font-size: 1rem !important;
    }

    .tableSubHead {
        text-transform: uppercase;
        color: red !important;
    }

    .question {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #5271fa !important;
    }

    .answer {
        margin-bottom: 10px;
        font-size: 1rem;
    }

    table>tr>td {
        font-size: 1rem !important;
    }

    .btnCtrl {
        padding: 0.1rem !important;
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

<!-- Animate CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@endsection

@section('content')

@component('components.breadcrumb')

@slot('li_1')

EDD Response

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

                <button type="button" class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                    <i class="mdi mdi-arrow-left-bold-circle-outline"></i> Back
                </button>

            </a>

        </div>

    </div><!-- end col-->

</div>


<div class="row">
    <div class="col-md-12">
        <h3 class="editPage_h3">EDD Questionnaire Responses - <span class="text-danger">{{$EddValues->onboardDetail->client_type == 'Individual' ? $EddValues->onboardDetail->first_name . ' ' . $EddValues->onboardDetail->last_name :  $EddValues->onboardDetail->company_name}}</h3></span>
    </div>

    @include('flash_msg')
    <div class="col-md-6 mt-3 mb-4 mx-auto">

        <!-- 1. Business Information -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Business Information
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Legal Name of Business</td>
                                    <td>{{$EddValues->legalName}}</td>
                                </tr>
                                <tr>
                                    <td>Registered Business Address</td>
                                    <td>{{$EddValues->businessAddress}}</td>
                                </tr>
                                <tr>
                                    <td>Nature of Business Activities</td>
                                    <td>{{$EddValues->businessNature}}</td>
                                </tr>
                                <tr>
                                    <td>How long has your business been operational ? (in years)</td>
                                    <td>{{$EddValues->businessYears}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Business Information')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl"> Reject </a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb1" onchange="toggleForm1()">
                            <label class="form-check-label mb-3" for="cb1">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form1">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Business Information">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore1">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore1()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 2. Ownership & Management -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                        Ownership Management
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <h5 class="tableSubHead mt-3 mb-3">Beneficial Owner Details</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Beneficial Owner Name</td>
                                    <td>{{$EddValues->bOwnerName}}</td>
                                </tr>
                                <tr>
                                    <td>Beneficial Owner Address</td>
                                    <td>{{$EddValues->bOwnerAddr}}</td>
                                </tr>
                                <tr>
                                    <td>Percentages Owned</td>
                                    <td>{{$EddValues->bOwnerPercentage}}%</td>
                                </tr>

                            </tbody>
                        </table>
                        <h5 class="tableSubHead mt-3 mb-3">Management Team Details</h5>
                        @if($mTeam !== null)
                        <table class="table">
                            <thead>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Background</th>
                            </thead>
                            <tbody>
                                @foreach($mTeam as $team)
                                <tr>
                                    <td>{{$team['name']}}</td>
                                    <td>{{$team['title']}}</td>
                                    <td>{{$team['background']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Third Party Stakeholders / Partners (If Any)</td>
                                    <td>{{$EddValues->thirdPartyName}}</td>
                                    <td style="width: 40% !important;"></td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Ownership Management')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge  {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb2" onchange="toggleForm2()">
                            <label class="form-check-label mb-3" for="cb2">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form2">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Ownership Management">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore2">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore2()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. Client & Transaction Information -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                        Client & Transaction Information
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <h5 class="tableSubHead mt-3 mb-3">Primary Customer Demographics</h5>
                        @if($demography !== null)
                        <table class="table">
                            <thead>
                                <th>Regions</th>
                                <th>Type of Transactions</th>
                            </thead>
                            <tbody>
                                @foreach($demography as $demography)
                                <tr>
                                    <td>{{$demography['region']}}</td>
                                    <td>{{$demography['transType']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                        <h5 class="tableSubHead mt-3">Payment Services</h5>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 60% !important;">Payment Services Offered</td>
                                    <td>
                                        @if(!($EddValues->paymentServices))
                                        @foreach(json_decode($EddValues->paymentServices) as $service)
                                        <p style="display: inline-block;">{{$service}}</p><br>
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Any other payment services ?</td>
                                    <td>
                                        {{$EddValues->otherPayServices}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 60% !important;">Third Party Stakeholders / Partners (If Any)</td>
                                    <td>{{$EddValues->thirdPartyName}}</td>
                                </tr>
                                <tr>
                                    <td>Average Transaction Size</td>
                                    <td>{{$EddValues->avgTransSize}}</td>
                                </tr>
                                <tr>
                                    <td>Frequency of Transactions (e.g. Daily, Weekly)</td>
                                    <td>{{$EddValues->transFreq}}</td>
                                </tr>
                                <tr>
                                    <td>High Risk Industries Served</td>
                                    <td>{{$EddValues->highRiskIndustry}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Client & Transaction Information')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb3" onchange="toggleForm3()">
                            <label class="form-check-label mb-3" for="cb3">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form3">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Client & Transaction Information">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore3">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore3()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 4. Geographic Risks -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                        Geographic Risks
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Countries of Operation</td>
                                    <td>@if($EddValues->countriesOfOperation)
                                        @foreach(json_decode($EddValues->countriesOfOperation) as $country)
                                        <p style="display: inline-block;">{{$country}}</p><br>
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Transactions with Sanctioned Countries</td>
                                    <td>{{$EddValues->countriesTransactions}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Geographic Risks')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>

                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb4" onchange="toggleForm4()">
                            <label class="form-check-label mb-3" for="cb4">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form4">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Geographic Risks">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore4">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore4()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- 5. Compliance & Regulatory Framework -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseFive">
                        Compliance & Regulatory Framework
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Compliance Measures for AML/CTF</td>
                                    <td>{{$EddValues->cMeasure}}</td>
                                </tr>
                                <tr>
                                    <td>Designated Compliance Officer</td>
                                    <td>{{$EddValues->cOfficerName}}</td>
                                </tr>
                                <tr>
                                    <td>Contact</td>
                                    <td>{{$EddValues->cOfficerContact}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$EddValues->cOfficerEmail}}</td>
                                </tr>
                                <tr>
                                    <td>Regulatory Investigations or Actions</td>
                                    <td>{{$EddValues->regInvestigations}}</td>
                                </tr>

                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Compliance & Regulatory Framework')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb5" onchange="toggleForm5()">
                            <label class="form-check-label mb-3" for="cb5">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form5">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Compliance & Regulatory Framework">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore5">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore5()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 6. Financial Information -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="true" aria-controls="panelsStayOpen-collapseSix">
                        Financial Information
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Financial Statements for the Past 3 Years</td>
                                    @if($EddValues->financialStatement)
                                    <td><a href="{{url($EddValues->financialStatement)}}" target="_blank">Click Here to see</a></td>
                                    @else
                                    <td>Not Available</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Source of Funding</td>
                                    <td>{{$EddValues->sourceOfFunding}}</td>
                                </tr>
                                <tr>
                                    <td>Outstanding Debts or Legal Liabilities</td>
                                    <td>{{$EddValues->debtsLiabilities}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Financial Information')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb6" onchange="toggleForm6()">
                            <label class="form-check-label mb-3" for="cb6">
                                Need More Clarifications?
                            </label>
                            @endif
                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form6">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Financial Information">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore6">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore6()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 7. Internal Controls & Risk Management -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="true" aria-controls="panelsStayOpen-collapseSeven">
                        Internal Controls & Risk Management
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Internal Controls to Prevent Fraud/ML</td>
                                    <td>{{$EddValues->internalControls}}</td>
                                </tr>
                                <tr>
                                    <td>Transaction Monitoring Procedures</td>
                                    <td>{{$EddValues->monitoringProcedures}}</td>
                                </tr>
                                <tr>
                                    <td>Handling of Suspicious Activity Reports (SARs)</td>
                                    <td>{{$EddValues->handlingSAR}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Internal Controls & Risk Management')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>

                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb7" onchange="toggleForm7()">
                            <label class="form-check-label mb-3" for="cb7">
                                Need More Clarifications?
                            </label>
                            @endif
                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form7">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Internal Controls & Risk Management">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore7">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore7()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 8. Reputation & Background -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true" aria-controls="panelsStayOpen-collapseEight">
                        Reputation & Background
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Criminal Activities or Lawsuits Involving Owners/Management</td>
                                    <td>{{$EddValues->criminalActivities}}</td>
                                </tr>
                                <tr>
                                    <td>Affiliations with Politically Exposed Persons (PEPs)</td>
                                    <td>{{$EddValues->pep}}</td>
                                </tr>
                                <tr>
                                    <td>Negative Media Reports (If Any)</td>
                                    <td>{{$EddValues->negativeReports}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Reputation & Background')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb8" onchange="toggleForm8()">
                            <label class="form-check-label mb-3" for="cb8">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form8">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Reputation & Background">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore8">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore8()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 9. Technology & Security -->
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseNine" aria-expanded="true" aria-controls="panelsStayOpen-collapseNine">
                        Technology & Security
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseNine" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Technology Platforms Used for Payment Processing</td>
                                    <td>{{$EddValues->techPlatforms}}</td>
                                </tr>
                                <tr>
                                    <td>Customer Data and Transaction Security Measures</td>
                                    <td>{{$EddValues->securityMeasures}}</td>
                                </tr>
                                <tr>
                                    <td>Cybersecurity Measures in Place</td>
                                    <td>{{$EddValues->cyberSecurity}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($questions)
                        <div class="mt-3">
                            <h5 style="color: red !important;" class="mb-3">Additional Clarifications by Admin</h5>
                            @foreach($questions as $qs)
                            @if($qs->category === 'Technology & Security')
                            <div class="question"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Received' ? 'bg-danger' : 'bg-warning'}}">{{$qs->status}}</span>
                                @if($qs->status !== 'Open' && $EddValues->status !== 'EDD Approved')
                                <i class="bi bi-caret-right-fill text-secondary"></i>
                                <a href="{{route('kycrequests.approveResponse', $qs->id)}}" type="button" class="btn btn-sm btn-success btnCtrl">Approve</a>
                                <a href="{{route('kycrequests.rejectResponse', $qs->id)}}" type="button" class="btn btn-sm btn-danger btnCtrl">Reject</a>
                                @endif
                            </div>
                            @if($qs->answer !== null)
                            <div class="answer"><span>R :</span> {{$qs->answer}}</div>
                            @else
                            <div class="answer"><span>R :</span> Yet to receive.</div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-3 qsDiv">
                            @if($EddValues->status !== 'EDD Approved' )
                            <input class="form-check-input" type="checkbox" value="" id="cb9" onchange="toggleForm9()">
                            <label class="form-check-label mb-3" for="cb9">
                                Need More Clarifications?
                            </label>
                            @endif

                            <form action="{{route('kycrequests.eddFormSubmission')}}" method="post" id="form9">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="category" value="Technology & Security">
                                    <input type="hidden" name="EddValue" value="{{$EddValues->id}}">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="addMore9">

                                    </div>
                                    <div class="col-md-1 mt-3 btn-group">
                                        <button type="button" value="" id="addTeamMember" onclick="addMore9()" class="btn btn-sm btn-primary form-control"><i class="bi bi-plus-lg"></i></button>
                                        <button type="submit" class="btn btn-sm btn-warning mx-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4 mx-auto">

        @if($EddValues->status !== 'Response Received' && $EddValues->status !== 'EDD Approved' && $EddValues->status !== null)

        @if($EddValues->status === 'Queries Raised')
        <a href="{{route('SendEDDResponseMail.mail', encrypt($EddValues->id))}}" role="button" class="btn btn-sm btn-danger animate__animated animate__slow animate__tada animate__repeat-3">Ask Client to Respond</a>
        @else
        <a href="{{route('SendEDDResponseMail.mail', encrypt($EddValues->id))}}" role="button" class="btn btn-sm btn-secondary">Re-Ask Client to Respond</a>
        @endif

        @else

        <a href="#" role="button" class="btn btn-sm btn-secondary disabled">Ask Client to Respond</a>

        @endif


        @if($EddValues->status !== 'EDD Approved' && $tick !== 1)
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Close EDD
        </button>
        @else
        <a href="#" role="button" class="btn btn-sm btn-secondary disabled">Close EDD</a>
        @endif


        <!-- @if($EddValues->status === "Response Received" && $tick == 0)
        <a href="{{route('kycrequests.closeEdd', encrypt($EddValues->id))}}" role="button" class="btn btn-sm btn-success">Close EDD</a>
        @else
        <a href="#" role="button" class="btn btn-sm btn-secondary disabled">Close EDD</a>
        @endif -->

        <!-- Button trigger modal -->
        <!-- @if($EddValues->status === "Response Received" && $tick == 0) -->

        <!-- @else
        <a href="#" role="button" class="btn btn-sm btn-secondary disabled">Close EDD</a>
        @endif -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Close EDD</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Are you satisfied with all the replies?</h5>
                        <h5>Are you sure to proceed?</h5>

                        @if($tick == 1)
                        <p class="mt-3 text-danger">Some of the response are still open. Please make sure all queries addressed before close the EDD.</p>
                        @else
                        <p class="mt-3 text-danger">Please ensure all the queries are addressed by the Client and approved by admin before proceed</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{route('kycrequests.closeEdd', encrypt($EddValues->id))}}" role="button" class="btn btn-sm btn-success">Close EDD</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection


@section('script')

<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
<!-- <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script> -->

<!-- <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script> -->


<!-- 1. Business Information -->
<script>
    const form1 = document.getElementById('form1');
    form1.style.display = 'none';

    function toggleForm1() {
        const checkbox1 = document.getElementById("cb1");
        const form1 = document.getElementById("form1");

        if (checkbox1.checked) {
            form1.style.display = "block"; // Show the form

            form1.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form1.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form1.style.display = "none"; // Hide the form
        }

    }

    function addMore1() {

        var html = `
        <div class="row row1">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField1(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore1').append(html);
    }

    function removeField1(btn) {
        $(btn).closest('.row1').remove();
    }
</script>

<!-- 2. Ownership Management -->
<script>
    const form2 = document.getElementById('form2');
    form2.style.display = 'none';

    function toggleForm2() {
        const checkbox2 = document.getElementById("cb2");
        const form2 = document.getElementById("form2");

        if (checkbox2.checked) {
            form2.style.display = "block"; // Show the form

            form2.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form2.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form2.style.display = "none"; // Hide the form
        }

    }

    function addMore2() {

        var html = `
        <div class="row row2">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField2(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore2').append(html);
    }

    function removeField2(btn) {
        $(btn).closest('.row2').remove();
    }
</script>

<!-- 3. Client & Transaction Information -->
<script>
    const form3 = document.getElementById('form3');
    form3.style.display = 'none';

    function toggleForm3() {
        const checkbox3 = document.getElementById("cb3");
        const form3 = document.getElementById("form3");

        if (checkbox3.checked) {
            form3.style.display = "block"; // Show the form

            form3.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form3.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form3.style.display = "none"; // Hide the form
        }

    }

    function addMore3() {

        var html = `
        <div class="row row3">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField3(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore3').append(html);
    }

    function removeField3(btn) {
        $(btn).closest('.row3').remove();
    }
</script>

<!-- 4. Geographic Risks -->
<script>
    const form4 = document.getElementById('form4');
    form4.style.display = 'none';

    function toggleForm4() {
        const checkbox4 = document.getElementById("cb4");
        const form4 = document.getElementById("form4");

        if (checkbox4.checked) {
            form4.style.display = "block"; // Show the form

            form4.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form4.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form4.style.display = "none"; // Hide the form
        }

    }

    function addMore4() {

        var html = `
        <div class="row row4">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField4(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore4').append(html);
    }

    function removeField4(btn) {
        $(btn).closest('.row4').remove();
    }
</script>

<!-- 5. Compliance & Regulatory Framework -->
<script>
    const form5 = document.getElementById('form5');
    form5.style.display = 'none';

    function toggleForm5() {
        const checkbox5 = document.getElementById("cb5");
        const form5 = document.getElementById("form5");

        if (checkbox5.checked) {
            form5.style.display = "block"; // Show the form

            form5.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form5.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form5.style.display = "none"; // Hide the form
        }

    }

    function addMore5() {

        var html = `
        <div class="row row5">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField5(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore5').append(html);
    }

    function removeField5(btn) {
        $(btn).closest('.row5').remove();
    }
</script>

<!-- 6. Financial Information -->
<script>
    const form6 = document.getElementById('form6');
    form6.style.display = 'none';

    function toggleForm6() {
        const checkbox6 = document.getElementById("cb6");
        const form6 = document.getElementById("form6");

        if (checkbox6.checked) {
            form6.style.display = "block"; // Show the form

            form6.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form6.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form6.style.display = "none"; // Hide the form
        }

    }

    function addMore6() {

        var html = `
        <div class="row row6">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField6(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore6').append(html);
    }

    function removeField6(btn) {
        $(btn).closest('.row6').remove();
    }
</script>

<!-- 7. Internal Controls & Risk Management -->
<script>
    const form7 = document.getElementById('form7');
    form7.style.display = 'none';

    function toggleForm7() {
        const checkbox7 = document.getElementById("cb7");
        const form7 = document.getElementById("form7");

        if (checkbox7.checked) {
            form7.style.display = "block"; // Show the form

            form7.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form7.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form7.style.display = "none"; // Hide the form
        }

    }

    function addMore7() {

        var html = `
        <div class="row row7">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField7(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore7').append(html);
    }

    function removeField7(btn) {
        $(btn).closest('.row7').remove();
    }
</script>

<!-- 8. Reputation & Background -->
<script>
    const form8 = document.getElementById('form8');
    form8.style.display = 'none';

    function toggleForm8() {
        const checkbox8 = document.getElementById("cb8");
        const form8 = document.getElementById("form8");

        if (checkbox8.checked) {
            form8.style.display = "block"; // Show the form

            form8.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form8.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form8.style.display = "none"; // Hide the form
        }

    }

    function addMore8() {

        var html = `
        <div class="row row8">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField8(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore8').append(html);
    }

    function removeField8(btn) {
        $(btn).closest('.row8').remove();
    }
</script>

<!-- 9. Technology & Security -->
<script>
    const form9 = document.getElementById('form9');
    form9.style.display = 'none';

    function toggleForm9() {
        const checkbox9 = document.getElementById("cb9");
        const form9 = document.getElementById("form9");

        if (checkbox9.checked) {
            form9.style.display = "block"; // Show the form

            form9.style.opacity = 0;
            let opacity = 0;
            const intervalId = setInterval(function() {
                if (opacity >= 1) {
                    clearInterval(intervalId);
                } else {
                    opacity += 0.05;
                    form9.style.opacity = opacity;
                }
            }, 20); // Adjust the interval for speed

        } else {
            form9.style.display = "none"; // Hide the form
        }

    }

    function addMore9() {

        var html = `
        <div class="row row9">
            <div class="col-md-10 mt-3">
                <input type="text" class="form-control" name="eddQs[]" placeholder="Question here please" required>
            </div>
            <div class="col-md-2 mt-3">
                <button type="button" value="" id="addTeamMember" onclick="removeField9(this)" class="btn btn-secondary form-control"><i class="bi bi-person-dash-fill"></i></button>
            </div>
        </div>
        
    `;
        $('.addMore9').append(html);
    }

    function removeField9(btn) {
        $(btn).closest('.row9').remove();
    }
</script>

@endsection

<!-- RK -->