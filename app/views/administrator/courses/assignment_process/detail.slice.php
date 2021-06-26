@extends('base.default.app')
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">Siswa</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Daftar Siswa
                <a onclick="history.back()" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th style="vertical-align: middle" class="text-center">No</th>
                            <th style="vertical-align: middle" class="text-center">Nama</th>
                            <th style="vertical-align: middle" class="text-center">Email</th>
                            <th style="vertical-align: middle" class="text-center">Jenis</th>
                            <th style="vertical-align: middle" class="text-center">Lampiran</th>
                            <th style="vertical-align: middle" class="text-center">Nilai</th>
                            <th style="vertical-align: middle" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td style="vertical-align: middle" class="text-center">{{$no++}}</td>
                            <td style="vertical-align: middle" class="text-center">{{$item['full_name']}}</a></td>
                            <td style="vertical-align: middle" class="text-center">{{$item['user_mail']}}</td>
                            <td style="vertical-align: middle" class="text-center">{{$item['attachment_type']}}</td>
                            <td style="vertical-align: middle" class="text-center">
                            <a href="{{base_url($item['attachment'])}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Download Tugas">
                                    <i class="fas fa-download" ></i>
                            </a>
                            {{substr($item['attachment'], 0, 20)}} ...
                            </td>
                            <td style="vertical-align: middle" class="text-center">{{$item['nilai']}}</td>
                            <td style="vertical-align: middle" class="text-center">
                                <a href="{{ $PAGE_URL.'assignment_detail_process/'.$item['assignment_id']}}" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Lihat Detail">
                                    <i class="fas fa-eye" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="7" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Tidak Ada Data</small></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if (isset($pagination))
            <div class="card-footer">
                @php echo $pagination @endphp
            </div>
        @endif
    </div>
</div>
@endsection
