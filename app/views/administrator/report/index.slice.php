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
                <a href="{{$PAGE_URL.'download'}}" class="float-right btn btn-danger text-white btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-file-pdf"></i>
                    </span>
                    Download Data
                </a>
            </div>
        </div>
        <div class="card-header">
            <form action="{{$PAGE_URL.'search_process'}}" method="post">
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-md-6 col-sm-12 select2-input">
                        <select name="bulan" class="select-2" style="width:100%">
                            <option value="">Please Select Bulan</option>
                            @foreach ($rs_bulan as $key => $item)
                            <option value="{{ $key }}" {{ set_select($rs_search['bulan'] , $key ) }} >{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mx-2">
                        <button type="submit" name="search" value="submit" class="btn btn-primary btn-sm">
                            Search
                        </button>
                        <button type="submit" name="search" value="reset" class="btn btn-warning btn-sm">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0 m-0 ">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Pengajuan</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Penanggung Jawab</th>
                            <th>Status Peminjaman</th>
                            <th>Status Approval</th>
                            <th>Update Terakhir</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no  = 1 @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['peminjaman_kode']}}</td>
                            <td>{{$item['peminjam']}}</td>
                            <td>{{$item['penanggungjawab']}}</td>
                            <td >
                                @if ($item['peminjaman_st'] == 'draft')
                                <span for="" class="badge badge-info badge-sm">DRAFT</span>
                                @elseif($item['peminjaman_st'] == 'process')
                                <span for="" class="badge badge-primary badge-sm">DIPROSES</span>
                                @elseif($item['peminjaman_st'] == 'approved')
                                <span for="" class="badge badge-success badge-sm">DISETUJUI</span>
                                @elseif($item['peminjaman_st'] == 'rejected')
                                <span for="" class="badge badge-danger badge-sm">DITOLAK</span>
                                @elseif($item['peminjaman_st'] == 'returned')
                                <span for="" class="badge badge-secondary badge-sm">DIKEMBALIKAN</span>
                                <br>
                                <small>{{$this->tdtm->get_full_date($item['returned_at'],'ins')}}</small>
                                @endif
                            </td>
                            <td >
                                @if ($item['approval_st'] == 'waiting')
                                <span for="" class="badge badge-info badge-sm">MENUNGGU</span>
                                @elseif($item['approval_st'] == 'approved')
                                <span for="" class="badge badge-success badge-sm">DISETUJUI</span>
                                @elseif($item['approval_st'] == 'rejected')
                                <span for="" class="badge badge-danger badge-sm">DITOLAK</span>
                                @endif
                            </td>
                            <td>{{$this->tdtm->get_full_date($item['mdd'],'ins') ?? '-' }}</td>
                            <td class="text-right">
                                <a href="{{ $PAGE_URL.'detail/'.$item['peminjaman_id']}}" class="m-1 btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Review Detail Peminjaman">
                                    <i class="fas fa-search-plus" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="8" class="table-active text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Belum Ada Data</small></p>
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
