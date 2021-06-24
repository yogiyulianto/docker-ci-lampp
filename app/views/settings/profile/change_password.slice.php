@extends('settings.profile.index')
@section('app_content')
<form method="POST" action="{{$PAGE_URL.'change_password_process'}}">
    {{csrf_token()}}
    <div class="card-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Current Password</label>
                <input type="password" class="form-control {{error_form_class('current_password')}}" name="current_password" placeholder="Current password">
                <div class="error text-danger">{{error_form('current_password') ?? ''}}</div>
                <a href="#" class="kt-link kt-font-sm kt-font-bold kt-margin-t-5">Forgot password ?</a>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-xl-6">
                <label>New Password</label>
                <input type="password" class="form-control {{error_form_class('new_password')}}" name="new_password" placeholder="New password">
                <div class="error text-danger">{{error_form('new_password') ?? ''}}</div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <label>Verify Password</label>
                <input type="password" class="form-control {{error_form_class('new_password_conf')}}" name="new_password_conf" placeholder="Verify password">
                <div class="error text-danger">{{error_form('new_password_conf') ?? ''}}</div>
            </div>
        </div>
    </div>
    <div class="card-action">
        <button type="submit" class="btn btn-primary btn-bold">Change Password</button>&nbsp;
        <button type="reset" class="btn btn-secondary">Cancel</button>
    </div>
</form>
@endsection