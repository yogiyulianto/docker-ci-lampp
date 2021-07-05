@extends('base.default.app')
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">Bab</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Ubah Bab
                <a href="{{$PAGE_URL.'edit/'.$course_id}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <form method="POST" action="{{$PAGE_URL.'edit_section_process'}}" >
            <input type="hidden" name="course_id" value="{{$course_id}}">
            <input type="hidden" name="section_id" value="{{$result['section_id']}}">
            <div class="card-body">
                <!--begin::Form-->
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Judul Bab*</label>
                        <input type="text" name="title" class="form-control {{error_form_class('title')}}" placeholder="Masukan Judul Bab" value="{{$result['title'] ?? ''}}">
                        <div class="error text-danger">{{error_form('title') ?? ''}}</div>
                    </div>
                </div>           
                <!--end::Form-->
            </div>
            <div class="card-action d-flex justify-content-between">
                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
                <div>
                    <i> (*) Wajib Diisi </i>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection