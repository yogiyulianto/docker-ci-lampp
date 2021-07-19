@extends('base.default.app')

<link href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
					<div class="col-8">
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Judul*</label>
								<input type="text" name="title" class="form-control {{error_form_class('title')}}"
									placeholder="Masukan Judul" value="{{old_input('title') ?? ''}}">
								<div class="error text-danger">{{error_form('title') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Deskripsi *</label>
								<textarea class="form-control {{error_form_class('description')}}" id="summernote" name="description" cols="30" rows="10" placeholder="Masukan Deskripsi" >{{old_input('description') ?? ''}}</textarea>
								<div class="error text-danger">{{error_form('description') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label>Link*</label>
								<input type="text" class="form-control" name="link" value="{{old_input('link')}}">
								<div class="error text-danger">{{error_form('link') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label>Jadwal*</label>
								<input type="text" class="form-control datetime" autocomplete="off" placeholder="Pilih tanggal" name="jadwal"
									value="{{old_input('jadwal')}}">
									<!-- <div class="input-group date" data-provide="datepicker">
										<input type="text" class="form-control">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div> -->
								<div class="error text-danger">{{error_form('jadwal') ?? ''}}</div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Kategori Webinar *</label>
								<select name="pricing_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Kategori </option>
									<option value="free" {{ set_select(old_input('pricing_st') , 'free') }}> Free </option>
									<option value="premium" {{ set_select(old_input('pricing_st') , 'premium') }}> Premium </option>
								</select>
								<div class="error text-danger">{{error_form('pricing_st') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Status Webinar *</label>
								<select name="webinar_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="published" {{ set_select(old_input('webinar_st') , 'published') }}> Published </option>
									<option value="draft" {{ set_select(old_input('webinar_st') , 'draft') }}> Draft </option>
								</select>
								<div class="error text-danger">{{error_form('webinar_st') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label>Gambar*</label><small> Hanya Gambar (jpg, jpeg, png) maks. 3MB Resolusi
									1000x1000px</small>
								<input type="file" class="dropify {{error_form_class('image')}}" name="image"
									data-show-errors="true" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="10M"
									data-max-width="3000" data-max-height="3000">
								<div class="error text-danger">{{error_form('image') ?? ''}}</div>
							</div>
						</div>
						<div class="card-action">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-warning">Reset</button>
						</div>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
	$(document).ready(function () {
		$('#summernote').summernote({
            height: 150
        });  
		$('.dropify').dropify();
		$(".datetime").flatpickr({
			enableTime: true,
		    dateFormat: "Y-m-d H:i",
		    minToday: true,
			altFormat: "F j, Y H:i"
		});
	});
</script>
@endsection
