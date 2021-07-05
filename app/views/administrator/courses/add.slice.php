@extends('base.default.app')
@section('ext_css')
<link href="{{$asset_url}}plugins/gijgo/css/gijgo.min.css" rel="stylesheet" />
<link href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.css" rel="stylesheet" type="text/css" />
<link href="{{$asset_url}}plugins/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">{{$PAGE_HEADER}}</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tambahkan {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-success btn-border btn-round btn-sm">
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
                    <a class="nav-link active show" id="pills-basic-tab" data-toggle="pill" href="#basic" role="tab" aria-controls="basic" aria-selected="true">
                        <i class="fa fa-pen fa-sm mr-2"></i>
                        <b>Utama</b>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link " id="pills-requirements-tab" data-toggle="pill" href="#requirements" role="tab" aria-controls="requirements" aria-selected="false">
                        <i class="fa fa-file-pdf fa-sm mr-2"></i>
                        <b>Persyaratan</b>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link " id="pills-outcomes-tab" data-toggle="pill" href="#outcomes" role="tab" aria-controls="outcomes" aria-selected="false">
                        <i class="fa fa-sign-out-alt fa-sm mr-2"></i>
                        <b>Luaran</b>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link " id="pills-pricing-tab" data-toggle="pill" href="#pricing" role="tab" aria-controls="pricing" aria-selected="false">
                        <i class="fa fa-money-check fa-sm mr-2"></i>
                        <b>Harga</b>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link " id="pills-media-tab" data-toggle="pill" href="#media" role="tab" aria-controls="media" aria-selected="false">
                        <i class="fa fa-video fa-sm mr-2"></i>
                        <b>Media</b>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link " id="pills-seo-tab" data-toggle="pill" href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                        <i class="fa fa-tags fa-sm mr-2"></i>
                        <b>SEO</b>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link " id="pills-finish-tab" data-toggle="pill" href="#finish" role="tab" aria-controls="finish" aria-selected="false">
                        <i class="fa fa-check-double fa-sm mr-2"></i>
                        <b>Selesai</b>
                    </a>
                </li>
            </ul>
            <form method="POST" action="{{$PAGE_URL.'add_process'}}" enctype="multipart/form-data">
                <div class="card-body">
                    <!--begin::Form-->
                    {{ csrf_token() }}
                    <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="basic" role="tabpanel" aria-labelledby="pills-basic-tab">
                            <div class="form-group row">
                                <div class="col-lg-6">
								<label>Judul Pelatihan *</label>
                                    <input type="text" name="title" class="form-control {{error_form_class('title')}}" placeholder="Masukan Judul Pelatihan" value="{{old_input('title') ?? ''}}">
                                    <div class="error text-danger">{{error_form('title') ?? ''}}</div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="">Pilih Mentor *</label>
                                    <select name="fasilitator_id" class="select-2 " style="width:100%" data-allow-clear="true">
                                        <option value=""> Silahkan Pilih </option>
                                        @foreach ($rs_teacher as $item => $row)
                                        <option value="{{$row->user_id}}" {{ set_select(old_input('fasilitator_id') , $row->user_id) }}>{{$row->full_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="error text-danger">{{error_form('fasilitator_id') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="">Tingkatan Pelatihan Untuk *</label>
                                    <select name="level" class="select-2 " style="width:100%" data-allow-clear="true">
                                        <option value=""> Silahkan Pilih </option>
                                        <option value="beginner" {{ set_select(old_input('level') , 'beginner' ) }}> Pemula </option>
                                        <option value="intermediate" {{ set_select(old_input('level') , 'intermediate' ) }}> Menengah </option>
                                        <option value="advanced" {{ set_select(old_input('level') , 'advanced' ) }}> Mahir </option>
                                    </select>
                                    <div class="error text-danger">{{error_form('level') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Deskripsi Pelatihan *</label>
                                    <textarea class="form-control {{error_form_class('description')}}" name="description" cols="30" rows="10" placeholder="Masukan Deskripsi Pelatihan">{{old_input('description') ?? ''}}</textarea>
                                    <div class="error text-danger">{{error_form('description') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Untuk Siapa Pelatihan Ini *</label>
                                    <textarea class="form-control {{error_form_class('summary')}}" id="summernote" name="summary" cols="30" rows="10" placeholder="Masukan Untuk Siapa Pelatihan Ini">{{old_input('summary') ?? ''}}</textarea>
                                    <div class="error text-danger">{{error_form('summary') ?? ''}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="pills-requirements-tab">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Persyaratan Mengambil Pelatihan Ini</label>
                                    <div id="requirement_area" class="d-flex flex-column-reverse">
                                        @if (count((array)old_input('requirements')) > 0)
                                            @php $counter = 0; @endphp
                                            @foreach (old_input('requirements') as $item)
                                                @if ($counter == 0)
                                                @php $counter++ @endphp
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="Berikan Persyaratan" value="{{$item}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success btn-sm" style="" name="button" onclick="appendRequirement()"> <i class="fa fa-plus"></i> </button>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="Berikan Persyaratan" value="{{$item}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeRequirement(this)"> <i class="fa fa-minus"></i> </button>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="Berikan Persyaratan">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-sm" style="margin-top: 0px;" name="button" onclick="appendRequirement(this)"> <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        @endif
                                        <div id="blank_requirement_field" style="display: none;">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="Berikan Persyaratan" autofocus>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeRequirement(this)"> <i class="fa fa-minus"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="outcomes" role="tabpanel" aria-labelledby="pills-outcomes-tab">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Yang Akan Dipelajari Di Pelatihan Ini</label>
                                    <div id="outcomes_area" class="d-flex flex-column-reverse">
                                        @if (count((array)old_input('outcomes')) > 0)
                                            @php $counter = 0; @endphp
                                            @foreach (old_input('outcomes') as $item)
                                                @if ($counter == 0)
                                                @php $counter++ @endphp
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder="Hal Yang Dipelajari" value="{{$item}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success btn-sm" style="" name="button" onclick="appendOutcome()"> <i class="fa fa-plus"></i> </button>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder="Hal Yang Dipelajari" value="{{$item}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeOutcome(this)"> <i class="fa fa-minus"></i> </button>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder="Hal Yang Dipelajari">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-sm" style="margin-top: 0px;" name="button" onclick="appendOutcome(this)"> <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        @endif
                                        <div id="blank_outcome_field" style="display: none;">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder="Hal Yang Dipelajari *" autofocus>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeOutcome(this)"> <i class="fa fa-minus"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pills-pricing-tab">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="custom-control-input" name="is_free_course" id="is_free_course" value="1" onclick="isFreeCourseChecked(this.id)">
                                            <span class="form-check-sign">Apakah Pelatihan Ini Gratis ?</span>
                                        </label>
                                    </div> 
                                    <div class="form-group" id="price_form">
                                        <label>Harga </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" id="withdiscount" name="price" placeholder="Masukan Harga Pelatihan" min="0" value="{{old_input('price') ?? ''}}">
                                            <div class="error text-danger">{{error_form('price') }}</div>
                                        </div>
                                        <div class="error text-danger">{{error_form('price') }}</div>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="custom-control-input" name="discount_flag" id="discount_flag" value="1" onclick="isDiscountPriceChecked(this.id)">
                                            <span class="form-check-sign">Apakah Pelatihan Ini Diskon ?</span>
                                        </label>
                                    </div> 
                                    
                                    <div class="form-group" id="discount_form" style="display:none">
                                        <label>Harga Setelah Diskon </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Masukan Harga Diskon" min="0" onkeyup="calculateDiscountPercentage(this.value)">
                                        </div>
                                        <div class="error text-danger">{{error_form('discount_price') }}</div>
                                        <small class="text-muted">Pelatihan ini diskon <span class="text-danger" id="discounted_percentage"> 0% </span></small>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="pills-media-tab">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Penyedia Cuplikan Pelatihan </label>
                                    <select class="form-control select-2" name="course_overview_provider" style="width:100%">
                                        <option value="youtube" {{set_select(old_input('course_overview_provider'),'youtube')}}>Youtube</option>
                                    </select>
                                    <div class="error text-danger">{{error_form('course_overview_provider') ?? ''}}</div>
                                </div>
                                <div class="col-md-6">
                                    <label>URL Cuplikan Pelatihan </label>
                                    <input type="url" class="form-control {{error_form_class('course_overview_url')}}" name="course_overview_url" placeholder="E.g: https://www.youtube.com/watch?v=oBtf8Yglw2w" value="{{old_input('course_overview_url')}}">
                                    <div class="error text-danger">{{error_form('course_overview_url') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Thumbnail Pelatihan </label>
                                    <input type="file" class="dropify {{error_form_class('course_overview_thumbnail')}}" name="course_overview_thumbnail" data-show-errors="true" data-allowed-file-extensions="jpeg jpg png" data-allowed-formats="landscape" data-max-file-size="1M" data-max-width="1920" data-max-height="1080" data-default-file="{{$asset_url}}img/640x360.jpg">
                                    <br/><small>Format (jpg, jpeg, png) dengan maks. 1MB & Landscape (16:9)</small>
                                    <div class="error text-danger">{{error_form('course_overview_thumbnail') ?? ''}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="pills-seo-tab">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Meta Kata Kunci</label>
                                    <input type="text" class="form-control" name="meta_keywords" value="{{old_input('meta_keywords')}}" data-role="tagsinput">
                                    <div class="error text-danger">{{error_form('meta_keywords') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Meta Deskripsi</label>
                                    <textarea class="form-control" name="meta_description" cols="30" rows="10">{{old_input('meta_description')}}</textarea>
                                    <div class="error text-danger">{{error_form('meta_description') ?? ''}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="finish" role="tabpanel" aria-labelledby="pills-finish-tab">
                            <div class="form-check">
                                <div class="col-md-4">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="custom-control-input" name="is_top_course" id="is_top_course" value="1" >
                                        <span class="form-check-sign">Apakah Pelatihan ini unggulan ?</span>
                                    </label>
                                    <div class="error text-danger">{{error_form('is_top_course') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Status Pelatihan</label>
                                    <select name="course_st" class="select-2 " style="width:100%" data-placeholder="Masukan Harga Pelatihan" data-allow-clear="true">
                                        <option value="1" {{ set_select(old_input('course_st') , 1 ) }}> Diterbitkan </option>
                                        <option value="0" {{ set_select(old_input('course_st') , 0 ) }}> Draft </option>
                                    </select>
                                    <div class="error text-danger">{{error_form('course_st') ?? ''}}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <h3 class="mt-0">Simpan Perubahan</h3>
                                    <p class="w-75 mb-2 ">Pastikan informasi yang dibutuhkan sudah lengkap.</p>
                                    <div class="mb-3 mt-3">
                                        <button type="submit" class="btn btn-primary text-center">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <i> (*) Wajib Diisi </i>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('ext_js')
<script src="{{$asset_url}}plugins/gijgo/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/dropify/dist/js/dropify.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/bootstrap4-tagsinput/tagsinput.js" type="text/javascript"></script>
<script src="{{$asset_url}}plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
        $('#start_date').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            disableDates: function(date) {
                const currentDate = new Date().setHours(0, 0, 0, 0);
                return date.setHours(0, 0, 0, 0) >= currentDate ? true : false;
            },
        });
        $('#end_date').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            disableDates: function(date) {
                const currentDate = new Date().setHours(0, 0, 0, 0);
                return date.setHours(0, 0, 0, 0) >= currentDate ? true : false;
            },
        });
        $('.dropify').dropify();
    });
    var blank_outcome = jQuery('#blank_outcome_field').html();
    var blank_requirement = jQuery('#blank_requirement_field').html();
    $(document).ready(function() {
        $('#blank_outcome_field').hide();
        $('#blank_requirement_field').hide();
    });

    function appendOutcome() {
        $('#outcomes_area').append(blank_outcome);
    }

    function removeOutcome(outcomeElem) {
        $(outcomeElem).parent().parent().remove();
    }

    function appendRequirement() {
        $('#requirement_area').append(blank_requirement);
    }

    function removeRequirement(requirementElem) {
        $(requirementElem).parent().parent().remove();
    }

    $(document).ready(function() {
        $("#withoutdiscount").on("input", function() {
            verify()
        });
    });

    function isFreeCourseChecked(elem) {
		// alert(elem);
        if($("#"+elem).is(':checked')){
            $('#price_form').hide();
        }else {
            $('#price_form').show();
        }
    }

    function isDiscountPriceChecked(elem) {
        if($("#"+elem).is(':checked')){
            $('#discount_form').show();
        }else {
            $('#discount_form').hide();
        }
    }

    function calculateDiscountPercentage(discount_price) {
        if (discount_price > 0) {
            var actualPrice = jQuery('#price').val();
            if (actualPrice > 0) {
                var reducedPrice = actualPrice - discount_price;
                var discountedPercentage = (reducedPrice / actualPrice) * 100;
                if (discountedPercentage > 0) {
                    jQuery("#discounted_percentage").text(discountedPercentage.toFixed(2) + "%");
                } else {
                    jQuery("#discounted_percentage").text("0 %");
                }
            }
        }
    }
    function verify() {
        var firstValue = parseInt($("#withoutdiscount").val());
        var secondValue = parseInt($("#withdiscount").val());
        if (firstValue > secondValue) {
            text = "";
        } else {
            text = "Harga Tanpa Diskon Harus Lebih Besar Dari Harga Dengan Diskon / Harga Gratis";
        }
        document.getElementById("checkmessage").innerHTML = text;
    }
   
</script>
@endsection
