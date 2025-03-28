@extends('layouts.master')


@section('title')

    @lang('KYC Requests')

@endsection



@section('css')

    <style>
        .editPage_h3{
            text-align: center !important;
            text-transform: uppercase;
        }  

        .editPage_h3 span{
            color: red !important;
        }

        td:nth-child(2) {
            font-weight: bold;
        }

        .formCol{
            padding: 2% !important;
            background-color: #FFFBF5  !important;
        }

        .alertMessage{
            /* font-weight: bolder ; */
            color: red !important;
            padding-top: 10px !important;
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

@endsection


@section('content')



    @component('components.breadcrumb')



        @slot('li_1')



            Edit Request



        @endslot



        @slot('title')



            KYC Requests



        @endslot



    @endcomponent



    <div class="row mb-3">

        <div class="col-sm-4"></div>

        <div class="col-sm-8">

            <div class="text-sm-end">

                <a href="{{route('kycrequests')}}">
                    <button type="button" class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2"><i class="mdi mdi-keyboard-backspace"></i> Back</button>
                </a>

            </div>

        </div><!-- end col-->

    </div>


    <div class="row">
   
        <div class="col-md-2"></div>
        <div class="col-lg-8 formCol">
                    <div class="mb-4">
                        <h3 class="editPage_h3">Edit KYC Request</span></h3>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8" style="margin: auto !important;">
                            <form action="{{route('kycrequests.update', $kycRequest->id)}}" method="post">
                            @csrf
                                <div class="mb-3">
                                    
                                    <h3>Applicant : {{$kycRequest->userName->company_name}}</h3>
                                </div>
                                <div class="mb-3">
                                    <label for="reqDocs" class="form-label">Documents Required</label>
                                    <div class="form-check mb-3">
                                        @if(in_array('certificate',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="certificate" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="certificate" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Certificate of Incorporation
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        @if(in_array('passport',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="passport" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="passport" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Passport
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        @if(in_array('certificate_of_share_holding',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="certificate_of_share_holding" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="certificate_of_share_holding" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Certificate of Share Holding
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        @if(in_array('certificate_of_registered_office',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="certificate_of_registered_office" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="certificate_of_registered_office" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Certificate of Registered Office
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        @if(in_array('6_months_processing_history',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="6_months_processing_history" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="6_months_processing_history" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Six months processing history
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        @if(in_array('6_months_chargeback_history',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="6_months_chargeback_history" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="6_months_chargeback_history" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Six months chargeback history
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        @if(in_array('6_months_refund_history',$kycRequest->requiredDocs))
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="6_months_refund_history" id="reqDocs" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" name="reqDocs[]" value="6_months_refund_history" id="reqDocs">
                                        @endif
                                        <label class="form-check-label" for="reqDocs">
                                            Six months refund history
                                        </label>
                                    </div>
                                    @error('reqDocs')
                                        <div class="alertMessage">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="comments" class="form-label">Instructions / Comments</label>
                                    <textarea class="form-control" name="comments" id="comments" rows="3" >{{$kycRequest->comments}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                </div>

                            </form>  
                        </div>
                    </div>
        </div>
        <div class="col-md-2"></div>

    </div>


@endsection



@section('script')

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
        
    <!-- select2 js -->
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- ecommerce-customer-list init -->
    <script src="{{ URL::asset('build/js/pages/contact-user-list.init.js') }}"></script>

@endsection
