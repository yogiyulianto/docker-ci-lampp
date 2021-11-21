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
			<input type="hidden" name="id_kategori" value="{{$result['id_kategori']}}">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Deskripsi *</label>
								<textarea class="form-control {{error_form_class('deskripsi')}}" name="deskripsi"
									cols="30" rows="10"
									placeholder="Masukan Deskripsi">{{$result['deskripsi'] ?? ''}}</textarea>
								<div class="error text-danger">{{error_form('deskripsi') ?? ''}}</div>
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