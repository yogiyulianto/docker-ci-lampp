@extends('base.default.app')
@section('title')
perawat
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
            <input type="hidden" name="token_id" value="{{$result['token_id']}}">
            {{ csrf_token() }}
            <div class="card-body">
                <div class="form-group row ">
				<div class="col-lg-6">
                        <label >Token</label>
                        <input type="text"  class="form-control {{error_form_class('token')}}" value="{{$result['token'] ?? ''}}" name="token" placeholder="Token" readonly>
                        <div class="error text-danger">{{error_form('token') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Tanggal Kadaluarsa *</label>
                        <input type="text" class="form-control selector {{error_form_class('expired_at')}}" value="{{$result['expired_at'] ?? ''}}" name="expired_at" placeholder="Tanggal Kadaluarsa" readonly>
                        <div class="error text-danger">{{error_form('expired_at') ?? ''}}</div>
                    </div>
                </div>
				<div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Token Status *</label>
                        <select name="token_sts" class="select-2" style="width:100%">
                            <option value="0" {{ set_select($result['token_sts'] , 0) }}>Belum Terpakai</option>
                            <option value="1" {{ set_select($result['token_sts'] , 1) }}>Terpakai</option>
                        </select>
                        <div class="error text-danger">{{error_form('token_sts') ?? ''}}</div>
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
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script type="text/javascript">


$(".selector").flatpickr({
	minDate: "today"
});

</script>
@endsection
