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
            <div class="card-title">{{$PAGE_TITLE }} List
                <a href="{{$PAGE_URL.'add'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Add {{$PAGE_HEADER}}
                </a>
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Kolam</th>
                            <th>Total Berat</th>
                            <th>Jumlah ikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rs_id as $row)
                        <tr>
                            <td>{{date('d-m-Y', strtotime($row['date_sampling']))}}</td>
                            <td>{{$row['name']}}</td>
                            <td>{{$row['total_kg']}} Kg</td>
                            <td>{{$row['fish_count']}}</td>
                            @if ($row['pembesaran_st'] == 'ongoing')
                            <td><small class="badge badge-warning text-white">Masih Berjalan</small></td>
                            @else
                            <td><small class="badge badge-success text-white">Selesai</small></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
