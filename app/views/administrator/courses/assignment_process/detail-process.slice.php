@extends('base.default.app')
@section('ext_css')
<link href="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
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
			<div class="card-title">Masukan Nilai
				<a onclick="history.back()" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
			</div>
		</div>
		<!--begin::Form-->
		<form class="" method="POST" action="{{$PAGE_URL.'update_nilai_process'}}" enctype="multipart/form-data">
			{{ csrf_token() }}
			<input type="hidden" name="assignment_id" value="{{$rs_assignment['assignment_id']}}">
            <input type="hidden" name="lesson_id" value="{{$rs_assignment['lesson_id']}}">
			<input type="hidden" name="fasilitator_id" value="{{$rs_assignment['fasilitator_id']}}">
			<input type="hidden" name="user_id" value="{{$rs_assignment['user_id']}}">
			<input type="hidden" name="course_id" value="{{$rs_assignment['course_id']}}">
			<div class="card-body">
                <div class="form-group row">
					<div class="col-lg-6">
						<label>Dikumpulkan jam*</label>
						<input type="text" name="mdd" disabled class="form-control {{error_form_class('mdd')}}"
							placeholder="Masukan Nilai" value="{{$rs_assignment['mdd'] ?? ''}}">
						<div class="error text-danger">{{error_form('mdd') ?? ''}}</div>
					</div>
                    <div class="col-lg-6">
						<label>Oleh*</label>
						<input type="text" name="mdb_name" disabled class="form-control {{error_form_class('mdb_name')}}"
							placeholder="Masukan Nilai" value="{{$rs_assignment['mdb_name'] ?? ''}}">
						<div class="error text-danger">{{error_form('mdb_name') ?? ''}}</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						<label>Nilai*</label>
						<input type="text" name="nilai" class="form-control {{error_form_class('nilai')}}"
							placeholder="Masukan Nilai" value="{{$rs_assignment['nilai'] ?? ''}}">
						<div class="error text-danger">{{error_form('nilai') ?? ''}}</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						<label>Catatan *</label>
						<textarea class="form-control {{error_form_class('catatan')}}" id="summernote" name="catatan" cols="30" rows="10" placeholder="Masukan Catatan" >{{$rs_assignment['catatan'] ?? ''}}</textarea>
						<div class="error text-danger">{{error_form('catatan') ?? ''}}</div>
					</div>
				</div>
			</div>
			<div class="card-action">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="reset" class="btn btn-warning">Reset</button>
			</div>
		</form>
		<!--end::Form-->
	</div>
</div>
@endsection

@section('ext_js')
<script src="{{$asset_url}}plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.js" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		$('#summernote').summernote();
	});
</script>
@endsection
