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
        <form method="POST" action="{{$PAGE_URL.'add_process'}}">
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
                        <label >Total ikan *</label>
                        <input type="number" class="form-control {{error_form_class('fish_count')}}" value="{{old_input('fish_count') ?? ''}}" name="fish_count" placeholder="Total Ikan">
                        <div class="error text-danger">{{error_form('fish_count') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Total KG *</label>
                        <input type="number" class="form-control {{error_form_class('total_kg')}}" value="{{old_input('total_kg') ?? ''}}" name="total_kg" placeholder="Total KG">
                        <div class="error text-danger">{{error_form('total_kg') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Status *</label>
                        <select name="pembesaran_st" class="select-2" style="width:100%">
                            <option value="ongoing">Masih Berjalan</option>
                            <option value="finish">Selesai</option>
                        </select>
                        <div class="error text-danger">{{error_form('pembesaran_st') ?? ''}}</div>
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
