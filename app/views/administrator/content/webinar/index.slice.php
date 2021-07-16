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
                <a href="{{$PAGE_URL.'add'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Tambah {{$PAGE_HEADER}}
                </a>
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Judul</th>
                            <th width="10%">Deskripsi</th>
                            <th width="10%">Gambar</th>
                            <th width="10%">Link</th>
                            <th width="10%">Jadwal</th>
                            <th width="10%">Status</th>
                            <th width="10%">Kategori</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['title']}}</td>
                            <td>{{$item['description']}}</td>
                            <td><img src="{{base_url($item['image'])}}" alt="" width="50px"></td>
                            <td>{{$item['link']}}</td>
                            <td>{{date('j F, Y', strtotime($item['jadwal']))}}</td>
                            <td>
                                <button class="btn btn-primary btn-border btn-sm btn-round">
                                    @if($item['webinar_st'] == 'published')
                                    Terbit
                                    @elseif($item['webinar_st'] == 'draft')
                                    Draft
                                    @endif
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-border btn-sm btn-round">
                                    @if($item['pricing_st'] == 'free')
                                    Gratis
                                    @elseif($item['pricing_st'] == 'premium')
                                    Berbayar
                                    @endif
                                </button>
                            </td>
                            <td class="text-left">
                                <a href="{{ $PAGE_URL.'edit/'.$item['webinar_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Ubah {{$PAGE_TITLE}}">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                                <a href="{{ $PAGE_URL.'delete/'.$item['webinar_id']}}" class="btn" data-toggle="tooltip" data-placement="top" title="Hapus {{$PAGE_TITLE}}" >
                                    <i class="fas fa-trash" ></i>
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
