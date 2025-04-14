@yield('css')

<!-- Bootstrap Css -->
<link href="{{ url('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ url('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ url('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- App js -->
<!--<script src="{{ url('build/js/plugin.js') }}"></script>-->

<style type="text/css">
	.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #ffff;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #34c38f;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #34c38f;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}

.trasact
{

  background-color: #edff4a !important;
}

/* MD. CSS */

.auth-body-bg {
	background-color: #000;
}
#gdpr-cookie-message {
    position: fixed;
    left: 0px;
    bottom: 20px;
    margin-left: 20px;
    max-width: 375px;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 6px 6px rgba(0,0,0,0.25);
    font-family: system-ui;
    padding-bottom: 0;
	z-index: 9;
}
#gdpr-cookie-accept {
	border: none;
	background: #333;
	color: white;
	font-size: 15px;
	padding: 8px 12px;
	border-radius: 3px;
	cursor: pointer;
	transition: all 0.3s ease-in;
	margin-top: 10px;
}
#gdpr-cookie-message button:hover {
    background: #000;
    color: #fff;
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message h4 {
    color: var(--red);
    font-family: 'Quicksand', sans-serif;
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 10px;
	display:none;
}
button#gdpr-cookie-advanced {
	background: white;
	color: var(--red);
	display: none;
}
#gdpr-cookie-message p, #gdpr-cookie-message ul {
    color: #333;
    font-size: 15px;
    line-height: 1.5em;
}
#gdpr-cookie-message a {
	display: none;
}
#gdpr-cookie-message .cookies {
	color: #00cef2;
	display: inline;
}

.auth-full-bg .bg-overlay {
    background: url(/CRM/public/images/payit123_crm.jpg);
	background-repeat: no-repeat;
}
.auth-full-bg .font-size-16, .auth-full-bg .font-size-14, .auth-full-bg h4.mb-3, .auth-full-bg span.text-primary, .auth-full-bg .bxs-quote-alt-left:before {
    color: #fff !important;
}
.auth-review-carousel.owl-theme .owl-dots .owl-dot.active span, .auth-review-carousel.owl-theme .owl-dots .owl-dot:hover span, .auth-review-carousel.owl-theme .owl-dots .owl-dot span {
    background-color: #fff;
}
.auth-full-page-content.p-md-5.p-4 {
    background: #000;
}
.auth-full-page-content.p-md-5.p-4 h5.text-primary {
    color: #00f041 !important;
}
.auth-full-page-content.p-md-5.p-4 p, .auth-full-page-content.p-md-5.p-4 label.form-label, .auth-full-page-content.p-md-5.p-4 .form-check-label {
    color: #fff !important;
}
.auth-full-page-content.p-md-5.p-4 button.btn.btn-primary.waves-effect.waves-light {
    background: #00f041;
    color: #333;
    font-weight: 600;
}
.auth-full-page-content.p-md-5.p-4  .auth-logo .auth-logo-dark {
    width: 219px;
    height: 70px;
}
.auth-full-page-content.p-md-5.p-4  .mb-md-5 {
    margin-bottom: 0rem!important;
}
#auth-review-carousel, .auth-full-bg h4.mb-3 {
	display: none;
}


@media only screen and (max-width: 850px) {
#gdpr-cookie-message {
	left: -10px;
}
.auth-full-bg .bg-overlay {
	background-size: contain;
	width: 440px;
	height: 275px;
}
.auth-full-page-content.p-md-5.p-4  .auth-logo .auth-logo-dark {
    margin-bottom: 40px;
}

}

@media only screen and (min-width: 768px) and (max-width: 991px) {
.auth-full-bg .bg-overlay {
	background-size: contain;
	width: 850px;
	height: 500px;
}

}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
.auth-full-bg .bg-overlay {
	background-size: contain;
	width: 1000px;
	height: 625px;
}

}


</style>