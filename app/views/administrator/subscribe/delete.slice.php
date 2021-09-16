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
            <input type="hidden" name="id" value="{{$result['id']}}">
            <div class="card-body">
			<div class="row">
					<div class="col-6">
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Nama*</label>
								<input disabled type="text" name="full_name" class="form-control {{error_form_class('full_name')}}"
									placeholder="Masukan Nama" value="{{$result['full_name'] ?? ''}}">
								<div class="error text-danger">{{error_form('full_name') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Tanggal Enroll *</label>
								<input disabled type="text" name="enroll_date" class="form-control {{error_form_class('enroll_date')}}"
									value="{{$result['enroll_date'] ?? ''}}">
								<div class="error text-danger">{{error_form('enroll_date') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Total Payment *</label>
								<input disabled type="number" name="total_payment" class="form-control {{error_form_class('total_payment')}}"
									value="{{$result['total_payment'] ?? ''}}">
								<div class="error text-danger">{{error_form('total_payment') ?? ''}}</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Tanggal Mulai Aktif *</label>
								<input disabled type="date" name="start_date" class="form-control {{error_form_class('start_date')}}"
									value="{{$result['start_date'] ?? ''}}">
								<div class="error text-danger">{{error_form('start_date') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label>Tanggal Terakhir Aktif *</label>
								<input disabled type="date" name="end_date" class="form-control {{error_form_class('end_date')}}"
									value="{{$result['end_date'] ?? ''}}">
								<div class="error text-danger">{{error_form('end_date') ?? ''}}</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="">Status Enroll *</label>
								<select disabled name="payment_st" class="select-2 " style="width:100%">
									<option value="0"> Pilih Kategori </option>
									<option value="paid" {{ set_select($result['payment_st'] , 'paid') }}> Paid </option>
									<option value="unpaid" {{ set_select($result['payment_st'] , 'unpaid') }}> Unpaid </option>
								</select>
								<div class="error text-danger">{{error_form('payment_st') ?? ''}}</div>
							</div>
						</div>
					</div>
					<div class="card-action">
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
					</div>
				</div>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
	$(document).ready(function () {
		// $('#summernote').summernote({
        //     height: 150
        // });  
		$('#summernote').summernote('disable');

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
