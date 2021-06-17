@extends('base.auth')
@section('title')
Forgot Password
@endsection
@section('content')
<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-primary-gradient">
	<h1 class="title fw-bold text-white mb-3 d-none d-sm-block">
		<img src="{{asset('images/forgot_password_bg.svg')}}" style="width:80%">
	</h1>
</div>
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
	<div class="container container-login container-transparent animated fadeIn">
		<div class="row mb-2">
			<img src="{{asset('images/logo-balmon.png')}}" alt="navbar brand" class="navbar-brand mx-auto " style="width:70%">
		</div>
		<h5 class="text-center">Lupa Password Anda?</h5>
		<h6 class="font-weight-light">Masukkan email anda pada isian dibawah ini dan password akan dikirim ke email tersebut.</h6>
		@include('base.default.notification')
		<form action="{{url('auth/forgot_password_process')}}" method="post" id="form">	
			{{csrf_token()}}
			<div class="login-form">
				<div class="form-group">
					<label>Email</label>
					<input name="user_mail" id="user_mail" type="email" class="form-control " placeholder="Masukkan email anda" required>
					<div for="user_mail" class="error text-danger">{{error_form('user_mail') ?? ''}}</div>
				</div>
				<div class="form-group form-action-d-flex mb-3">
					<button type="submit" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Reset Password</button>
				</div>
				<div class="login-account">
					<span class="msg">Sudah Reset Password ?</span>
					<a href="{{url('/login')}}"  class="link">Masuk</a> disini
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function(){
		$("#form").validate();
	});
</script>
@endsection
