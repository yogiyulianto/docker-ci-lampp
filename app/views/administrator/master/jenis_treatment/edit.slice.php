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
            <div class="card-title">Edit {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-default btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <form id="form" method="POST" action="{{$PAGE_URL.'edit_process'}}" >
            <input type="hidden" name="jenis_treatment_id" value="{{$result['jenis_treatment_id']}}">
            {{ csrf_token() }}
            <div class="card-body">
            <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Nama Jenis Treatment*</label>
                        <input type="text" id="nama" name="nama" class="form-control {{error_form_class('nama')}}" placeholder="Masukkan Nama Jenis Jenis Treatment" value="{{$result['nama'] ?? ''}}" required>
                        <label for="nama" class="error text-danger">{{error_form('nama') ?? ''}}</label>
                    </div>
                    <div class="col-lg-6">
                        <label>Jenis Kelamin</label>
                        <select name="type" class="select-2" style="width:100%" data-placeholder="Masukkan Jenis Treatment">
                            <option value="">Masukkan Jenis Treatment</option>
                            <option value="bahan" {{ set_select($result['type'] ?? '' , 'bahan') }}>Bahan</option>
                            <option value="jasa" {{ set_select($result['type'] ?? '' , 'jasa') }}>Jasa</option>
                        </select>
                        <label for="" class="error text-danger">{{error_form('type') ?? ''}}</label>
                    </div>
                </div>	                 
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">Satuan</label>
                        <input type="text" id="satuan" name="satuan" class="form-control {{error_form_class('satuan')}}" placeholder="Masukkan Satuan" value="{{$result['satuan'] ?? ''}}">
                        <label for="satuan" class="error text-danger">{{error_form('satuan') ?? ''}}</label>
                    </div>
                    <div class="col-lg-6">
                        <label class="">Harga</label>
                        <input type="number" id="harga" name="harga" class="form-control {{error_form_class('harga')}}" placeholder="Masukkan Harga" value="{{$result['harga'] ?? ''}}">
                        <label for="satuan" class="error text-danger">{{error_form('harga') ?? ''}}</label>
                    </div>
                </div>	                  
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#form").validate();
    });
</script>
@endsection