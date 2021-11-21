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
                            <th width="10%">User ID</th>
                            <th width="10%">Email</th>
                            <th width="10%">Nama</th>
                            <th width="20%">Deskripsi</th>
                            <th width="10%">Di ubah oleh</th>
                            <th width="10%">Di ubah tanggal</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['user_id']}}</td>
                            <td>{{$item['email']}}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['description']}}</td>
                            <td>{{$item['mdb_name']}}</td>
                            <td>{{date('j F, Y H:i', strtotime($item['mdd']))}}</td>
                            <td>
                                <a href="mailto:{{$item['email']}}?subject=Balasan Konsultasi Busevid"class="btn"  data-toggle="tooltip" data-placement="top" title="">
                                    <i class="fas fa-paper-plane" ></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone={{$item['nomer_wa']}}"class="btn"  data-toggle="tooltip" data-placement="top" title="">
                                    <i class="fas fa-comments" ></i>
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
