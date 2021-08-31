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
            <!-- <div class="card-title">Daftar {{$PAGE_TITLE }}
                <a href="{{$PAGE_URL.'add'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Tambah {{$PAGE_HEADER}}
                </a>
            </div> -->
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Nama Pasien</th>
                            <th width="20%">Tanggal Pesan dibuat</th>
                            <th width="20%">Judul Pesan</th>
                            <th width="20%">Status</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['mdb_name']}}</td>
                            <td>{{$item['message_date']}}</td>
                            <td>{{$item['title']}}</td>
                            <td>
                                @if($item['chat_st'] === 'waiting')
                                <span class="badge badge-warning">Menunggu Balasan</span>
                                @elseif($item['chat_st'] === 'process')
                                <span class="badge badge-primary">Sudah dibalas</span>
                                @else
                                <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ $PAGE_URL.'detail/'.$item['chat_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Detail {{$PAGE_TITLE}}">
                                    <i class="fas fa-eye" ></i>
                                </a>
                                <a href="{{ $PAGE_URL.'finish_process/'.$item['chat_id']}}" onclick="return confirm('Apa anda yakin menyelesaikan percakapan ini?')" class="btn" data-toggle="tooltip" data-placement="top" title="Tutup {{$PAGE_TITLE}}" >
                                    <i class="fas fa-paper-plane" ></i>
                                </a>
                            </td>
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
