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
                <a onclick="swal('Perhatian !', 'Maaf fitur dalam tahap pengembangan!', 'warning')" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Tambahkan {{$PAGE_HEADER}}
                </a>
            </div>
        </div>
        <div class="card-header">
            <form action="{{$PAGE_URL.'search_process'}}" method="post">
                {{ csrf_token() }}
                <div class="form-group row">
					<div class="col-md-6 col-sm-12 mb-1">
							<input type="text" class="form-control" name="token" value="{{$rs_search['title'] ?? ''}}" placeholder="Judul">
					</div>
                    <div class="col-md-3 col-sm-6 select2-input">
                        <select name="course_st" class="select-2" style="width:100%">
                            <option value="">Filter Berdasarkan Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 select2-input">
                        <select name="sort_by" class="select-2" style="width:100%">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="mdd-desc" {{ set_select($rs_search['sort_by'] , 'mdd-desc' ) }}>Data Terbaru</option>
                            <option value="mdd-asc" {{ set_select($rs_search['sort_by'] , 'mdd-asc' ) }}>Data Terakhir</option>
                            <option value="title-asc" {{ set_select($rs_search['sort_by'] , 'title-asc' ) }}>A ke Z</option>
                            <option value="title-desc" {{ set_select($rs_search['sort_by'] , 'title-desc' ) }}>Z ke A</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mx-2">
                        <button type="submit" name="search" value="submit" class="btn btn-primary btn-sm">
                            Pencarian
                        </button>
                        <button type="submit" name="search" value="reset" class="btn btn-warning btn-sm">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" class="text-center">No</th>
                            <th style="vertical-align: middle" class="text-center">Judul</th>
                            <th style="vertical-align: middle" class="text-center">Peserta Terdaftar</th>
                            <th style="vertical-align: middle" class="text-center">Nama Pengajar</th>
                            <th style="vertical-align: middle" class="text-center">Status</th>
                            <th style="vertical-align: middle" class="text-center">Harga</th>
							<th style="vertical-align: middle" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						@php $no = 1 @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td style="vertical-align: middle" class="text-center">{{$no++}}</td>
                            <td style="vertical-align: middle" class="text-center"><a target="_blank" href="" data-toggle="tooltip" data-placement="top" title="Lihat Pelatihan">{{strtoupper($item['title'])}}</a></td>
                            <td style="vertical-align: middle" class="text-center">{{$item['enrolled_users']}} </td>
                            <td style="vertical-align: middle" class="text-center">{{$item['teacher_name']}}</td>
                            <td style="vertical-align: middle" class="text-center">
							@if ($item['course_st'] == 1)
                                <small class="badge badge-success text-white">Aktif</small>
                                @else
                                <small class="badge badge-danger text-white">Tidak Aktif</small>
                                @endif
                            </td>
                            <td style="vertical-align: middle" class="text-center">
                                @if ($item['is_free_course'] == 'yes')
                                    Gratis
                                @else
                                <span class="uk-h1"> {{rupiah($item['price'])}} </span><br>
                                @endif
                            </td>
                            <td style="vertical-align: middle" class="text-center">
                                <a href="{{ $PAGE_URL.'assignment/'.$item['course_id']}}" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Lihat Hasil">
                                    <i class="fas fa-book" ></i>
                                </a>
                                <a onclick="swal('Perhatian !', 'Maaf fitur dalam tahap pengembangan!', 'warning')" class="btn btn-danger text-white btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Pelatihan">
                                    <i class="fas fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Tidak Ada Pelatihan</small></p>
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
@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
