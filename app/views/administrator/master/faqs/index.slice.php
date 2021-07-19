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
                <!-- <a href="{{$PAGE_URL.'add'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Tambah {{$PAGE_HEADER}}
                </a> -->
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Users</th>
                            <th width="20%">Nama Dokter</th>
                            <th width="20%">Pertanyaan</th>
                            <th width="20%">Jawaban</th>
                            <th width="15%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['user_name']}}</td>
                            <td>{{$item['dokter_name']}}</td>
                            <td>{{$item['question']}}</td>
                            <td>{{$item['answer']}}</td>
                            <td>
                            @if ($item['chat_st'] == 'unread')
                                <small class="badge badge-danger text-white">Belum dibaca</small>
                                @elseif ($item['chat_st'] == 'read')
                                <small class="badge badge-warning text-white">Sudah dibaca</small>
                                @elseif ($item['chat_st'] == 'answered')
                                <small class="badge badge-primary text-white">Sudah dijawab</small>
                                @else)
                                <small class="badge badge-success text-white">Selesai</small>
                            @endif
                            </td>
                            <td class="text-right">
                            @if ($item['chat_st'] == 'unread')
                                <a href="{{ $PAGE_URL.'edit/'.$item['chat_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Ubah {{$PAGE_TITLE}}">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                                @elseif ($item['chat_st'] == 'read')
                                <a href="{{ $PAGE_URL.'edit/'.$item['chat_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Ubah {{$PAGE_TITLE}}">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                                @else
                                <small class="badge badge-success text-white">Selesai</small>
                            @endif
                                <!-- <a href="{{ $PAGE_URL.'delete/'.$item['chat_id']}}" class="btn" data-toggle="tooltip" data-placement="top" title="Hapus {{$PAGE_TITLE}}" >
                                    <i class="fas fa-trash" ></i>
                                </a> -->
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
