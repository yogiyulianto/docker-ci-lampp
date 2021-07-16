@extends('base.default.app')
<link href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
@section('content')
<div class="page-inner">
	<div class="page-header d-none d-sm-flex">
		<h4 class="page-title">{{$PAGE_HEADER}}</h4>
		@include('base.default.breadcrumb')
	</div>
	@include('base.default.notification')
	<div class="card">
		<div class="card-header">
			<div class="card-title">Ubah {{$PAGE_HEADER }}
				<a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
					<span class="btn-label">
						<i class="las la-angle-left"></i>
					</span>
					Kembali
				</a>
			</div>
		</div>
		<!--begin::Form-->
		<form class="" method="POST" action="{{$PAGE_URL.'edit_process'}}" enctype="multipart/form-data">
			{{ csrf_token() }}
			<input type="hidden" name="audio_id" value="{{$result['audio_id']}}">
			<div class="card-body">
				<!--begin::Form-->
				{{ csrf_token() }}
				<div class="row">
					<div class="col-12">
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Judul*</label>
								<input type="text" name="title" class="form-control {{error_form_class('title')}}"
									placeholder="Masukan Judul" value="{{$result['title'] ?? ''}}">
								<div class="error text-danger">{{error_form('title') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label class="">Kategori Audio *</label>
								<select name="category_id" class="select-2 " style="width:100%">
									<option value="0"> Pilih Kategori </option>
									@foreach ($rs_category as $item)
									<option value="{{$item['category_id']}}"
										{{ set_select($result['category_id'] , $item['category_id']) }}>{{$item['title']}}
									</option>
									@endforeach
								</select>
								<div class="error text-danger">{{error_form('category_id') ?? ''}}</div>
							</div>
							<div class="col-lg-6">
								<label class="">Status Audio *</label>
								<select name="audio_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="published" {{ set_select($result['audio_st'] , 'published') }}> Published </option>
									<option value="draft" {{ set_select($result['audio_st'] , 'draft') }}> Draft </option>
								</select>
								<div class="error text-danger">{{error_form('category_id') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label>Thumbnail*</label><small> Hanya Gambar (jpg, jpeg, png) maks. 3MB Resolusi
									1000x1000px</small>
								<input type="file" class="dropify {{error_form_class('image')}}" name="image"
									data-show-errors="true" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="10M"
									data-max-width="3000" data-max-height="3000" data-default-file="{{base_url($result['image'])}}">
								<div class="error text-danger">{{error_form('image') ?? ''}}</div>
							</div>
							<div class="col-md-6">
								<label>Audio*</label><small> Hanya Audio (avi, mp4) maks. 10MB </small>
								<input type="file" class="dropify {{error_form_class('audio')}}" name="audio"
									data-show-errors="true" data-allowed-file-extensions="avi mp4" data-max-file-size="10M" data-default-file="{{base_url($result['path'])}}">
								<div class="error text-danger">{{error_form('audio') ?? ''}}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-action">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<button type="reset" class="btn btn-warning">Reset</button>
				</div>
			</div>
		</form>
	</div>
	<!--end::Form-->
</div>
</div>
@section('scripts')
<script src="{{$asset_url}}plugins/dropify/dist/js/dropify.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.js" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		$('#summernote').summernote();
		$('.dropify').dropify();
	});
</script>
@endsection
@endsection
