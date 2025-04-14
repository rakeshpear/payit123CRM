@extends('layouts.master')


@section('title')

@lang('KYC Requests')

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

    .statusSpan {
        background-color: yellow !important;
        padding: 5px 10px 3px !important;
        border-radius: 20% !important;
    }

    .docBtn {
        width: 75%;
        align-items: center !important;
        margin: auto !important
    }

    .modalTable {
        text-align: center;
        vertical-align: center;
    }

    .card-img,
    .card-img-top,
    .card-img-bottom {
        width: 10% !important;
    }

    .card-title {
        text-transform: uppercase !important;
        color: blueviolet !important;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) !important;
        transition: transform 0.5s;
    }

    .docHead {
        padding-left: 15px !important;
        font-weight: bold !important;
    }

    .cardAction {
        margin-right: 15px !important;
    }

    .cardAction1 {
        margin-right: 5px !important;
    }

    .card-footer {
        background-color: rgba(85, 110, 230, .25) !important;
    }

    .stageHead {
        margin-bottom: 0em !important;
        color: blue !important;
    }

    .modal-header {
        background-color: antiquewhite !important;
    }

    .cardTitle {
        border-bottom-left-radius: 0% !important;
        border-bottom-right-radius: 0% !important;
        pointer-events: none;
        text-transform: uppercase !important;
        font-size: larger !important;
        letter-spacing: 3px;
    }

    .preKYChead {
        text-transform: uppercase !important;
        text-align: center !important;
        color: red !important;
    }

    .qaDiv {
        font-size: 1rem !important;
    }

    .line {
        width: 100%;
        height: 1px;
        background-color: lightblue !important;
        border: none;
    }


    @media only screen and (min-width: 960px) {
        .card {
            width: 400px !important;
        }
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- select2 css -->
<link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">

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



KYC Requests



@endslot



@slot('title')



KYC Requests



@endslot



@endcomponent

<!-- <div class="row mb-3">

    <div class="col-sm-4"></div>

    <div class="col-sm-8">

        <div class="text-sm-end">

            <a href="{{route('kycrequests.create')}}">
                <button type="button" class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2"><i class="mdi mdi-plus-box"></i> New KYC Request</button>
            </a>

        </div>

    </div>

</div> -->

<div class="row">
    @include('flash_msg')

    <div class="mb-4">
        <h3 class="editPage_h3">KYC Requests Management</span></h3>
    </div>

    <div class="accordion" id="accordionPanelsStayOpenExample">

        <!-- Pre-KYC World Check & Sumsub -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h5 class="stageHead">STAGE 0 : PRE KYC - WORLD CHECK & SUMSUB</h5>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    <!-- New Requests -->

                    <div class="row">
                        <!-- <div class="col-md-1"></div> -->
                        <div class="col-lg-12">
                            <div class="row mt-4">
                                @if($kycLists)
                                @foreach($kycLists as $list)
                                @if($list->status == 'PreKYC' && $list->rejectionFlag !== 1)

                                <div class="col-md-4">
                                    <div class="card-deck">
                                        <div class="card">
                                            <button type="button" class="btn btn-dark position-relative cardTitle">
                                                {{$list->userName->client_type == 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . ' ' . $list->userName->last_name}}

                                                @if($list->status == 'PreKYC')
                                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                                    NEW
                                                </span>
                                                @endif
                                            </button>

                                            <!-- <img class="card-img-top" src="{{asset('/images/profile.png')}}" alt="Card image cap"> -->
                                            <div class="card-body">
                                                <h5><label>Status : <span class="badge bg-sm bg-primary">{{$list->status}}</span></label></h5>
                                                <p class="card-text">{{$list->userName->email}} | {{$list->userName->website}}</p>

                                                <table class="table">
                                                    <!-- passport -->
                                                    <tr>
                                                        <td>
                                                            <a href="{{url($list->userName->passport)}}" role="button" class="btn btn-sm btn-info {{$list->userName->passport_status === null ? 'animate__animated animate__slow animate__tada animate__repeat-3' : '' }}" target="_blank">Passport</a>
                                                            @if($list->userName->passport_status === null)
                                                            <small id="textHelp" class="form-text text-muted">N/A</small>
                                                            @elseif($list->userName->passport_status === 0)
                                                            <small id="textHelp" class="form-text  text-danger">Rejected</small>
                                                            @elseif($list->userName->passport_status === 1)
                                                            <small id="textHelp" class="form-text  text-success">Approved</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('kycrequests.passportApprove', encrypt($list->clientId))}}" role="button" class="btn btn-sm btn-success"><i class="bi bi-check"></i></a>
                                                        </td>
                                                        <td>
                                                            <!-- Passport Rejection modal -->
                                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#passportRejectModal{{$list->id}}">
                                                                <i class="bi bi-x-lg"></i>
                                                            </button>

                                                            <!-- Passport Rejection modal -->
                                                            <div class="modal fade" id="passportRejectModal{{$list->id}}" tabindex="-1" aria-labelledby="passportRejectModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Reject Passport?</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{route('kycrequests.passportReject', encrypt($list->clientId))}}" method="post">
                                                                                @csrf
                                                                                <div class="mb-3">
                                                                                    <label for="rejectReason" class="form-label">Rejection Reason</label>
                                                                                    <input type="text" class="form-control" name="rejectReason" id="rejectReason" placeholder="Please state the reason">
                                                                                </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="sumbit" class="btn btn-danger">Reject</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <!-- <a href="{{route('kycrequests.passportReject', encrypt($list->clientId))}}" role="button" class="btn btn-sm btn-danger"></a> -->
                                                        </td>
                                                        <td>
                                                            @if($list->userName->passport_status === 0)
                                                            @if($list->userName->passport_mail_sent_status === 0)
                                                            <a href="{{route('kycrequests.passportReask', encrypt($list->clientId))}}" role="button" class="btn btn-sm btn-danger animate__animated animate__slow animate__tada animate__repeat-3 ">Re-Ask</a>
                                                            @else
                                                            <a href="{{route('kycrequests.passportReask', encrypt($list->clientId))}}" role="button" class="btn btn-sm btn-secondary">Re-Ask</a>
                                                            @endif
                                                            @else
                                                            <a href="" role="button" class="btn btn-sm btn-secondary disabled">Re-Ask</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                                <h6 style="font-weight:bold !important">Pre-KYC PROCESS</h6>

                                                @if($list->userName->passport_status == 1)
                                                <!-- PreKYC Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-primary position-relative {{$list->userName->prekycclarification_status === 'Response Received' ? 'animate__animated animate__slow animate__flash animate__repeat-3' : ''}} " data-bs-toggle="modal" data-bs-target="#preKycModal{{$list->id}}">
                                                    Pre-KYC Process
                                                </button>
                                                @else
                                                <!-- PreKYC Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Please approve Passport to proceed further">
                                                    Pre-KYC Process
                                                </button>
                                                @endif


                                                <!-- PreKYC Modal -->
                                                <div class="modal fade" id="preKycModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="preKycModal{{$list->id}}">Pre-KYC Process - {{$list->userName->client_type == 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . ' ' . $list->userName->last_name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table ">
                                                                    <tr>
                                                                        <td>Process</td>
                                                                        <td>Status</td>
                                                                        <td>Approve</td>
                                                                        <td>Reject</td>
                                                                    </tr>
                                                                    <!-- World Check -->
                                                                    <tr>
                                                                        <td>
                                                                            WORLD CHECK
                                                                        </td>
                                                                        <td>
                                                                            @if($list->worldCheck === null)
                                                                            N/A
                                                                            @elseif($list->worldCheck == 0)
                                                                            <span style="color: red !important;">Rejected</span>
                                                                            @elseif($list->worldCheck == 1)
                                                                            <span style="color: green !important;">Approved</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.worldCheckApprove',encrypt($list->id))}}" class="btn btn-sm btn-success cardAction"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.worldCheckDecline',encrypt($list->id))}}" class="btn btn-sm btn-danger cardAction"><i class="bi bi-x-lg"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- SumSub -->
                                                                    <tr>
                                                                        <td>
                                                                            SUMSUB
                                                                        </td>
                                                                        <td>
                                                                            @if($list->sumSub === null)
                                                                            N/A
                                                                            @elseif($list->sumSub == 0)
                                                                            <span style="color: red !important;">Rejected</span>
                                                                            @elseif($list->sumSub == 1)
                                                                            <span style="color: green !important;">Approved</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.sumsubApprove',encrypt($list->id))}}" class="btn btn-sm btn-success cardAction"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.sumsubDecline',encrypt($list->id))}}" class="btn btn-sm btn-danger cardAction"><i class="bi bi-x-lg"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                @if($list->worldCheck === 0 || $list->sumSub === 0)


                                                                <h5 class="preKYChead mb-3">Additional Clarifications on Pre-KYC from Client</h5>

                                                                <form action="{{route('kycrequesets.preKycClarification', $list->id)}}" method="post" class="mb-3">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="clarificationQs">Clarification needs on ?</label>
                                                                        <textarea type="text" class="form-control" id="clarificationQs" style="white-space: pre-wrap;" name="clarificationQs" aria-describedby="qsText" rows="3" placeholder="Clarification needs on ?" required></textarea>
                                                                        <small id="qsText" class="form-text text-muted mt-1">Please specify the clarification we needs from the Client here.</small>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Add Query</button>
                                                                </form>

                                                                @endif

                                                                <h5 class="preKYChead mb-3">Clarifications & Responses</h5>

                                                                @if($prekycqs)
                                                                <div class="mt-3 qaDiv">
                                                                    @foreach($prekycqs as $qs)
                                                                    @if($qs->kyc_ID == $list->id)
                                                                    <div class="question mt-3 mb-2"><span>Q :</span> {{$qs->question}} <span class="badge {{$qs->status == 'Open' ? 'bg-danger' : 'bg-success'}}">{{$qs->status}}</span>

                                                                    </div>
                                                                    @if($qs->response !== null)
                                                                    <div class="answer mt-2 mb-2"><span>R :</span> {{$qs->response}}</div>
                                                                    @else
                                                                    <div class="answer"><span>R :</span> Yet to receive.</div>
                                                                    @endif
                                                                    @endif
                                                                    <div class="line"></div>
                                                                    @endforeach


                                                                </div>

                                                                @if(($list->worldCheck === 0 || $list->sumSub === 0) && $list->userName->prekycclarification_status == "Query Initiated")
                                                                <a type="button" href="{{route('sendPrekycResponseLink.mail' , encrypt($list->userName->id))}}" class="btn btn-sm btn-warning mt-3 animate__animated animate__slow animate__tada animate__repeat-3">Ask for Clarification</a>
                                                                @else
                                                                <a type="button" href="#" class="btn btn-sm btn-secondary disabled mt-3">Ask for Clarification</a>
                                                                @endif


                                                                @endif

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                @if($list->sumSub === 1 && $list->worldCheck === 1 && $list->userName->passport_status == 1)
                                                <!-- Proceed to KYC modal -->
                                                <button type="button" class="btn btn-sm btn-info float-end animate__animated animate__tada animate__repeat-3" data-bs-toggle="modal" data-bs-target="#clientModal_{{$list->id}}">
                                                    Proceed to KYC
                                                </button>
                                                @else
                                                <button type="button" class="btn btn-sm btn-secondary float-end disabled" data-bs-toggle="modal">
                                                    Proceed to KYC
                                                </button>
                                                @endif

                                                <!-- Proceed to KYC Modal -->
                                                <div class="modal fade" id="clientModal_{{$list->id}}" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="clientModalLabel">Pre KYC - {{$list->userName->client_type == 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . ' ' . $list->userName->last_name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to proceed with this Clients' KYC Process?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a href="{{route('kycrequests.preKYCapproval',encrypt($list->id))}}" type="button" class="btn btn-success btn-sm">Proceed KYC</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <small class="text-muted">Last Updatd at {{$list->updated_at->todatestring()}}</small>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" style="position:absolute; bottom:0; right:0" data-bs-toggle="modal" data-bs-target="#rejectModal{{$list->id}}">
                                                    Reject Client</i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="rejectLabel">Reject Client - {{($list->userName->client_type === 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . " " . $list->userName->last_name )}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to reject the Client?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a type="button" class="btn btn-danger" href="{{route('kycrequests.rejectClient', encrypt($list->id))}}">Reject Client</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>

                                    </div>
                                </div>

                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1"></div> -->
            </div>
        </div>

        <!-- KYC New / Pending Requests -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <h5 class="stageHead">STAGE 1 : KYC - NEW / PENDING REQUESTS</h5>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    <!-- New / Pending Requests -->

                    <div class="row">
                        <!-- <div class="col-md-1"></div> -->
                        <div class="col-lg-12">
                            <div class="row mt-4">
                                @if($kycLists)
                                @foreach($kycLists as $list)
                                @if(($list->status == 'Pending' || $list->status == 'New' || $list->status == 'newKYCPending') && $list->rejectionFlag !== 1)
                                @if($list->sumSub == 1 && $list->worldCheck == 1)
                                <div class="col-md-4">
                                    <div class="card-deck">
                                        <div class="card">
                                            <button type="button" class="btn btn-primary position-relative cardTitle">
                                                {{$list->userName->client_type == 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . ' ' . $list->userName->last_name}}

                                                @if($list->status == 'New')
                                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                                    NEW
                                                </span>
                                                @endif
                                            </button>

                                            <!-- <img class="card-img-top" src="{{asset('/images/profile.png')}}" alt="Card image cap"> -->
                                            <div class="card-body">
                                                <h5><label>Status : <span class="badge bg-sm bg-primary">{{$list->status}}</span></label></h5>
                                                <p class="card-text">{{$list->userName->email}} | {{$list->userName->website}}</p>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <h6 class="docHead">Recent Replies</h6>

                                                <li class="list-group-item">{{$list->comments}}</li>



                                            </ul>
                                            <div class="card-body">
                                                <h6 style="font-weight:bold !important">KYC PROCESS</h6>


                                                @if($list->status == 'New' || $list->status == 'newKYCPending')
                                                @if($list->first_mail_sent == 0)
                                                <a href="{{route('NewKYCMail.mail',encrypt($list->id))}}" class="btn btn-sm btn-primary cardAction animate__animated animate__slow animate__tada animate__repeat-3">Initiate KYC</a>
                                                @else
                                                <a href="{{route('NewKYCMail.mail',encrypt($list->id))}}" class="btn btn-sm btn-secondary cardAction">Resend KYC</a>
                                                @endif
                                                @else
                                                <a class="btn btn-sm btn-secondary disabled cardAction">Resend KYC</a>
                                                @endif

                                                @if($list->status !== 'newKYCPending' && $list->status !== 'New' )

                                                @if($list->first_mail_sent)
                                                <a href="{{route('send.mail',$list->id)}}" class="btn btn-sm btn-secondary cardAction">Resend</a>
                                                @else
                                                <a href="{{route('send.mail',$list->id)}}" class="btn btn-sm btn-danger cardAction  animate__animated animate__slow animate__tada animate__repeat-3">Inform</a>
                                                @endif
                                                <!--<a href="#" class="btn btn-sm btn-secondary disabled cardAction">Inform</a>-->
                                                
                                                
                                                @else
                                                <a href="#" class="btn btn-sm btn-secondary disabled cardAction">Inform</a>
                                                @endif

                                                <!-- <a href="{{route('kycrequests.view', encrypt($list->id))}}" class="btn btn-sm btn-info cardAction"><i class="bi bi-eye"></i></a> -->

                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">Last Updatd at {{$list->updated_at->todatestring()}}</small>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" style="position:absolute; bottom:0; right:0" data-bs-toggle="modal" data-bs-target="#rejectModal{{$list->id}}">
                                                    Reject Client</i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="rejectLabel">Reject Client - {{($list->userName->client_type === 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . " " . $list->userName->last_name )}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to reject the Client?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a type="button" class="btn btn-danger" href="{{route('kycrequests.rejectClient', encrypt($list->id))}}">Reject Client</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Close Request Modal -->


                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1"></div> -->
            </div>
        </div>

        <!-- KYCs in Review -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    <h5 class="stageHead">STAGE 2 : KYC - REQUESTS IN REVIEW</h5>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    <!-- Open Requests -->

                    <div class="row">
                        <!-- <div class="col-md-1"></div> -->
                        <div class="col-lg-12">
                            <div class="row mt-4">
                                @if($kycLists)
                                @foreach($kycLists as $list)
                                @if($list->status == 'Files Received' && $list->rejectionFlag !== 1)

                                <div class="col-md-4">
                                    <div class="card-deck">
                                        <div class="card">
                                            <button type="button" class="btn btn-info position-relative" style="pointer-events: none; text-transform:uppercase !important; font-size:larger !important; letter-spacing: 3px;">
                                                {{$list->userName->client_type == 'Individual' ? $list->userName->first_name . ' ' . $list->userName->last_name :   $list->userName->company_name}}
                                            </button>

                                            <div class="card-body">
                                                <h5><label>Status : <span class="badge bg-sm bg-success">{{$list->status}}</span></label></h5>
                                                <p class="card-text">{{$list->userName->email}} | {{$list->userName->website}}</p>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <h6 class="docHead">Recent Replies</h6>

                                                <li class="list-group-item">{{$list->comments}}</li>



                                            </ul>
                                            <div class="card-body">
                                                <h6 style="font-weight:bold !important">KYC PROCESS</h6>

                                                <a type="button" class="btn btn-sm btn-info cardAction1 {{$list->status == 'Files Received' ? 'animate__animated animate__tada animate__repeat-3' : '' }}" id="docModal" data-bs-toggle="modal" data-bs-target="#docModal{{$list->id}}">
                                                    Documents
                                                </a>

                                                <!-- Check if all the documents are viewed and either approved or rejected -->
                                                @if($list->nationalID_status === null || $list->license_status === null || $list->otherID_status === null
                                                || $list->utilityBill_status === null || $list->bankStatement_status === null || $list->leaseAgreement_status === null ||
                                                $list->incorporation_status === null || $list->shareHolding_status === null || $list->coro_status === null || $list->processing_status === null
                                                || $list->refund_status === null)

                                                <a href="#" type="button" class="btn btn-sm btn-secondary disabled cardAction1">Mark Pending</a>

                                                <!-- If all the documents are viewed and all of them are approved -->
                                                @elseif($list->nationalID_status === 1 && $list->license_status === 1 && $list->otherID_status === 1 &&
                                                $list->utilityBill_status === 1 && $list->bankStatement_status === 1 && $list->leaseAgreement_status === 1 &&
                                                $list->incorporation_status === 1 && $list->shareHolding_status === 1 && $list->coro_status === 1 && $list->processing_status === 1 &&
                                                $list->refund_status === 1)

                                                <a href="#" type="button cardAction1" class="btn btn-sm btn-secondary disabled">Mark Pending</a>

                                                <!-- If any of the documents are rejected -->

                                                @elseif($list->nationalID_status === 0 || $list->license_status === 0 || $list->otherID_status === 0
                                                || $list->utilityBill_status === 0 || $list->bankStatement_status === 0 || $list->leaseAgreement_status === 0 ||
                                                $list->incorporation_status === 0 || $list->shareHolding_status === 0 || $list->coro_status === 0 || $list->processing_status === 0
                                                || $list->refund_status === 0)

                                                <a href="{{route('kycrequests.intimateClient', encrypt($list->id) )}}" type="button cardAction1" class="btn btn-sm btn-danger animate__animated animate__slow animate__tada animate__repeat-3">Mark Pending</a>

                                                @endif

                                                @if($list->nationalID_status === 1 && $list->license_status === 1 && $list->otherID_status === 1 &&
                                                $list->utilityBill_status === 1 && $list->bankStatement_status === 1 && $list->leaseAgreement_status === 1 &&
                                                $list->incorporation_status === 1 && $list->shareHolding_status === 1 && $list->coro_status === 1 && $list->processing_status === 1 &&
                                                $list->refund_status === 1)
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-success cardAction1 animate__animated animate__slow animate__tada animate__repeat-3" data-bs-toggle="modal" data-bs-target="#closeRequestModal{{$list->id}}">
                                                    Close Request
                                                </button>
                                                @else
                                                <a href="#" class="btn btn-sm btn-secondary disabled cardAction1">Close Request</a>
                                                @endif

                                                <a href="{{route('kycrequests.view', encrypt($list->id))}}" class="btn btn-sm btn-info cardAction1"><i class="bi bi-eye"></i></a>

                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">Last Updatd at {{$list->updated_at->todatestring()}}</small>

                                                <!-- Reject modal -->
                                                <button type="button" class="btn btn-danger" style="position:absolute; bottom:0; right:0" data-bs-toggle="modal" data-bs-target="#rejectModal{{$list->id}}">
                                                    Reject Client</i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="rejectLabel">Reject Client - {{($list->userName->client_type === 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . " " . $list->userName->last_name )}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to reject the Client?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a type="button" class="btn btn-danger" href="{{route('kycrequests.rejectClient', encrypt($list->id))}}">Reject Client</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Doc Modal -->
                                            <div class="modal docModal fade" id="docModal{{$list->id}}" tabindex="-1" aria-labelledby="docModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" style="max-width: 900px !important;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Documents of {{$list->userName->company_name}}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5 style="text-align: center !important;" class="mb-3">Personal ID Documents</h5>
                                                            <table class="table modalTable mb-5">
                                                                <tbody class="justify-content-center">
                                                                    <tr>
                                                                        <td>Documents</td>
                                                                        <td>Issue Date</td>
                                                                        <td>Expiry Date</td>
                                                                        <td>Status</td>
                                                                        <td>Approve</td>
                                                                        <td>Reject</td>
                                                                    </tr>
                                                                    <!-- Passport -->
                                                                    <!-- <tr>
                                                                        <td>
                                                                            @if($list->passportt)
                                                                            <a href="{{url($list->passportt)}}" target="_blank" type="button" class="btn btn-primary docBtn">Passport</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Passport</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->passportIssue}}</td>
                                                                        <td>{{$list->passportExpiry}}</td>
                                                                        <td>
                                                                            @if($list->passportt === NULL && $list->passportt_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->passportt === NULL && $list->passportt_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->passportt_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->passportt_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'passportt_status', 'passportt_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="passportt_status">
                                                                                <input type="hidden" name="docReasonName" value="passportt_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr> -->
                                                                    <!-- National ID Card -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->nationalID)
                                                                            <a href="{{url($list->nationalID)}}" target="_blank" type="button" class="btn btn-primary docBtn">National ID</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">National ID</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->nationalIDIssue}}</td>
                                                                        <td>{{$list->nationalIDExpiry}}</td>
                                                                        <td>
                                                                            @if($list->nationalID === NULL && $list->nationalID_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->nationalID === NULL && $list->nationalID_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->nationalID_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->nationalID_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove',[encrypt($list->id), 'nationalID_status', 'nationalID_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="nationalID_status">
                                                                                <input type="hidden" name="docReasonName" value="nationalID_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Driving License -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->license)
                                                                            <a href="{{url($list->license)}}" target="_blank" type="button" class="btn btn-primary docBtn">Driving License</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Driving License</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->licenseIssue}}</td>
                                                                        <td>{{$list->licenseExpiry}}</td>
                                                                        <td>
                                                                            @if($list->license === NULL && $list->license_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->license === NULL && $list->license_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->license_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->license_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'license_status', 'license_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="license_status">
                                                                                <input type="hidden" name="docReasonName" value="license_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Other IDs -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->otherID)
                                                                            <a href="{{url($list->otherID)}}" target="_blank" type="button" class="btn btn-primary docBtn">Other IDs</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Other IDs</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>
                                                                            @if($list->otherID === NULL && $list->otherID_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->otherID === NULL && $list->otherID_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->otherID_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->otherID_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'otherID_status', 'otherID_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="otherID_status">
                                                                                <input type="hidden" name="docReasonName" value="otherID_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Utility Bill -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->utilityBill)
                                                                            <a href="{{url($list->utilityBill)}}" target="_blank" type="button" class="btn btn-primary docBtn">Utility Bill</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Utility Bill</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->utilityBillIssue}}</td>
                                                                        <td>-</td>
                                                                        <td>
                                                                            @if($list->utilityBill === NULL && $list->utilityBill_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->utilityBill === NULL && $list->utilityBill_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->utilityBill_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->utilityBill_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove',[encrypt($list->id), 'utilityBill_status', 'utilityBill_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="utilityBill_status">
                                                                                <input type="hidden" name="docReasonName" value="utilityBill_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Bank Statement -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->bankStatement)
                                                                            <a href="{{url($list->bankStatement)}}" target="_blank" type="button" class="btn btn-primary docBtn">Bank Statement</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Bank Statement</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->bankStatementIssue}}</td>
                                                                        <td>-</td>
                                                                        <td>
                                                                            @if($list->bankStatement === NULL && $list->bankStatement_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->bankStatement === NULL && $list->bankStatement_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->bankStatement_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->bankStatement_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'bankStatement_status', 'bankStatement_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="bankStatement_status">
                                                                                <input type="hidden" name="docReasonName" value="bankStatement_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Lease Agreement -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->leaseAgreement)
                                                                            <a href="{{url($list->leaseAgreement)}}" target="_blank" type="button" class="btn btn-primary docBtn">Lease Agreement</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Lease Agreement</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->leaseAgreementIssue}}</td>
                                                                        <td>-</td>
                                                                        <td>
                                                                            @if($list->leaseAgreement === NULL && $list->leaseAgreement_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->leaseAgreement === NULL && $list->leaseAgreement_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->leaseAgreement_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->leaseAgreement_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'leaseAgreement_status', 'leaseAgreement_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="leaseAgreement_status">
                                                                                <input type="hidden" name="docReasonName" value="leaseAgreement_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>

                                                            <h5 style="text-align: center !important;" class="mb-3">Company Documents</h5>
                                                            <table class="table modalTable">
                                                                <tbody class="justify-content-center">
                                                                    <tr>
                                                                        <td>Documents</td>
                                                                        <td>Status</td>
                                                                        <td>Approve/Reject</td>
                                                                        <td>Reason</td>
                                                                    </tr>
                                                                    <!-- Certificate of Incorporation -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->incorporation)
                                                                            <a href="{{url($list->incorporation)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Incorporation</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Incorporation</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($list->incorporation === NULL && $list->incorporation_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->incorporation === NULL && $list->incorporation_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->incorporation_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->incorporation_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'incorporation_status', 'incorporation_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="incorporation_status">
                                                                                <input type="hidden" name="docReasonName" value="incorporation_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- ShareHolding -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->shareHolding)
                                                                            <a href="{{url($list->shareHolding)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Share Holding</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Share Holding</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($list->shareHolding === NULL && $list->shareHolding_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->shareHolding === NULL && $list->cosh_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->shareHolding_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->shareHolding_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'shareHolding_status', 'shareHolding_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="shareHolding_status">
                                                                                <input type="hidden" name="docReasonName" value="shareHolding_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- CORO -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->coro)
                                                                            <a href="{{url($list->coro)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Registered Office</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Registered Office</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($list->coro === NULL && $list->coro_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->coro === NULL && $list->coro_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->coro_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->coro_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'coro_status', 'coro_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="coro_status">
                                                                                <input type="hidden" name="docReasonName" value="coro_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- 6 Months Processing History -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->processing)
                                                                            <a href="{{url($list->processing)}}" target="_blank" type="button" class="btn btn-primary docBtn">Six Month Processing History</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Six Month Processing History</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($list->processing === NULL && $list->processing_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->processing === NULL && $list->processing_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->processing_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->processing_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'processing_status', 'processing_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="processing_status">
                                                                                <input type="hidden" name="docReasonName" value="processing_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- 6 Months Refund History -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->refund)
                                                                            <a href="{{url($list->refund)}}" target="_blank" type="button" class="btn btn-primary docBtn">Six Month Refund History</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Six Month Refund History</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($list->refund === NULL && $list->refund_status === NULL)
                                                                            <h4><span class="badge bg-secondary">Not Uploaded</span></h4>
                                                                            @elseif($list->refund === NULL && $list->refund_status === 0)
                                                                            <h4><span class="badge bg-secondary">Rejected</span></h4>
                                                                            @elseif($list->refund_status === Null)
                                                                            <h4><span class="badge bg-secondary">New</span></h4>
                                                                            @elseif($list->refund_status === 0)
                                                                            <h4><span class="badge bg-danger">Rejected</span></h4>
                                                                            @else <h4><span class="badge bg-success">Approved</span></h4>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{route('kycrequests.docApprove', [encrypt($list->id), 'refund_status', 'refund_reason'])}}" role="button" class="btn btn-success"><i class="bi bi-check"></i></a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{route('kycrequests.docReject', encrypt($list->id))}}" method="post" style="float: right !important;">
                                                                                @csrf
                                                                                <input type="hidden" name="docName" value="refund_status">
                                                                                <input type="hidden" name="docReasonName" value="refund_reason">
                                                                                <input type="text" class="form-control" style="width:80% !important; float:left !important;" name="reason" id="reason" placeholder="Reason" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please mention the reason')"><button role="button" class="btn btn-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Close Modal -->

                                            <div class="modal fade" id="closeRequestModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="closeRequestModal{{$list->id}}">Close Request</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            All files received ? Are you sure to close this request ? <br>
                                                            If so, please mention if the Client comes with High Risk Level or not.
                                                            <a href="{{route('kycrequests.closeWithLowRisk',$list->id)}}" class="btn btn-success mt-3">Mark Low/Medium RisK & Close Request</a>
                                                            <a href="{{route('kycrequests.closeWithHighRisk',$list->id)}}" class="btn btn-danger mt-3">Mark High RisK & Close Request</a>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1"></div> -->
            </div>
        </div>

        <!-- KYC Risk Assesment -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    <h5 class="stageHead">STAGE 3 : KYC - RISK ASSESSMENT</h5>
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    <div class="row">
                        <!-- <div class="col-md-1"></div> -->
                        <div class="col-lg-12">

                            <div class="row mt-4">
                                <!-- <div class="col-md-12"> -->
                                @if($kycLists)
                                @foreach($kycLists as $list)
                                @if($list->rejectionFlag !== 1)
                                @if($list->status == 'Closed' && $list->riskFactor == 1 || $list->status == 'EDD Completed' || $list->status == 'EDD Approved' || $list->status == 'EDD Queries Raised' || $list->status == 'EDD Response Received' && $list->riskFactor == 1)

                                <div class="col-md-4">
                                    <div class="card-deck">
                                        <div class="card">
                                            <button type="button" class="btn btn-danger position-relative" style="pointer-events: none; text-transform:uppercase !important; font-size:larger !important; letter-spacing: 3px;">
                                                {{ $list->userName->client_type == "Individual" ?  $list->userName->first_name . ' ' . $list->userName->last_name : $list->userName->company_name}}
                                            </button>
                                            <div class="card-body">
                                                <h5><label>Status : <span class="badge bg-sm bg-success">{{($list->status == 'Closed') ? 'Docs Verified' : $list->status}}</span></label></h5>
                                                <p class="card-text">{{$list->userName->email}} | {{$list->userName->website}}</p>

                                                <a type="button" class="btn btn-sm btn-secondary cardAction mb-3" href="{{route('kycrequests.riskFactorToggle',encrypt($list->id)) }}">Revert High Risk?</a>

                                                @if($list->status !== 'EDD Completed' && $list->status !== 'EDD Response Received')

                                                @if($list->first_mail_sent == 0)
                                                <a type="button" class="btn btn-sm btn-warning cardAction mb-3 animate__animated animate__slow animate__tada animate__repeat-3" href="{{route('SendEDDMail.mail',encrypt($list->id)) }}">Send EDD Link</a>
                                                @elseif($list->first_mail_sent == 1)
                                                <a type="button" class="btn btn-sm btn-secondary cardAction mb-3" href="{{route('SendEDDMail.mail',encrypt($list->id)) }}">Resend EDD Link</a>
                                                @endif

                                                @else
                                                <a type="button" class="btn btn-sm btn-secondary cardAction mb-3 disabled">Resend EDD Link</a>
                                                @endif

                                                @if($list->status === 'EDD Completed' || $list->status === 'EDD Response Received')
                                                <a type="button" class="btn btn-sm btn-warning cardAction mb-3 animate__animated animate__slow animate__tada animate__repeat-3" href="{{route('kycrequests.viewEDD',encrypt($list->id)) }}">View EDD Reply</a>
                                                @elseif($list->status === 'EDD Queries Raised')
                                                <a type="button" class="btn btn-sm btn-warning cardAction mb-3" href="{{route('kycrequests.viewEDD',encrypt($list->id)) }}">View EDD Reply</a>
                                                @endif

                                                @if($list->status === 'EDD Approved')

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-success cardAction mb-3  animate__animated animate__slow animate__tada animate__repeat-3" data-bs-toggle="modal" data-bs-target="#riskApproveModal{{$list->id}}">
                                                    Approve Risk?
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="riskApproveModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Risk - {{ $list->client_type == "Individual" ?  $list->userName->first_name . ' ' . $list->userName->last_name : $list->userName->company_name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to approve the risk of this Client?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a type="button" class="btn btn-sm btn-success" href="{{route('kycrequests.riskFactorToggle',encrypt($list->id)) }}">Approve Risk</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @else
                                                <a type="button" class="btn btn-sm btn-secondary cardAction mb-3 disabled">Approve Risk</a>
                                                @endif

                                                <a type="button" class="btn btn-sm btn-info cardAction mb-3" data-bs-toggle="modal" data-bs-target="#docModal{{$list->id}}">Documents</a>

                                                <a href="{{route('kycrequests.view', encrypt($list->id))}}" type="button" class="btn btn-sm btn-info cardAction mb-3"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">Last Updatd at {{$list->updated_at->todatestring()}}</small>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" style="position:absolute; bottom:0; right:0" data-bs-toggle="modal" data-bs-target="#rejectModal{{$list->id}}">
                                                    Reject Client</i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="rejectLabel">Reject Client - {{($list->userName->client_type === 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . " " . $list->userName->last_name )}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to reject the Client?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a type="button" class="btn btn-danger" href="{{route('kycrequests.rejectClient', encrypt($list->id))}}">Reject Client</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                            <!-- Doc Modal -->
                                            <div class="modal fade" id="docModal{{$list->id}}" tabindex="-1" aria-labelledby="docModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Documents of {{$list->userName->company_name}}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body d-flex">
                                                            <table class="table modalTable mb-5">
                                                                <tbody class="justify-content-center">
                                                                    <tr>
                                                                        <td>Documents</td>
                                                                        <td>Issue Date</td>
                                                                        <td>Expiry Date</td>
                                                                    </tr>
                                                                    <!-- Passport -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->userName->passport)
                                                                            <a href="{{url($list->userName->passport)}}" target="_blank" type="button" class="btn btn-primary docBtn">Passport</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Passport</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->passportIssue}}</td>
                                                                        <td>{{$list->passportExpiry}}</td>

                                                                    </tr>
                                                                    <!-- National ID Card -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->nationalID)
                                                                            <a href="{{url($list->nationalID)}}" target="_blank" type="button" class="btn btn-primary docBtn">National ID</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">National ID</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->nationalIDIssue}}</td>
                                                                        <td>{{$list->nationalIDExpiry}}</td>

                                                                    </tr>
                                                                    <!-- Driving License -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->license)
                                                                            <a href="{{url($list->license)}}" target="_blank" type="button" class="btn btn-primary docBtn">Driving License</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Driving License</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->licenseIssue}}</td>
                                                                        <td>{{$list->licenseExpiry}}</td>

                                                                    </tr>
                                                                    <!-- Other IDs -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->otherID)
                                                                            <a href="{{url($list->otherID)}}" target="_blank" type="button" class="btn btn-primary docBtn">Other IDs</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Other IDs</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>

                                                                    </tr>
                                                                    <!-- Utility Bill -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->utilityBill)
                                                                            <a href="{{url($list->utilityBill)}}" target="_blank" type="button" class="btn btn-primary docBtn">Utility Bill</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Utility Bill</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->utilityBillIssue}}</td>
                                                                        <td>-</td>

                                                                    </tr>
                                                                    <!-- Bank Statement -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->bankStatement)
                                                                            <a href="{{url($list->bankStatement)}}" target="_blank" type="button" class="btn btn-primary docBtn">Bank Statement</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Bank Statement</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->bankStatementIssue}}</td>
                                                                        <td>-</td>

                                                                    </tr>
                                                                    <!-- Lease Agreement -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->leaseAgreement)
                                                                            <a href="{{url($list->leaseAgreement)}}" target="_blank" type="button" class="btn btn-primary docBtn">Lease Agreement</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Lease Agreement</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->leaseAgreementIssue}}</td>
                                                                        <td>-</td>



                                                                    </tr>

                                                                    <!-- Certificate of Incorporation -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->incorporation)
                                                                            <a href="{{url($list->incorporation)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Incorporation</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Incorporation</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- Certificate of Share Holding -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->shareHolding)
                                                                            <a href="{{url($list->shareHolding)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Share Holding</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Share Holding</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- Certificate of Registered Office -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->coro)
                                                                            <a href="{{url($list->coro)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Registered Office</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Registered Office</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- 6 Months Processing History -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->processing)
                                                                            <a href="{{url($list->processing)}}" target="_blank" type="button" class="btn btn-primary docBtn">Six Months Processing History</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Six Months Processing History</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- 6 Months Refund History -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->refund)
                                                                            <a href="{{url($list->refund)}}" target="_blank" type="button" class="btn btn-primary docBtn">Six Months Refund History</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Six Months Refund History</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contract Upload Modal -->
                                            <div class="modal fade" id="exampleModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Contract </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('sendContract.mail', $list->id)}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Contract File Upload</label>
                                                                    <input class="form-control" type="file" name="contractFile" id="contractFile" required>
                                                                </div>
                                                                @error('contractFile')
                                                                <div class="alertMessage">{{ $message }}</div>
                                                                @enderror
                                                                <div class="mb-3">
                                                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-danger" style="position:absolute; bottom:0; right:0" data-bs-toggle="modal" data-bs-target="#rejectModal{{$list->id}}">
                                                                Reject Client</i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="rejectModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="rejectLabel">Reject Client - {{($list->userName->client_type === 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . " " . $list->userName->last_name )}}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure to reject the Client?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <a type="button" class="btn btn-danger" href="{{route('kycrequests.rejectClient', encrypt($list->id))}}">Reject Client</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--Client Approval Modal -->
                                            <div class="modal fade" id="approveModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Client</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Contracts Signed ? Are you sure to approve the client ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{route('kycrequests.approve',$list->id)}}" class="btn btn-sm btn-success">Approve</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endif
                                @endforeach
                                @endif
                                <!-- </div> -->
                            </div>
                        </div>
                        <!-- <div class="col-md-1"></div> -->
                    </div>

                </div>
            </div>
        </div>

        <!-- KYC Closed Requests -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                    <h5 class="stageHead">STAGE 4 : KYC - CONTRACT SIGNING</h5>
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    <div class="row">
                        <!-- <div class="col-md-1"></div> -->
                        <div class="col-lg-12">

                            <div class="row mt-4">
                                <!-- <div class="col-md-12"> -->
                                @if($kycLists)
                                @foreach($kycLists as $list)
                                @if($list->rejectionFlag !== 1)
                                @if($list->riskFactor == 0 && ($list->status == 'Closed' || $list->status == 'Approved' || $list->status == 'Signed'))

                                <div class="col-md-4">
                                    <div class="card-deck">
                                        <div class="card">
                                            <button type="button" class="btn btn-success position-relative" style="pointer-events: none; text-transform:uppercase !important; font-size:larger !important; letter-spacing: 3px;">
                                                {{$list->userName->client_type == 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . ' ' . $list->userName->last_name}}
                                            </button>
                                            <div class="card-body">
                                                <h5><label>Status : <span class="badge bg-sm bg-success">{{($list->status == 'Closed') ? 'Docs Verified' : 'Approved'}}</span></label></h5>
                                                <p class="card-text">{{$list->userName->email}} | {{$list->userName->website}}</p>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <h6 class="docHead">Comments from Clients</h6>
                                                <li class="list-group-item">
                                                    @if($list->contract_comment_flag==1)
                                                    <p class="animate__animated animate__slow animate__flash animate__repeat-3">{{$list->contract_comments}}</p>
                                                    @else
                                                    <p>{{$list->contract_comments}}</p>
                                                    @endif

                                                </li>
                                            </ul>
                                            <div class="card-body">



                                                <h6>Action</h6>
                                                <!-- <h6>Actions</h6> -->

                                                @if($list->riskFactor == 0 && $list->eddStatus !== 'Verified' && $list->status !== 'Approved')
                                                <a type="button" class="btn btn-sm btn-danger cardAction mb-3" href="{{route('kycrequests.closeWithHighRisk',$list->id) }}">High Risk Client?</a>
                                                @endif

                                                <a type="button" class="btn btn-sm btn-info cardAction mb-3" data-bs-toggle="modal" data-bs-target="#docModal{{$list->id}}">
                                                    Documents
                                                </a>


                                                <!-- To Send Contract Document to Client -->
                                                @if(!($list->status == 'Signed' || $list->status == 'Approved'))

                                                @if($list->contract_status == null)
                                                <button type="button" class="btn btn-sm btn-primary cardAction mb-3 animate__animated animate__slow animate__flash animate__repeat-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{$list->id}}">
                                                    Send Contract
                                                </button>
                                                @elseif(($list->contract_status == 'Sent'))
                                                <button type="button" class="btn btn-sm btn-secondary cardAction mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{$list->id}}">
                                                    Resend Contract
                                                </button>
                                                @endif

                                                @elseif ($list->status == 'Approved' || $list->status == 'Signed' )
                                                <button type="button" class="btn btn-sm btn-secondary disabled cardAction mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{$list->id}}">
                                                    Send Contract
                                                </button>
                                                @endif

                                                @if($list->contract)
                                                <a href="{{url($list->contract)}}" target="_blank" type="button" class="btn btn-sm btn-warning cardAction mb-3">Signed Contract</a>
                                                @else
                                                <a href="#" target="_blank" type="button" class="btn btn-sm btn-secondary disabled cardAction mb-3">Not Yet Signed</a>
                                                @endif

                                                @if($list->status == 'Signed')

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-success cardAction mb-3 animate__animated animate__slow animate__tada animate__repeat-3" data-bs-toggle="modal" data-bs-target="#approveModal{{$list->id}}">
                                                    Approve Client
                                                </button>

                                                @elseif($list->status == 'Approved')
                                                <!--<a href="{{route('kycrequests.disapprove',$list->id)}}" class="btn btn-sm btn-danger cardAction mb-3">Disapprove</a>-->
                                                @else
                                                <a href="#" class="btn btn-sm btn-secondary disabled cardAction mb-3">Approve</a>
                                                @endif

                                                <a href="{{route('kycrequests.view', encrypt($list->id))}}" class="btn btn-sm btn-info cardAction mb-3"><i class="bi bi-eye"></i></a>
                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">Last Updatd at {{$list->updated_at->todatestring()}}</small>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" style="position:absolute; bottom:0; right:0" data-bs-toggle="modal" data-bs-target="#rejectModal{{$list->id}}">
                                                    Reject Client</i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="rejectLabel">Reject Client - {{($list->userName->client_type === 'Legal Entity' ? $list->userName->company_name : $list->userName->first_name . " " . $list->userName->last_name )}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to reject the Client?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <a type="button" class="btn btn-danger" href="{{route('kycrequests.rejectClient', encrypt($list->id))}}">Reject Client</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Doc Modal -->
                                            <div class="modal fade" id="docModal{{$list->id}}" tabindex="-1" aria-labelledby="docModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Documents of {{$list->userName->company_name}}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body d-flex">
                                                            <table class="table modalTable mb-5">
                                                                <tbody class="justify-content-center">
                                                                    <tr>
                                                                        <td>Documents</td>
                                                                        <td>Issue Date</td>
                                                                        <td>Expiry Date</td>
                                                                    </tr>
                                                                    <!-- Passport -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->userName->passport)
                                                                            <a href="{{url($list->userName->passport)}}" target="_blank" type="button" class="btn btn-primary docBtn">Passport</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Passport</a>
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                        <td></td>

                                                                    </tr>
                                                                    <!-- National ID Card -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->nationalID)
                                                                            <a href="{{url($list->nationalID)}}" target="_blank" type="button" class="btn btn-primary docBtn">National ID</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">National ID</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->nationalIDIssue}}</td>
                                                                        <td>{{$list->nationalIDExpiry}}</td>

                                                                    </tr>
                                                                    <!-- Driving License -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->license)
                                                                            <a href="{{url($list->license)}}" target="_blank" type="button" class="btn btn-primary docBtn">Driving License</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Driving License</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->licenseIssue}}</td>
                                                                        <td>{{$list->licenseExpiry}}</td>

                                                                    </tr>
                                                                    <!-- Other IDs -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->otherID)
                                                                            <a href="{{url($list->otherID)}}" target="_blank" type="button" class="btn btn-primary docBtn">Other IDs</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Other IDs</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>

                                                                    </tr>
                                                                    <!-- Utility Bill -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->utilityBill)
                                                                            <a href="{{url($list->utilityBill)}}" target="_blank" type="button" class="btn btn-primary docBtn">Utility Bill</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Utility Bill</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->utilityBillIssue}}</td>
                                                                        <td>-</td>

                                                                    </tr>
                                                                    <!-- Bank Statement -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->bankStatement)
                                                                            <a href="{{url($list->bankStatement)}}" target="_blank" type="button" class="btn btn-primary docBtn">Bank Statement</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Bank Statement</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->bankStatementIssue}}</td>
                                                                        <td>-</td>

                                                                    </tr>
                                                                    <!-- Lease Agreement -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->leaseAgreement)
                                                                            <a href="{{url($list->leaseAgreement)}}" target="_blank" type="button" class="btn btn-primary docBtn">Lease Agreement</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Lease Agreement</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$list->leaseAgreementIssue}}</td>
                                                                        <td>-</td>

                                                                    </tr>

                                                                    <!-- Certificate of Incorporation -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->incorporation)
                                                                            <a href="{{url($list->incorporation)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Incorporation</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Incorporation</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- Certificate of Share Holding -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->shareHolding)
                                                                            <a href="{{url($list->shareHolding)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Share Holding</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Share Holding</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- Certificate of Registered Office -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->coro)
                                                                            <a href="{{url($list->coro)}}" target="_blank" type="button" class="btn btn-primary docBtn">Certificate of Registered Office</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Certificate of Registered Office</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- 6 Months Processing History -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->processing)
                                                                            <a href="{{url($list->processing)}}" target="_blank" type="button" class="btn btn-primary docBtn">Six Months Processing History</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Six Months Processing History</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>

                                                                    <!-- 6 Months Refund History -->
                                                                    <tr>
                                                                        <td>
                                                                            @if($list->refund)
                                                                            <a href="{{url($list->refund)}}" target="_blank" type="button" class="btn btn-primary docBtn">Six Months Refund History</a>
                                                                            @else
                                                                            <a href="#" type="button" class="btn disabled docBtn">Six Months Refund History</a>
                                                                            @endif
                                                                        </td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contract Upload Modal -->
                                            <div class="modal fade" id="exampleModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Contract </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('sendContract.mail', $list->id)}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Contract File Upload</label>
                                                                    <input class="form-control" type="file" name="contractFile" id="contractFile" required>
                                                                </div>
                                                                @error('contractFile')
                                                                <div class="alertMessage">{{ $message }}</div>
                                                                @enderror
                                                                <div class="mb-3">
                                                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--Client Approval Modal -->
                                            <div class="modal fade" id="approveModal{{$list->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Client</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Contracts Signed ? Are you sure to approve the client ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{route('kycrequests.approve',$list->id)}}" class="btn btn-sm btn-success">Approve</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endif
                                @endforeach
                                @endif
                                <!-- </div> -->
                            </div>
                        </div>
                        <!-- <div class="col-md-1"></div> -->
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

@section('script')

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


@if(session()->has('code'))
<script type="text/javascript">
    $(document).ready(function() {

        $modalName = "#docModal" + "{{ Session::get('code')}}";
        $($modalName).modal('show');
    });
</script>
@endif

@if(session()->has('codes'))
<script type="text/javascript">
    $(document).ready(function() {

        $modalName = "#preKycModal" + "{{ Session::get('codes')}}";
        $($modalName).modal('show');
    });
</script>
@endif

@if(session()->has('codess'))
<script type="text/javascript">
    $(document).ready(function() {

        $modalName = "#preKycModal" + "{{ Session::get('codess')}}";
        $($modalName).modal('show');
    });
</script>
@endif

@endsection