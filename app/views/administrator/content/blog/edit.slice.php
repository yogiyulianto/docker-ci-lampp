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
			<input type="hidden" name="blog_id" value="{{$result['blog_id']}}">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Judul*</label>
								<input type="text" name="title" class="form-control {{error_form_class('title')}}"
									placeholder="Masukan Judul" value="{{$result['title'] ?? ''}}">
								<div class="error text-danger">{{error_form('title') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Konten *</label>
								<textarea class="form-control {{error_form_class('content')}}" id="summernote" name="content"
									cols="30" rows="10"
									placeholder="Masukan Konten Blog">{{$result['content'] ?? ''}}</textarea>
								<div class="error text-danger">{{error_form('content') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label>Meta Title*</label>
								<input type="text" class="form-control" name="meta_title" value="{{$result['meta_title']}}">
								<div class="error text-danger">{{error_form('meta_title') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label>Meta Keywords*</label>
								<input type="text" class="form-control" name="meta_keywords"
									value="{{$result['meta_keywords']}}" data-role="tagsinput">
								<div class="error text-danger">{{error_form('meta_keywords') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label>Meta Description*</label>
								<textarea class="form-control" name="meta_description" id="" cols="30"
									rows="10">{{$result['meta_description']}}</textarea>
								<div class="error text-danger">{{error_form('meta_description') ?? ''}}</div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Kategori Blog *</label>
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
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Status Blog *</label>
								<select name="blog_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="published" {{ set_select($result['blog_st'] , 'published') }}> Published </option>
									<option value="draft" {{ set_select($result['blog_st'] , 'draft') }}> Draft </option>
								</select>
								<div class="error text-danger">{{error_form('category_id') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Pricing status *</label>
								<select name="pricing_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="free" {{ set_select($result['pricing_st'] , 'free') }}> Free </option>
									<option value="premium" {{ set_select($result['pricing_st'] , 'premium') }}> Premium </option>
								</select>
								<div class="error text-danger">{{error_form('pricing_st') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Apakah termasuk artikel mingguan kehamilan? *</label>
								<select name="is_weekly_content" id="is_weekly_content" class="select-2 " style="width:100%">
									<option value=""> Pilih Artikel Mingguan</option>
									<option value="yes" {{ set_select($result['is_weekly_content'] , 'yes') }}> Ya </option>
									<option value="no" {{ set_select($result['is_weekly_content'] , 'no') }}> Tidak </option>
								</select>
								<div class="error text-danger">{{error_form('is_weekly_content') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Masukan minggu</label>
								<input disabled type="text" id="weekly_content" class="form-control" name="weekly_content" placeholder="Masukan Minggu"
									value="{{$result['weekly_content']}}" data-role="tagsinput">
								<div class="error text-danger">{{error_form('weekly_content') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group row">
								<div class="col-md-6">
									<label>Gambar*</label><small> Hanya Gambar (jpg, jpeg, png) maks. 10MB Resolusi
										1000x1000px</small>
									<input type="hidden" name="image" value="{{$result['image']}}">
									<input type="file" class="dropify {{error_form_class('image')}}" name="image"
										data-show-errors="true" data-allowed-file-extensions="jpeg jpg png"
										data-max-file-size="10M" data-max-width="3000" data-max-height="3000"
										data-default-file="{{base_url($result['image'])}}">
									<div class="error text-danger">{{error_form('image') ?? ''}}</div>
								</div>
							</div>
						</div>
						<div class="card-action">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-warning">Reset</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!--end::Form-->
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
		
		if($('#is_weekly_content').val() === 'yes'){
			$('#weekly_content').prop('disabled', false);
		}
	});

	$('#is_weekly_content').on('change', function() {
		if($(this).val() === 'yes'){
			$('#weekly_content').prop('disabled', false);
		} else {
			$('#weekly_content').prop('disabled', true);
			$('#weekly_content').prop('value', 0);
		}
	});
</script>
@endsection