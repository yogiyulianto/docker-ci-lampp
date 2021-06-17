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
        <form class="" method="POST" action="{{$PAGE_URL.'delete_process'}}" onsubmit="return confirm('Apakah anda yakin akan menghapus data dibawah ini?');">
            {{ csrf_token() }}
            <input type="hidden" name="portal_id" value="{{$result['portal_id']}}">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Portal Name*</label>
                        <input type="text" name="portal_nm" class="form-control" placeholder="Enter Portal name" value="{{$result['portal_nm'] ?? ''}}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Portal Title*</label>
                        <input type="text" name="portal_title" class="form-control" placeholder="Enter Portal title" value="{{$result['portal_title'] ?? ''}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Portal Icon*</label>
                        <input type="text" name="portal_icon" class="form-control" placeholder="Enter Portal icon" value="{{$result['portal_icon'] ?? ''}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Site Title*</label>
                        <input type="text" name="site_title" class="form-control" placeholder="Enter Site title" value="{{$result['site_title'] ?? ''}}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Site Desc*</label>
                        <input type="text" name="site_desc" class="form-control" placeholder="Enter Site desc" value="{{$result['site_desc'] ?? ''}}" disabled>
                    </div>
                </div>	                 
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">Meta Keyword</label>
                        <input type="text" name="meta_keyword" class="form-control " placeholder="Enter Meta keyword"  value="{{$result['meta_keyword'] ?? ''}}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>Meta Desc</label>
                        <input type="text" name="meta_desc" class="form-control" placeholder="Enter Meta desc" value="{{$result['meta_desc'] ?? ''}}" disabled>
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