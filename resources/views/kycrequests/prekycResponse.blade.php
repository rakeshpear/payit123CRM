<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Queries on Additional Questionnaire | PayIT123CRM</title>
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
</head>

<body>
    <style>
        body {
            /* background-color: black;
            color: white; */
            background: rgb(13, 17, 29);
            background: linear-gradient(74deg, rgba(13, 17, 29, 1) 0%, rgba(39, 28, 60, 1) 50%, rgba(13, 17, 29, 1) 65%, rgba(94, 75, 61, 1) 100%);
            color: white;
        }

        .black {
            background-color: none !important;
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

        <h1>Pre-KYC PROCESS - Additional Informations Needed</h1>


        <div class="row">

            <div class="col-lg-2"></div>

            <div class="col-lg-8">



                <h6>PayIT123CRM Processing Client - <span style="color: yellow;">Queries on Pre-KYC Process</span></h6>
                @include('flash_msg')
                <form action="{{route('kycrequests.recordpreKycResponse')}}" method="Post">
                    @csrf
                    <input type="hidden" name="clientID" value="{{$client->id}}">
                    <div class="row mt-4">
                        <h3 class="head-h3">Greetings <span>{{$client->client_type == 'Individual' ? $client->first_name . ' ' . $client->last_name : $client->company_name }} </span>!</h3>
                        <p>The below queries needs your kind clarification to start our KYC process further. <br>
                            Please provide the same.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-12 row">

                            <div class="col-lg-12 mt-4">
                                @if($client->prekycclarification_status !== 'Response Received')
                                @if($qs)
                                @foreach($qs as $q)
                                @if($q->status === 'Open')
                                <div class="mb-3">

                                    <label for="exampleFormControlInput1" class="form-label mb-3"><span style="color: yellow !important;">Q: </span> {{$q->question}}</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="answers[]" placeholder="Your clarification here..." required>
                                    <input type="hidden" name="questionIDs[]" value="{{$q->id}}">

                                </div>
                                @endif
                                @endforeach
                                <p class="mt-4">Once submit your responses, please wait for further updates from our side.</p>
                                @endif
                                @else
                                <p>Your response were submitted. Please wait for further updates. Thank you. </p>
                                @endif

                            </div>



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