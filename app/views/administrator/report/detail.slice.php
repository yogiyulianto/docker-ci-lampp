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
            <div class="card-title">Detail Peminjaman {{$result['peminjaman_kode']}}
                <a href="{{$PAGE_URL.''}}" class="float-right btn btn-default btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
                <a href="{{$PAGE_URL.'download_detail/'.$result['peminjaman_id']}}" class="btn btn-danger btn-round btn-sm mr-1 float-right ">
                    <span class="btn-label">
                        <i class="las la-file-pdf"></i>
                    </span>
                    Download Data
                </a>
            </div>
        </div>
        <form id="form" method="POST" action="{{$PAGE_URL.'review_process'}}">
            {{ csrf_token() }}
            <input type="hidden" name="peminjaman_id" value="{{$result['peminjaman_id']}}">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Kode Peminjaman*</label>
                        <input type="text" id="peminjaman_kode" name="peminjaman_kode" class="form-control {{error_form_class('peminjaman_kode')}}" placeholder="Masukkan Kode Peminjaman" value="{{$result['peminjaman_kode'] ?? ''}}" readonly>
                        <label for="peminjaman_kode" class="error text-danger">{{error_form('peminjaman_kode') ?? ''}}</label>
                    </div>
                    <div class="col-lg-6">
                        <label>Dasar Pemaiakaian*</label>
                        <input type="text" id="penggunaan_dasar" name="penggunaan_dasar" class="form-control {{error_form_class('penggunaan_dasar')}}" placeholder="Masukkan Kode Peminjaman" value="{{$result['penggunaan_dasar'] ?? ''}}" readonly>
                        <label for="penggunaan_dasar" class="error text-danger">{{error_form('penggunaan_dasar') ?? ''}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Untuk Keperluan*</label>
                        <input type="text" id="penggunaan_keperluan" name="penggunaan_keperluan" class="form-control {{error_form_class('penggunaan_keperluan')}}" placeholder="Masukkan Nama Perangkat" value="{{$result['penggunaan_keperluan'] ?? old_input('penggunaan_keperluan')}}" readonly maxlength="100">
                        <label for="penggunaan_keperluan" class="error text-danger">{{error_form('penggunaan_keperluan') ?? ''}}</label>
                    </div>
                    <div class="col-lg-6">
                        <label>Lokasi Pemakaian*</label>
                        <input type="text" id="penggunaan_lokasi" name="penggunaan_lokasi" class="form-control {{error_form_class('penggunaan_lokasi')}}" placeholder="Masukkan Nama Perangkat" value="{{$result['penggunaan_lokasi'] ?? old_input('penggunaan_lokasi')}}" readonly maxlength="100">
                        <label for="penggunaan_lokasi" class="error text-danger">{{error_form('penggunaan_lokasi') ?? ''}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Tanggal Mulai Pengunaan*</label>
                        <input type="date" id="penggunaan_tgl_mulai" name="penggunaan_tgl_mulai" class="form-control {{error_form_class('penggunaan_tgl_mulai')}}" placeholder="Masukkan Tanggal Pembelian Perangkat" value="{{$result['penggunaan_tgl_mulai'] ?? old_input('penggunaan_tgl_mulai')}}" readonly >
                        <label for="penggunaan_tgl_mulai" class="error text-danger">{{error_form('penggunaan_tgl_mulai') ?? ''}}</label>
                    </div>
                    <div class="col-lg-6">
                        <label>Tanggal Selesai Pengunaan*</label>
                        <input type="date" id="penggunaan_tgl_selesai" name="penggunaan_tgl_selesai" class="form-control {{error_form_class('penggunaan_tgl_selesai')}}" placeholder="Masukkan Tanggal Pembelian Perangkat" value="{{$result['penggunaan_tgl_selesai'] ?? old_input('penggunaan_tgl_selesai')}}" readonly >
                        <label for="penggunaan_tgl_selesai" class="error text-danger">{{error_form('penggunaan_tgl_selesai') ?? ''}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Nopol Kendaraan Yang digunakan</label>
                        <input type="text" id="penggunaan_kendaraan" name="penggunaan_kendaraan" class="form-control {{error_form_class('penggunaan_kendaraan')}}" placeholder="Masukkan Nama Jenis Perangkat" value="{{$result['penggunaan_kendaraan'] ?? old_input('penggunaan_kendaraan')}}" readonly maxlength="200">
                        <label for="penggunaan_kendaraan" class="error text-danger">{{error_form('penggunaan_kendaraan') ?? ''}}</label>
                    </div>
                    <div class="col-lg-6">
                        <label>Penanggung Jawab Pengunaan</label>
                        <input type="text" id="penanggungjawab" name="penanggungjawab" class="form-control {{error_form_class('penanggungjawab')}}" placeholder="Masukkan Nama Jenis Perangkat" value="{{$result['penanggungjawab'] ?? old_input('penanggungjawab')}}" readonly maxlength="200">
                        <label for="penanggungjawab" class="error text-danger">{{error_form('penanggungjawab') ?? ''}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Daftar Pemakai</label>
                        <ul class="list-group">
                            @foreach ($rs_pemakai as $item)
                            <li class="list-group-item disabled">{{$item['pegawai_nip']}} - {{$item['pegawai_nama_lengkap']}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <label>Daftar Perangkat</label>
                        <ul class="list-group">
                            @foreach ($rs_perangkat as $item)
                            <li class="list-group-item disabled">{{$item['perangkat_kode']}} - {{$item['perangkat_nama']}} - <span class="badge badge-info badge-sm">Kondisi : {{strtoupper($item['status'])}}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if (empty($result['approval_date']) || empty($result['approval_by']) || empty($result['approval_st']))    
            
            @else 
            <div class="card-action">
                @if ($result['approval_st'] == 'approved')
                    Pengajuan telah <span class="badge badge-success badge-sm">DISETUJUI</span> pada {{$this->tdtm->get_full_date($result['approval_date'])}} 
                @elseif($result['approval_st'] == 'rejected')
                    Pengajuan telah <span class="badge badge-warning badge-sm">DITOLAK</span> pada {{$this->tdtm->get_full_date($result['approval_date'])}} 
                @endif
            </div>
            @endif

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