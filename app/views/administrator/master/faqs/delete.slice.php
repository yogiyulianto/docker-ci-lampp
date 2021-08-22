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
            <div class="card-title">Hapus {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <!--begin::Form-->
        <form class="" method="POST" action="{{$PAGE_URL.'delete_process'}}" onsubmit="return confirm('Apakah anda yakin akan menghapus data dibawah ini?');">
            {{ csrf_token() }}
            <input type="hidden" name="id_faq" value="{{$result['id_faq']}}">
            <div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Judul*</label>
								<input type="text" name="judul" readonly class="form-control {{error_form_class('judul')}}"
									placeholder="Masukan Judul" value="{{$result['judul'] ?? ''}}">
								<div class="error text-danger">{{error_form('judul') ?? ''}}</div>
							</div>
							<div class="col-lg-6">
								<label class="">Status *</label>
								<select name="stat" disabled class="select-2 " style="width:100%">
									<option value="0"> Pilih Status </option>
									<option value="published" {{ set_select($result['stat'] , 'published') }}> Publish </option>
									<option value="unpublished" {{ set_select($result['stat'] , 'unpublished') }}> Belum dipublish </option>
								</select>
								<div class="error text-danger">{{error_form('stat') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Isi *</label>
								<textarea readonly class="form-control {{error_form_class('isi')}}" id="summernote" name="isi" cols="30" rows="10" placeholder="Masukan Isi" >{{$result['isi'] ?? ''}}</textarea>
								<div class="error text-danger">{{error_form('isi') ?? ''}}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="card-action">
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
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
		$('#summernote').summernote('disable');
		$('.dropify').dropify();
	});
</script>
@endsection
