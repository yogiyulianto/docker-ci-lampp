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
                <a href="{{$PAGE_URL.'master'}}" class="float-right btn btn-success btn-border btn-round btn-sm">
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
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Pref Group*</label>
                        <input type="text" name="pref_group" class="form-control {{error_form_class('pref_group')}}" placeholder="Enter Group name" value="{{old_input('pref_group') ?? ''}}">
                        <div class="error text-danger">{{error_form('pref_group') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label>Pref Type *</label>
                        <select name="pref_type" class="select-2 " style="width:100%">
                            <option value=""> * </option>
                            @foreach ($rs_pref_type as $item)
                            <option value="{{$item}}"
                                {{ set_select(old_input('pref_type') , $item) }}>{{ucfirst($item)}}
                            </option>
                            @endforeach
                        </select>
                        <div class="error text-danger">{{error_form('pref_type') ?? ''}}</div>
                    </div>
                </div>	
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">Pref Name*</label>
                        <input type="text" name="pref_nm" class="form-control {{error_form_class('pref_nm')}}" placeholder="Enter Group desc" value="{{old_input('pref_nm') ?? ''}}">
                        <div class="error text-danger">{{error_form('pref_nm') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Pref Label*</label>
                        <input type="text" name="pref_label" class="form-control {{error_form_class('pref_label')}}" placeholder="Enter Group desc" value="{{old_input('pref_label') ?? ''}}">
                        <div class="error text-danger">{{error_form('pref_label') ?? ''}}</div>
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
