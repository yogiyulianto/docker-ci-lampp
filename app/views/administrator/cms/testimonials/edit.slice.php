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
            <div class="card-title">Update {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Back
                </a>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{$PAGE_URL.'edit_Survey'}}">
            {{ csrf_token() }}
            <div class="card-body">
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Nama</label>
                        <input type="text" class="form-control {{error_form_class('nama')}}" value="" name="nama" placeholder="Nama">
                        <div class="error text-danger">{{error_form('nama') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Umur</label>
                        <input type="number" class="form-control {{error_form_class('age')}}" value="" name="age" placeholder="Umur">
                        <div class="error text-danger">{{error_form('age') ?? ''}}</div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-lg-6">
                        <label >Deskripsi</label>
                        <input type="text" class="form-control {{error_form_class('description')}}" value="" name="description" placeholder="Deskripsi">
                        <div class="error text-danger">{{error_form('description') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Alamat</label>
                        <input type="text" class="form-control {{error_form_class('address')}}" value="" name="address" placeholder="Alamat">
                        <div class="error text-danger">{{error_form('address') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Tanggal Survey</label>
                        <input type="date" class="form-control {{error_form_class('datetime')}}" value="" name="datetime" placeholder="Tanggal Survey">
                        <div class="error text-danger">{{error_form('datetime') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label >Foto Profil</label>
                        <input type="text" class="form-control {{error_form_class('image')}}" value="" name="image" placeholder="Foto Profile">
                        <div class="error text-danger">{{error_form('image') ?? ''}}</div>
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
