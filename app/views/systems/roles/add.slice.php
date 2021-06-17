@extends('base.default.app')
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
        <form class="" method="POST" action="{{$PAGE_URL.'add_process'}}">
            {{ csrf_token() }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Group Name*</label>
                        <select name="group_id" class="form-control select-2 {{error_form_class('group_id')}} " style="width:100%" placeholder="Enter Group Name">
                            <option value="">Enter Group Name</option>
                            @foreach ($rs_groups as $item)
                            <option value="{{$item['group_id']}}" {{set_select(old_input('group_id'),$item['group_id'])}}>{{$item['group_name']}}</option>
                            @endforeach
                        </select>
                        <div class="error text-danger">{{error_form('group_id') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Role Name*</label>
                    <input type="text" name="role_name" class="form-control {{error_form_class('role_name')}}" placeholder="Enter Role Name" value="{{old_input('role_name') ?? ''}}">
                        <div class="error text-danger">{{error_form('role_name') ?? ''}}</div>
                    </div>
                </div>	                 
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">Role Desc</label>
                        <input type="text" name="role_desc" class="form-control {{error_form_class('role_desc')}}" placeholder="Enter Role Desc" value="{{old_input('role_desc') ?? ''}}">
                        <div class="error text-danger">{{error_form('role_desc') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Role Default Page*</label>
                        <input type="text" name="default_page" class="form-control {{error_form_class('default_page')}}" placeholder="Enter Default Page" value="{{old_input('default_page') ?? ''}}">
                        <div class="error text-danger">{{error_form('default_page') ?? ''}}</div>
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
