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
            <div class="card-title">Delete {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Back
                </a>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{$PAGE_URL.'delete_process'}}" onsubmit="return confirm('Apakah anda yakin akan menghapus data dibawah ini?');">
            <input type="hidden" name="user_id" value="{{$result['user_id']}}">
            {{ csrf_token() }}
            <div class="card-body">
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Full Name *</label>
                        <input type="text" class="form-control" value="{{$result['full_name'] ?? ''}}" name="full_name" placeholder="Full Name Fields" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label >Email *</label>
                        <input type="email" class="form-control" value="{{$result['user_mail'] ?? ''}}" name="user_mail" placeholder="Email Fields" disabled>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Phone *</label>
                        <input type="text" class="form-control" value="{{$result['phone'] ?? ''}}" name="phone" placeholder="Phone Number Fields" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label >Address *</label>
                        <input type="text" class="form-control" value="{{$result['address'] ?? ''}}" name="address" placeholder="Address Fields" disabled>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label>Username *</label>
                        <input type="text" class="form-control" value="{{$result['user_name'] ?? ''}}" name="user_name" placeholder="Username Fields" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label >Password *</label>
                        <input type="password" class="form-control" value="" name="user_pass" placeholder="Password Fields" disabled>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >User Status *</label>
                        <select name="user_st" class="select-2" style="width:100%" disabled>
                            <option value="1" {{ set_select($result['user_st'] , 1) }}>Active</option>
                            <option value="2" {{ set_select($result['user_st'] , 2) }}>Locked</option>
                        </select>
                    </div>
                </div>
            </div>            
            <div class="card-action">
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Portlet-->
</div>
@endsection
