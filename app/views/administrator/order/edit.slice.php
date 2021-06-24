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
            <div class="card-title">Tentukan Perawat
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-default btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <form id="form" method="POST" action="{{$PAGE_URL.'edit_process'}}" >
            <input type="hidden" name="order_id" value="{{$result['order_id']}}">
            {{ csrf_token() }}
            <div class="card-body">
            <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Pilih Perawat</label>
                        <select name="perawat" class="select-2" style="width:100%" data-placeholder="Pilih perawat">
                            <option value="">Pilih Perawat</option>
                            @foreach ($perawat as $item)
                            <option value="{{$item['user_id']}}">{{$item['full_name']}}</option>
                            @endforeach
                        </select>
                        <label for="" class="error text-danger">{{error_form('type') ?? ''}}</label>
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