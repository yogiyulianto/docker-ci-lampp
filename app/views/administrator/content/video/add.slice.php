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
			<div class="card-title">Tambah {{$PAGE_HEADER }}
				<a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
					<span class="btn-label">
						<i class="las la-angle-left"></i>
					</span>
					Kembali
				</a>
			</div>
		</div>
		<form method="POST" action="{{$PAGE_URL.'add_process'}}" enctype="multipart/form-data">
			<div class="card-body">
				<!--begin::Form-->
				{{ csrf_token() }}
				<div class="row">
					<div class="col-12">
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Judul*</label>
								<input type="text" name="title" class="form-control {{error_form_class('title')}}"
									placeholder="Masukan Judul" value="{{old_input('title') ?? ''}}">
								<div class="error text-danger">{{error_form('title') ?? ''}}</div>
							</div>
							<div class="col-lg-6">
								<label class="">Pricing Status *</label>
								<select name="pricing_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="free" {{ set_select(old_input('pricing_st') , 'free') }}> Free </option>
									<option value="premium" {{ set_select(old_input('pricing_st') , 'premium') }}> Premium </option>
								</select>
								<div class="error text-danger">{{error_form('pricing_st') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label class="">Kategori Video *</label>
								<select name="category_id" class="select-2 " style="width:100%">
									<option value="0"> Pilih Kategori </option>
									@foreach ($rs_category as $item)
									<option value="{{$item['category_id']}}"
										{{ set_select(old_input('category_id') , $item['category_id']) }}>{{$item['title']}}
									</option>
									@endforeach
								</select>
								<div class="error text-danger">{{error_form('category_id') ?? ''}}</div>
							</div>
							<div class="col-lg-6">
								<label class="">Status Video *</label>
								<select name="video_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="published" {{ set_select(old_input('video_st') , 'published') }}> Published </option>
									<option value="draft" {{ set_select(old_input('video_st') , 'draft') }}> Draft </option>
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
									data-max-width="3000" data-max-height="3000">
								<div class="error text-danger">{{error_form('image') ?? ''}}</div>
							</div>
							<div class="col-md-6">
								<label>Video*</label><small> Hanya Video (avi, mp4) maks. 10MB </small>
								<input type="file" class="dropify {{error_form_class('video')}}" name="video"
									data-show-errors="true" data-allowed-file-extensions="avi mp4" data-max-file-size="10M">
								<div class="error text-danger">{{error_form('video') ?? ''}}</div>
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
</div>
@endsection

@section('scripts')
<script src="{{$asset_url}}plugins/dropify/dist/js/dropify.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.js" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		$('#summernote').summernote({
            height: 150
        });  
		$('.dropify').dropify();
	});
</script>
@endsection
