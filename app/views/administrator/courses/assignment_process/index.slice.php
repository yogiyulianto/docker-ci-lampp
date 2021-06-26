@extends('base.default.app')
@section('content')
<div class="page-inner">
    <div class="page-header d-none d-sm-flex">
        <h4 class="page-title">Tugas</h4>
        @include('base.default.breadcrumb')
    </div>
    @include('base.default.notification')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Daftar Tugas
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
                            <th style="vertical-align: middle" class="text-center">Judul</th>
                            <th style="vertical-align: middle" class="text-center">Jenis</th>
                            <th style="vertical-align: middle" class="text-center">Bab</th>
                            <th style="vertical-align: middle" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td style="vertical-align: middle" class="text-center">{{$no++}}</td>
                            <td style="vertical-align: middle" class="text-center">{{$item['lesson_title']}}</a></td>
                            <td style="vertical-align: middle" class="text-center">{{$item['assignment_type']}}</td>
                            <td style="vertical-align: middle" class="text-center">{{$item['section_titlle']}}</td>
                            <td style="vertical-align: middle" class="text-center">
                                <a href="{{ $PAGE_URL.'assignment_detail/'.$item['lesson_id']}}" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Lihat Daftar Siswa">
                                    <i class="fas fa-eye" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="5" class=" text-center text-muted">
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
