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
            <input type="hidden" name="group_id" value="{{$result['group_id']}}">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Group Name*</label>
                        <input type="text" name="group_name" class="form-control" placeholder="Enter Group name" value="{{$result['group_name'] ?? ''}}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Group Desc*</label>
                        <input type="text" name="group_desc" class="form-control" placeholder="Enter Group desc" value="{{$result['group_desc'] ?? ''}}" disabled>
                        {{-- <span class="form-text text-danger">Please enter your contact number</span> --}}
                    </div>
                </div>	                 
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection
