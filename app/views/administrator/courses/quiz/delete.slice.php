@extends('base.default.app')
@section('ext_css')
<link href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">Kuis</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Hapus Kuis
                <a href="{{$PAGE_URL.'edit/'.$course_id}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <form method="POST" action="{{$PAGE_URL.'delete_quiz_process'}}" enctype="multipart/form-data" onsubmit="return confirm('Apakah anda yakin akan menghapus data dibawah ini?');">
            <input type="hidden" name="course_id" value="{{$course_id}}" >
            <input type="hidden" name="lesson_id" value="{{$result['lesson_id']}}" >
            <div class="card-body">
                <!--begin::Form-->
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Judul Kuis*</label>
                        <input type="text" name="title" class="form-control {{error_form_class('title')}}" placeholder="Masukan Judul Kuis" value="{{$result['title'] ?? ''}}" disabled>
                        <div class="error text-danger">{{error_form('title') ?? ''}}</div>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Bab *</label>
                        <select name="section_id" class="select-2" style="width:100%" disabled>
                            <option value=""> * </option>
                            @foreach ($rs_section as $item)
                            <option value="{{$item['section_id']}}" {{ set_select($result['section_id'] , $item['section_id']) }}> {{$item['title']}} </option>
                            @endforeach
						</select>
                        <div class="error text-danger">{{error_form('lesson_type') ?? ''}}</div>
                    </div>
                </div>      
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ringkasan *</label>
                        <textarea name="summary" class="form-control {{error_form_class('summary') ?? ''}}" id="" cols="30" rows="10" disabled>{{$result['summary'] ?? ''}}</textarea>
                        <div class="error text-danger">{{error_form('attachment') ?? ''}}</div>
                    </div>
                </div>
                <!--end::Form-->
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('ext_js')
<script src="{{$asset_url}}plugins/dropify/dist/js/dropify.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){    
        $('.dropify').dropify();
    });
    function ajax_get_video_details(video_url) {
        if(checkURLValidity(video_url)){
            $.ajax({
                url: "{{ base_url('administrator/master/courses/ajax_get_video_details')}}",
                type : 'POST',
                data : {
                    video_url : video_url
                },
                success: function(response)
                {
                    jQuery('#duration').val(response);
                    $('#perloader').hide();
                    $('#invalid_url').hide();
                }
            });
        }else {
            $('#invalid_url').show();
            $('#perloader').hide();
            $('#duration').val('');
        }
    }

    function checkURLValidity(video_url) {
        var youtubePregMatch = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        var vimeoPregMatch = /^(http\:\/\/|https\:\/\/)?(www\.)?(vimeo\.com\/)([0-9]+)$/;
        if (video_url.match(youtubePregMatch)) {
            return true;
        }
        else if (vimeoPregMatch.test(video_url)) {
            return true;
        }
        else {
            return false;
        }
    }

    function show_lesson_type_form(param) {
        var checker = param.split('-');
        var lesson_type = checker[0];
        if (lesson_type === "video") {
            $('#other').hide();
            $('#video').show();
        }else if (lesson_type === "other") {
            $('#video').hide();
            $('#other').show();
        }else {
            $('#video').hide();
            $('#other').hide();
        }
    }

    function check_video_provider(provider) {
        if (provider === 'youtube' || provider === 'vimeo') {
            $('#html5').hide();
            $('#youtube_vimeo').show();
        }else if(provider === 'html5'){
            $('#youtube_vimeo').hide();
            $('#html5').show();
        }else {
            $('#youtube_vimeo').hide();
            $('#html5').hide();
        }
    }
</script>
@endsection