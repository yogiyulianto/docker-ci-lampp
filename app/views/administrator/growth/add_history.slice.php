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
        <form method="POST" action="{{$PAGE_URL.'add_history_process'}}">
            {{ csrf_token() }}
            <div class="card-body">
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Kolam *</label>
                        <select name="device_id" class="select-2" style="width:100%">
                            <option value="">Select Kolam</option>
                            @foreach($kolam as $k)
                            <option value="{{$k['device_id']}}">{{$k['name']}}</option>
                            @endforeach
                        </select>
                        <div class="error text-danger">{{error_form('device_id') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Lama Tumbuh (Dalam Hari) *</label>
                        <input type="number" class="form-control {{error_form_class('time_growth')}}" value="{{old_input('time_growth') ?? ''}}" name="time_growth" placeholder="Lama Tumbuh (Dalam hari)">
                        <div class="error text-danger">{{error_form('time_growth') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Total KG *</label>
                        <input type="number" class="form-control {{error_form_class('total_kg')}}" value="{{old_input('total_kg') ?? ''}}" name="total_kg" placeholder="Total KG">
                        <div class="error text-danger">{{error_form('total_kg') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Total Pakan *</label>
                        <input type="number" class="form-control {{error_form_class('total_feed')}}" value="{{old_input('total_feed') ?? ''}}" name="total_feed" placeholder="Total KG">
                        <div class="error text-danger">{{error_form('total_feed') ?? ''}}</div>
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
