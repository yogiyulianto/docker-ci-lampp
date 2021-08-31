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
			<div class="card-title">Detail {{$PAGE_HEADER }}
				<a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
					<span class="btn-label">
						<i class="las la-angle-left"></i>
					</span>
					Kembali
				</a>
                <button type="button" class="float-right btn btn-primary btn-border btn-round btn-sm" style="margin-right:12px" data-toggle="modal" data-target="#exampleModal">
                    <span class="btn-label">
						<i class="las la-comments"></i>
					</span>
					Buat Balasan
                </button>
				<!-- <a href="{{$PAGE_URL.''}}" class="float-right btn btn-primary btn-border btn-round btn-sm" style="margin-right:12px">
					<span class="btn-label">
						<i class="las la-comments"></i>
					</span>
					Buat Balasan
				</a> -->
			</div>
		</div>
		<!--begin::Form-->
		<form class="" method="POST" action="{{$PAGE_URL.'edit_process'}}" enctype="multipart/form-data">
			{{ csrf_token() }}
			<!-- <input type="hidden" name="blog_id" value="{{$result['blog_id']}}"> -->
			<div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ol class="activity-feed">
                            @foreach ($rs_id as $item)
                            <li class="feed-item @if($item['message_type'] === 'question')feed-item-success @else feed-item-primary @endif">
                                <time class="date" datetime="9-25">{{$item['message_date']}}</time>
                                <span class="text">{{$item['mdb_name']}} mengirim pesan berisi: <a href="#">"{{$item['message']}}"</a></span>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
		</form>
	</div>
	<!--end::Form-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Balasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" method="POST" action="{{$PAGE_URL.'add_process'}}" enctype="multipart/form-data">
			{{ csrf_token() }}
            <div class="modal-body">
                <div class="modal-dialog modal-lg">
                    <input type="hidden" name="chat_id" value="{{$chat_id}}" />
                    <div class="form-group row">
                        <label>Pesan*</label>
                        <input type="text" required class="form-control input-lg" name="message" value="{{old_input('message')}}" placeholder="Masukan pesan..">
                        <!-- <textarea class="form-control" name="content" cols="30" rows="10" placeholder="Masukan Konten Blog"></textarea> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Kirim pesan</button>
            </div>
</form>
        </div>
    </div>
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