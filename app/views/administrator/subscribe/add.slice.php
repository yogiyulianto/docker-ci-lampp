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
					<div class="col-6">
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">User *</label>
								<select name="user_id" class="select-2 " style="width:100%">
									<option value="0"> Pilih User </option>
									@foreach ($rs_user as $item)
									<option value="{{$item['user_id']}}"
										{{ set_select(old_input('user_id') , $item['user_id']) }}>{{$item['full_name']}}
									</option>
									@endforeach
								</select>
								<div class="error text-danger">{{error_form('user_id') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Tanggal Mulai Aktif *</label>
								<input type="date" name="start_date" class="form-control {{error_form_class('start_date')}}"
									value="{{old_input('start_date') ?? ''}}">
								<div class="error text-danger">{{error_form('start_date') ?? ''}}</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Status Enroll *</label>
								<select name="payment_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Kategori </option>
									<option value="paid" {{ set_select(old_input('payment_st') , 'paid') }}> Paid </option>
									<option value="unpaid" {{ set_select(old_input('payment_st') , 'unpaid') }}> Unpaid </option>
								</select>
								<div class="error text-danger">{{error_form('payment_st') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Tanggal Mulai Selesai *</label>
								<input type="date" name="end_date" class="form-control {{error_form_class('end_date')}}"
									value="{{old_input('end_date') ?? ''}}">
								<div class="error text-danger">{{error_form('end_date') ?? ''}}</div>
							</div>
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
