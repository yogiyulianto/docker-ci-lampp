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
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kolam ID</th>
                            <th>Total KG</th>
                            <th>Total Pakan</th>
                            <th>Lama Tumbuh (Dalam Hari)</th>
                            <th>Di buat oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($rs_id as $row)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{date('d-m-Y', strtotime($row['datetime']))}}</td>
                            <td>{{$row['name']}}</td>
                            <td>{{$row['total_kg']}}</td>
                            <td>{{$row['total_feed']}}</td>
                            <td>{{$row['time_growth']}}</td>
                            <td>{{$row['mdb_name']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
