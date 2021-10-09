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
            <div class="card-title">Daftar {{$PAGE_TITLE }}
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="10%">No</th>
                            <th width="20%">Hari Pertama Haid Terakir (HPHT)</th>
                            <th width="20%">Hari Perkiraan Lahir</th>
                            <th width="10%">Di ubah oleh</th>
                            <th width="20%">Di ubah tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{date('j', strtotime($item['tanggal_hpht']))}} {{date('F', strtotime($item['bulan_hpht']))}} {{$item['tahun_hpht']}}</td>
                            <td>{{date('j', strtotime($item['tanggal_hpl']))}} {{date('F', strtotime($item['bulan_hpl']))}} {{$item['tahun_hpl']}}</td>
                            <td>{{$item['mdb_name']}}</td>
                            <td>{{date('j F, Y H:i', strtotime($item['mdd']))}}</td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="8" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Tidak Ada {{$PAGE_TITLE}}</small></p>
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
