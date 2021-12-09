<!-- 
    Framework : CI-SLICE-V2
    Date : 26-03-2020
    Time : 12:00
-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>{{(!empty($page['nav_title'])) ? $page['nav_title'] : 'Selamat Datang'}} - FISHEE</title>
		<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
		<link rel="icon" href="{{asset('images/favicons/favicon.ico')}}" type="image/x-ico"/>
		<link rel="apple-touch-icon" sizes="57x57" href="{{asset('images/favicons/apple-icon-57x57.png')}}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{asset('images/favicons/apple-icon-60x60.png')}}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{asset('images/favicons/apple-icon-72x72.png')}}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicons/apple-icon-76x76.png')}}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{asset('images/favicons/apple-icon-114x114.png')}}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{asset('images/favicons/apple-icon-120x120.png')}}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{asset('images/favicons/apple-icon-144x144.png')}}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{asset('images/favicons/apple-icon-152x152.png')}}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/favicons/apple-icon-180x180.png')}}">
		<link rel="icon" type="image/png" sizes="192x192"  href="{{asset('images/favicons/android-icon-192x192.png')}}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicons/favicon-32x32.png')}}">
		<link rel="icon" type="image/png" sizes="96x96" href="{{asset('images/favicons/favicon-96x96.png')}}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicons/favicon-16x16.png')}}">
		<link rel="manifest" href="{{asset('images/favicons/manifest.json')}}">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="{{asset('images/favicons/ms-icon-144x144.png')}}">
		<meta name="theme-color" content="#ffffff">
		<!-- Fonts and icons -->
		<link rel="stylesheet" href="{{asset('themes/atlantis/fonts/line-awesome/line-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('themes/atlantis/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('themes/atlantis/css/atlantis.css')}}">
		<link rel="stylesheet" href="{{asset('themes/atlantis/css/pace.css')}}">
		<link rel="stylesheet" href="{{asset('themes/atlantis/plugins/select2/select2.full.css')}}">
		<script src="{{asset('themes/atlantis/js/pace.min.js')}}"></script>
		<script src="{{asset('themes/atlantis/plugins/webfont/webfont.min.js')}}"></script>
		<script>
			WebFont.load({
				google: {"families":["Lato:300,400,700,900"]},
				custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons","line-awesome"], urls: ['{{asset("themes/atlantis/css/fonts.min.css")}}']},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>
		<!-- CSS Files -->

		<!-- external CSS -->
		@yield('styles')
	</head>
	<body>
		<div class="wrapper ">
			<!-- Navbar -->
			@include('base.default.navbar')
			<!-- End Navbar -->
			<!-- Sidebar -->
			@include('base.default.sidebar')
			<!-- End Sidebar -->
			<div class="main-panel">
				<div class="content">
					@yield('content')
				</div>
				@include('base.default.footer')
			</div>
		</div>
		<!--  Core JS Files   -->
		<script src="{{asset('themes/atlantis/js/core/jquery.3.2.1.min.js')}}"></script>
		<script src="{{asset('themes/atlantis/js/core/popper.min.js')}}"></script>
		<script src="{{asset('themes/atlantis/js/core/bootstrap.min.js')}}"></script>
		<!-- jQuery UI -->
		<script src="{{asset('themes/atlantis/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
		<script src="{{asset('themes/atlantis/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
		<!-- jQuery Scrollbar -->
		<script src="{{asset('themes/atlantis/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
		<!-- Chart JS -->
		<script src="{{asset('themes/atlantis/plugins/chart.js/chart.min.js')}}"></script>
		<!-- jQuery Sparkline -->
		<script src="{{asset('themes/atlantis/plugins/jquery.sparkline/jquery.sparkline.min.js')}}"></script>
		<!-- Chart Circle -->
		<script src="{{asset('themes/atlantis/plugins/chart-circle/circles.min.js')}}"></script>
		<!-- Datatables -->
		<!-- Bootstrap Notify -->
		<script src="{{asset('themes/atlantis/plugins/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
		<!-- jQuery Vector Maps -->
		<!-- Sweet Alert -->
		<script src="{{asset('themes/atlantis/plugins/select2/select2.full.min.js')}}"></script>
		<!-- Atlantis JS -->
		<script src="{{asset('themes/atlantis/js/atlantis.min.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js"></script>
		<script>
			$(document).ready(function() {
				$('.select-2').select2({
					theme: "bootstrap",
				});
				$('.select-2-multipe').select2({
					theme: "bootstrap",
				});
			});
			
			paceOptions = {
				elements: false,
				restartOnPushState: false,
				restartOnRequestAfter: false
			}
		</script>
		@yield('scripts')
	</body>
	@include('base.default.modal')
	@yield('modal')
</html>
