@extends('base.default.app')
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">Kuis</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tambahkan Kuis
                <a href="{{$PAGE_URL.'edit/'.$course_id}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <form method="POST" action="{{$PAGE_URL.'add_quiz_process'}}" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="{{$course_id}}" >
            <div class="card-body">
                <!--begin::Form-->
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Judul Kuis*</label>
                        <input type="text" name="title" class="form-control {{error_form_class('title')}}" placeholder="Masukan Judul Kuis" value="{{old_input('title') ?? ''}}">
                        <div class="error text-danger">{{error_form('title') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Bab *</label>
                        <select name="section_id" class="select-2" style="width:100%">
                            <option value=""> * </option>
                            @foreach ($rs_section as $item)
                            <option value="{{$item['section_id']}}" {{ set_select(old_input('section_id') , $item['section_id']) }}> {{$item['title']}} </option>
                            @endforeach
						</select>
                        <div class="error text-danger">{{error_form('lesson_type') ?? ''}}</div>
                    </div>
                </div>      
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ringkasan *</label>
                        <textarea name="summary" class="form-control {{error_form_class('summary') ?? ''}}" id="" cols="30" rows="10">{{old_input('summary')}}</textarea>
                        <div class="error text-danger">{{error_form('summary') ?? ''}}</div>
                    </div>
                </div>
                <!--end::Form-->
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection