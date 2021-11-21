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
			<input type="hidden" name="id" value="{{$result['id']}}">
			<div class="card-body">
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
							<div class="col-lg-12">
								<label>Sub Judul*</label>
								<input type="text" name="subtitle" class="form-control {{error_form_class('subtitle')}}"
									placeholder="Masukan Sub Judul" value="{{$result['subtitle'] ?? ''}}">
								<div class="error text-danger">{{error_form('subtitle') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Kategori Materi *</label>
								<select name="id_kategori" class="select-2" style="width:100%" >
									<option value="0"> * </option>
									@foreach ($rs_category as $item)
									<option value="{{$item['id_kategori']}}"
										{{ set_select($result['id_kategori'] , $item['id_kategori']) }}>{{$item['deskripsi']}}
									</option>
									@endforeach
								</select>
								<div class="error text-danger">{{error_form('id_kategori') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Konten *</label>
								<textarea class="form-control {{error_form_class('content')}}" name="content"
									cols="30" rows="10"
									placeholder="Masukan Konten Blog">{{$result['description'] ?? ''}}</textarea>
								<div class="error text-danger">{{error_form('content') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label>Gambar*</label><small> Hanya Gambar (jpg, jpeg, png) maks. 3MB Resolusi
									1000x1000px</small>
								<input type="file" class="dropify {{error_form_class('img')}}" name="img"
									data-show-errors="true" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="10M"
									data-max-width="3000" data-max-height="3000" data-default-file="{{$result['image_url']}}">
								<div class="error text-danger">{{error_form('img') ?? ''}}</div>
							</div>
							<div class="col-md-6">
								<label>Urutan*</label>
								<input type="text" name="order_no" class="form-control {{error_form_class('order_no')}}"
									placeholder="Urutan" value="{{$result['order_no'] ?? ''}}">
								<div class="error text-danger">{{error_form('order_no') ?? ''}}</div>
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