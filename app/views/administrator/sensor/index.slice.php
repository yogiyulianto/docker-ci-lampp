@extends('base.default.app')
@section('content')
<div class="page-inner">
	<div class="page-header d-none d-sm-flex">
		<h4 class="page-title">{{$PAGE_HEADER}}</h4>
		@include('base.default.breadcrumb')
	</div>
	@include('base.default.notification')
	<div class="card">
		<div class="card-header">
			<div class="card-title">{{$PAGE_TITLE }} Page
				<a href="{{$PAGE_URL}}" class="float-right btn btn-success btn-border btn-round btn-sm">
					<span class="btn-label">
						<i class="las la-angle-left"></i>
					</span>
					Kembali
				</a>
			</div>
		</div>

		<div id="courseWizard">
			<ul class="nav nav-pills nav-primary nav-justified" id="pills-tab" role="tablist">
				<li class="nav-item submenu">
					<a class="nav-link active show" id="pills-curriculum-tab" data-toggle="pill" href="#suhu" role="tab" aria-controls="curriculum" aria-selected="true">
						<i class="fa fa-user-circle fa-sm mr-2"></i>
						<b>Suhu</b>
					</a>
				</li>
				<li class="nav-item submenu">
					<a class="nav-link " id="pills-basic-tab" data-toggle="pill" href="#ph" role="tab" aria-controls="basic" aria-selected="true">
						<i class="fa fa-pen fa-sm mr-2"></i>
						<b>pH</b>
					</a>
				</li>
				<li class="nav-item submenu">
					<a class="nav-link " id="pills-requirements-tab" data-toggle="pill" href="#air" role="tab" aria-controls="requirements" aria-selected="false">
						<i class="fa fa-file-pdf fa-sm mr-2"></i>
						<b>Ketinggian Air</b>
					</a>
				</li>
			</ul>
			<div class="card-body">
				<!--begin::Form-->
				<div class="tab-content mt-2 mb-3" id="pills-tabContent">
				<div class="tab-pane fade" id="outcomes" role="tabpanel" aria-labelledby="pills-outcomes-tab">
			
				<div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" class="text-center">No</th>
                            <th style="vertical-align: middle" class="text-center">Nama</th>
                            <th style="vertical-align: middle" class="text-center">Image</th>
							<th style="vertical-align: middle" class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
	</div>
		<div class="tab-pane fade active show" id="suhu" role="tabpanel" aria-labelledby="pills-curriculum-tab">
			<div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="10%">Nomor</th>
                            <th width="40%">Tanggal</th>
                            <th width="25%">Jam</th>
                            <th width="25%">Suhu</th>
                        </tr>
                    </thead>
                    <tbody>
						@php $no = 1; @endphp
                        @foreach ($suhu as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{date('d-m-Y', strtotime($item['datetime']))}}</td>
                            <td>{{date('H:i:s', strtotime($item['datetime']))}}</td>
                            <td>{{$item['celcius']}} C</td>
						</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>
		<div class="tab-pane fade " id="ph" role="tabpanel" aria-labelledby="pills-basic-tab">
			<div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="10%">Nomor</th>
                            <th width="40%">Tanggal</th>
                            <th width="25%">Jam</th>
                            <th width="25%">pH</th>
                        </tr>
                    </thead>
                    <tbody>
						@php $no = 1; @endphp
                        @foreach ($ph as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{date('d-m-Y', strtotime($item['datetime']))}}</td>
                            <td>{{date('d-m-Y', strtotime($item['datetime']))}}</td>
                            <td>{{$item['ph']}}</td>
						</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>
		<div class="tab-pane fade " id="air" role="tabpanel" aria-labelledby="pills-requirements-tab">
		<div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="10%">Nomor</th>
                            <th width="40%">Tanggal</th>
                            <th width="25%">Jam</th>
                            <th width="25%">Ketinggian Air</th>
                        </tr>
                    </thead>
                    <tbody>
						@php $no = 1; @endphp
                        @foreach ($ketinggian as $item)
                        <tr>
							<td>{{$no++}}</td>
                            <td>{{date('d-m-Y', strtotime($item['datetime']))}}</td>
                            <td>{{date('d-m-Y', strtotime($item['datetime']))}}</td>
                            <td>{{$item['ketinggian']}}</td>
						</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>
		</div>
	</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link href="{{$asset_url}}plugins/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css">
<script src="{{$asset_url}}plugins/dropify/dist/js/dropify.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#summernote').summernote({
			placeholder: 'Deskripsi',
			tabsize: 2,
			height: 200
		});
		$('#summernotem').summernote({
			placeholder: 'Deskripsi',
			tabsize: 2,
			height: 200
		});
		$('#summernotea').summernote({
			placeholder: 'Deskripsi',
			tabsize: 2,
			height: 200
		});
		$('#summernoteb').summernote({
			placeholder: 'Deskripsi',
			tabsize: 2,
			height: 200
		});
		$('#summernotec').summernote({
			placeholder: 'Deskripsi',
			tabsize: 2,
			height: 200
		});
		$('#summernoted').summernote({
			placeholder: 'Deskripsi',
			tabsize: 2,
			height: 200
		});
		$('.dropify').dropify();
	});
	function actControl(x, y, z, xy) {

	if (x == 'edit_choose') {
		console.log(y);
		

	} else if(x == 'edit_choose_image'){
		console.log(y)

	}

}
function editImage(id) {
	getImage(id);
}

function editData(id) {
	getData(id);
}

	// Want to use async/await? Add the `async` keyword to your outer function/method.
	async function getData(id) {
	try {
		const response = await axios.get("<?php echo base_url() ?>/administrator/cms/landing/edit_choose" + (!id ? "" : "?idx=" + id));
		var data = response.data;

		console.log(data);

		if (data.status == 'Gagal') {
			alert(data.message)
		}

		$('#choose_id').val(data.id);
		$('#choose_title').val(data.title);
		$('#summernotem').summernote('code', data.description);
		// show modal
		$('#modaledit').modal('show');

	} catch (error) {
		console.error(error);
	}
}

// Want to use async/await? Add the `async` keyword to your outer function/method.
async function getImage(id) {
	try {
		const response = await axios.get("<?php echo base_url() ?>/administrator/cms/landing/edit_choose_image" + (!id ? "" : "?idx=" + id));
		var data = response.data;

		console.log(window.location.pathname.split( '/' ));

		if (data.status == 'Gagal') {
			alert(data.message)
		}

		$('#image_id').val(data.id);
		$('#image_title').val(data.title);
		$('#imgz').val(data.image)
		$("#imgzz").attr("data-default-file", "<?php echo base_url(); ?>"+data.image);
		$('.dropifyz').dropify();

		// show modal
		$('#modalimage').modal('show');

	} catch (error) {
		console.error(error);
	}
}

</script>
@endsection
