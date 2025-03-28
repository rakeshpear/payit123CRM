@extends('layouts.master-without-nav')

@section('title')
@lang('Login')
@endsection

@section('css')
<!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/owl.carousel/assets/owl.theme.default.min.css') }}">
@endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')

    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xl-9">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">

                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center">

                                                <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span class="text-primary">5k</span>+ Satisfied clients</h4>

                                                <div dir="ltr">
                                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">" Fantastic theme with a
                                                                    ton of options. If you just want the HTML to
                                                                    integrate with your project, then this is the
                                                                    package. You can find the files in the 'dist'
                                                                    folder...no need to install git and all the other
                                                                    stuff the documentation talks about. "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">Abs1981</h4>
                                                                    <p class="font-size-14 mb-0">- PayIT User</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">" If Every Vendor on Envato
                                                                    are as supportive as Themesbrand, Development with
                                                                    be a nice experience. You guys are Wonderful. Keep
                                                                    us the good work. "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">nezerious</h4>
                                                                    <p class="font-size-14 mb-0">- PayIT User</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <a href="index" class="d-block auth-logo">
                                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="70" class="auth-logo-dark">
                                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="70" class="auth-logo-light">
                                    </a>
                                </div>
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p class="text-muted">Sign in to continue to PayIT.</p>
                                    </div>

                                    @if(session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible" id="error-message">
                                            {{ session()->get('error') }}
                                        </div>
                                        <script>
                                            // Automatically hide the error message after 5 seconds
                                            setTimeout(function() {
                                                var errorMessage = document.getElementById('error-message');
                                                if (errorMessage) {
                                                    errorMessage.style.display = 'none';
                                                }
                                            }, 3500); 
                                        </script>
                                    @endif

                                    <div class="mt-4">
                                           <form action="{{ route('index') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="username" placeholder="Enter Email" autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                                <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                    <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    Remember me
                                                </label>
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                                    In</button>
                                            </div>

                                            <!-- <div class="mt-4 text-center">
                                                <h5 class="font-size-14 mb-3">Sign in with</h5>

                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="social-list-item bg-primary text-white border-primary">
                                                            <i class="mdi mdi-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="social-list-item bg-info text-white border-info">
                                                            <i class="mdi mdi-twitter"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="social-list-item bg-danger text-white border-danger">
                                                            <i class="mdi mdi-google"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div> -->
                                        
                                        <!-- <div class="mt-5 text-center">
                                            <p>Don't have an account ? <a href="" class="fw-medium text-primary"> Signup now </a> </p>
                                        </div> -->
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">Copyright © <script>
                                            document.write(new Date().getFullYear())
                                        </script> | PayIT123 - FINFORTUNE INTERNATIONAL LIMITED (PayIT123).
                                        </p>
                                    <p> <a href="https://payit123.com/privacy-policy.html" target="_blank">Privacy Policy</a> | <a href="https://payit123.com/terms-and-conditions.html" target="_blank">Terms of Use</a> | <a href="https://payit123.com/cookie-policy.html" target="_blank">Cookie Policy</a> | <a href="https://payit123.com/data-processing-policy.html" target="_blank">Data Processing Polic</a> </p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    @endsection
    @section('script')
    <!-- owl.carousel js -->
    <script src="{{ URL::asset('build/libs/owl.carousel/owl.carousel.min.js') }}"></script>
    <!-- auth-2-carousel init -->
    <script src="{{ URL::asset('build/js/pages/auth-2-carousel.init.js') }}"></script>

    <!-- GDPR JS-->
  
 <script type="text/javascript" src="https://payit123crm.com/CRM/public/build/js/jquery.ihavecookies.js"></script>
    <script type="text/javascript">
    var options = {
        //title: '&#x1F36A; Accept Cookies & Privacy Policy?',
        message: 'We use cookies and other similar technologies to improve your browsing experience and the functionality of our site. <a href="https://payit123.com/cookie-policy.html" class="cookies" target="_blank">Cookie Policy</a>',
        delay: 600,
        expires: 1,
        link: '#privacy',
        onAccept: function(){
            var myPreferences = $.fn.ihavecookies.cookie();
            console.log('Yay! The following preferences were saved...');
            console.log(myPreferences);
        },
        uncheckBoxes: true,
        acceptBtnLabel: 'Accept Cookies',
        cookieTypesTitle: 'Select which cookies you want to accept',
        fixedCookieTypeLabel: 'Essential',
        fixedCookieTypeDesc: 'These are essential for the website to work correctly.'
    }

    $(document).ready(function() {
        $('body').ihavecookies(options);

        if ($.fn.ihavecookies.preference('marketing') === true) {
            console.log('This should run because marketing is accepted.');
        }

        $('#ihavecookiesBtn').on('click', function(){
            $('body').ihavecookies(options, 'reinit');
        });
    });

    </script>
    @endsection
