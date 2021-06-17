@extends('base.default.app')
@section('title')
Users
@endsection
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">{{$PAGE_HEADER}}</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Add {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Back
                </a>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{$PAGE_URL.'edit_process'}}">
            <input type="hidden" name="user_id" value="{{$result['user_id']}}">
            {{ csrf_token() }}
            <div class="card-body">
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Full Name *</label>
                        <input type="text" class="form-control {{error_form_class('full_name')}}" value="{{$result['full_name'] ?? ''}}" name="full_name" placeholder="Full Name Fields">
                        <div class="error text-danger">{{error_form('full_name') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Email *</label>
                        <input type="email" class="form-control {{error_form_class('user_mail')}}" value="{{$result['user_mail'] ?? ''}}" name="user_mail" placeholder="Email Fields">
                        <div class="error text-danger">{{error_form('user_mail') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Phone *</label>
                        <input type="text" class="form-control {{error_form_class('phone')}}" value="{{$result['phone'] ?? ''}}" name="phone" placeholder="Phone Number Fields">
                        <div class="error text-danger">{{error_form('phone') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Address *</label>
                        <input type="text" class="form-control {{error_form_class('address')}}" value="{{$result['address'] ?? ''}}" name="address" placeholder="Address Fields">
                        <div class="error text-danger">{{error_form('address') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label>Username *</label>
                        <input type="text" class="form-control {{error_form_class('user_name')}}" value="{{$result['user_name'] ?? ''}}" name="user_name" placeholder="Username Fields">
                        <div class="error text-danger">{{error_form('user_name') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Password *</label>
                        <input type="password" class="form-control {{error_form_class('user_pass')}}" value="" name="user_pass" placeholder="Password Fields">
                        <div class="error text-danger">{{error_form('user_pass') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >User Status *</label>
                        <select name="user_st" class="select-2" style="width:100%">
                            <option value="1" {{ set_select($result['user_st'] , 1) }}>Active</option>
                            <option value="2" {{ set_select($result['user_st'] , 2) }}>Locked</option>
                        </select>
                        <div class="error text-danger">{{error_form('user_st') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Role Name *</label>
                        <select name="role_id" class="select-2" style="width:100%">
                            <option value="">Select Role</option>
                            @foreach ($rs_roles as $item)
                            <option value="{{ $item['role_id'] }}" {{ set_select($result['role_id'] , $item['role_id'])}}>{{ $item['role_name'] }}</option>
                            @endforeach
                        </select>
                        <div class="error text-danger">{{error_form('role_id') ?? ''}}</div>
                    </div>
                </div>
            </div>
            
            <div class="card-action">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection
