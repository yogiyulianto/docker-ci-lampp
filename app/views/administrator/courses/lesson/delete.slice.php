@extends('base.default.app')
@section('ext_css')
<link href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">Materi</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Hapus Pelajaran
                <a href="{{$PAGE_URL.'edit/'.$course_id}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <form method="POST" action="{{$PAGE_URL.'delete_lesson_process'}}" enctype="multipart/form-data" onsubmit="return confirm('Apakah anda yakin akan menghapus data dibawah ini?');">
            <input type="hidden" name="course_id" value="{{$course_id}}" >
            <input type="hidden" name="lesson_id" value="{{$result['lesson_id']}}" >
            <div class="card-body">
                <!--begin::Form-->
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Judul Materi*</label>
                        <input type="text" name="title" class="form-control {{error_form_class('title')}}" placeholder="Masukan Judul Materi" value="{{$result['title'] ?? ''}}" disabled>
                        <div class="error text-danger">{{error_form('title') ?? ''}}</div>
                    </div>
                </div>    
                <div class="form-group row">
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
                    <div class="col-lg-6">
                        <label class="">Tipe Materi*</label>
                        <select name="lesson_type" class="select-2" id="lesson_type"  style="width:100%" onchange="show_lesson_type_form(this.value)" disabled>
                            <option value=""> * </option>
                            <option value="video-url" {{ set_select($result['lesson_type'] , 'video-url') }}> Video Url </option>
                            <option value="other-pdf" {{ set_select($result['lesson_type'] , 'other-pdf') }}>File PDF </option>
                            <option value="gdocs-docs" {{ set_select($result['lesson_type'] , 'gdocs-docs') }}> Google Docs </option>
                            <option value="gdocs-slide" {{ set_select($result['lesson_type'] , 'gdocs-slides') }}> Google Slides </option>
                            <option value="gdocs-sheets" {{ set_select($result['lesson_type'] , 'gdocs-sheets') }}> Google Sheets </option>
                            <option value="gdocs-pdf" {{ set_select($result['lesson_type'] , 'gdocs-pdf') }}> PDF from Gdrive </option>
						</select>
                        <div class="error text-danger">{{error_form('lesson_type') ?? ''}}</div>
                    </div>
                </div>      
                <div id="video" @if($result['lesson_type'] != 'video') style="display: none;" @endif >
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="">Penyedia Materi *</label>
                            <select name="lesson_provider" id="lesson_provider" class="select-2 " style="width:100%" onchange="check_video_provider(this.value)" disabled>
                                <option value=""> * </option>
                                <option value="youtube"  {{ set_select(strtolower($result['video_type']) , 'youtube') }}> Youtube </option>
                                <option value="vimeo"  {{ set_select(strtolower($result['video_type']) , 'vimeo') }}> Vimeo </option>
                            </select>
                            <div class="error text-danger">{{error_form('lesson_provider') ?? ''}}</div>
                        </div>
                    </div>
                    
                    <div id="youtube_vimeo" @if(strtolower($result['video_type']) == 'vimeo' || strtolower($result['video_type']) == 'youtube') @else style="display: none;" @endif>
                        <div class="form-group row"> 
                            <div class="col-lg-6">
                                <label>Video URL</label>
                                <input type="text" id ="video_url" name="video_url" class="form-control " onchange="ajax_get_video_details(this.value)" placeholder="Video ini akan muncul pada aplikasi" value="{{$result['video_url'] ?? ''}}" disabled>
                                <label class="error text-success" id = "perloader" ><i class="fa fa-sm fa-spinner fa-spin">&nbsp;</i>Proses pengecekan URL</label>
                                <div class="error text-danger" id = "invalid_url" >URL tidak sesuai, sumber video harus dari youtube atau vimeo</div>
                            </div>
                            <div class="col-lg-6">
                                <label>Durasi</label>
                                <input type="text" name = "duration" id = "duration" class="form-control " {{error_form_class('duration') ?? ''}} value="{{$result['duration'] ?? ''}}" disabled>
                                <div class="error text-danger">{{error_form('duration') ?? ''}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="gdocs" @if($result['lesson_type'] != 'gdocs') style="display: none;" @endif>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Preview *</label>
                            <div id="gdocs-wrapper">
                                <div class="gdocs-wrapper">
                                    @php echo $result['gdocs_url'] @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Embed Code Google Docs *</label>
                            <input type="text" class="form-control" name="gdocs_url" value="">
                            <div class="error text-danger">{{error_form('gdocs_url') ?? ''}}</div>
                        </div>
                    </div>
                </div>
                <div id="other" @if($result['lesson_type'] != 'other') style="display: none;" @endif>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Lampiran *</label>
                            <input type="file" class="form-control dropify" id="attachment" name="attachment" data-max-file-size="3M" data-allowed-file-extensions="pdf doc docx xls xlsx ppt pptx" disabled>
                            <div class="error text-danger">{{error_form('attachment') ?? ''}}</div>
                        </div>
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