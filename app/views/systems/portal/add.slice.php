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
        <form method="POST" action="{{$PAGE_URL.'add_process'}}">
            <div class="card-body">
                <!--begin::Form-->
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Portal Name*</label>
                        <input type="text" name="portal_nm" class="form-control {{error_form_class('portal_nm')}}" placeholder="Enter Portal name" value="{{old_input('portal_nm') ?? ''}}">
                        <div class="error text-danger">{{error_form('portal_nm') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Portal Title*</label>
                        <input type="text" name="portal_title" class="form-control {{error_form_class('portal_title')}}" placeholder="Enter Portal title" value="{{old_input('portal_title') ?? ''}}">
                        <div class="error text-danger">{{error_form('portal_title') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Portal Icon*</label>
                        <input type="text" name="portal_icon" class="form-control {{error_form_class('portal_icon')}}" placeholder="Enter Portal icon" value="{{old_input('portal_icon') ?? ''}}">
                        <div class="error text-danger">{{error_form('portal_icon') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Site Title*</label>
                        <input type="text" name="site_title" class="form-control {{error_form_class('site_title')}}" placeholder="Enter Site title" value="{{old_input('site_title') ?? ''}}">
                        <div class="error text-danger">{{error_form('site_title') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Site Desc*</label>
                        <input type="text" name="site_desc" class="form-control {{error_form_class('site_desc')}}" placeholder="Enter Site desc" value="{{old_input('site_desc') ?? ''}}">
                        <div class="error text-danger">{{error_form('site_desc') ?? ''}}</div>
                    </div>
                </div>	                 
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">Meta Keyword</label>
                        <input type="text" name="meta_keyword" class="form-control {{error_form_class('meta_keyword')}} " placeholder="Enter Meta keyword"  value="{{old_input('meta_keyword') ?? ''}}">
                        <div class="error text-danger">{{error_form('meta_keyword') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label>Meta Desc</label>
                        <input type="text" name="meta_desc" class="form-control {{error_form_class('meta_desc')}}" placeholder="Enter Meta desc" value="{{old_input('meta_desc') ?? ''}}">
                        <div class="error text-danger">{{error_form('meta_desc') ?? ''}}</div>
                    </div>
                </div>	                 
                <!--end::Form-->
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
