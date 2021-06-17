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
            <input type="hidden" name="role_id" value="{{$result['role_id']}}">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Group Name*</label>
                        <select name="group_id" class="form-control select-2" style="width:100%" placeholder="Enter Group Name" disabled>
                            <option value="">Enter Group Name</option>
                            @foreach ($rs_groups as $item)
                            <option value="{{$item['group_id']}}" {{set_select($result['group_id'],$item['group_id'])}}>{{$item['group_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Role Name</label>
                        <input type="text" name="role_name" class="form-control" placeholder="Enter Role Name" value="{{$result['role_name'] ?? ''}}" disabled>
                    </div>
                </div>	                 
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">Role Desc*</label>
                        <input type="text" name="role_desc" class="form-control" placeholder="Enter Role Desc" value="{{$result['role_desc'] ?? ''}}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Role Default Page*</label>
                        <input type="text" name="default_page" class="form-control" placeholder="Enter Default Page" value="{{$result['default_page'] ?? ''}}" disabled>
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
