@extends('base.auth')
@section('title')
Login
@endsection
@section('content')
<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-primary-gradient">
	<h1 class="title fw-bold text-white mb-3 d-none d-sm-block">
		<img src="{{asset('images/auth_bg.svg')}}" style="width:90%">
	</h1>
</div>
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
	<div class="container container-login container-transparent animated fadeIn">
		<div class="row mb-2">
			<img src="{{asset('images/logo-pucat-2.svg')}}" alt="navbar brand" class="navbar-brand mx-auto" style="width:80%">
		</div>
		@include('base.default.notification')
		<form action="{{url('auth/login_process')}}" method="post" id="form">	
			{{csrf_token()}}
			<div class="login-form">
				<div class="form-group">
					<label>Username</label>
					<input name="username" id="username" type="text" class="form-control" placeholder="Masukkan Username" required >
					<div for="username" class="error text-danger">{{ error_form('username') ?? ''}}</div>
				</div>
				<div class="form-group ">
					<label>Password</label>
					<!-- <a href="{{url('forgot_password')}}" class="link float-right">Lupa Password ?</a> -->
					<div class="position-relative">
						<input name="password" id="password" type="password" class="form-control" placeholder="Masukkan Password" required minlength="8">
						<div class="show-password">
							<i class="icon-eye"></i>
						</div>
					</div>
					<div for="password" class="error text-danger">{{error_form('password') ?? ''}}</div>
				</div>
				<div class="form-group form-action-d-flex mb-3">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="rememberme" name="remember">
						<label class="custom-control-label m-0" for="rememberme">Ingat Saya</label>
					</div>
					<button type="submit" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">
						Masuk
					</button>
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