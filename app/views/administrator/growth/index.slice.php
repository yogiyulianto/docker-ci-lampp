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
                            <th>Kolam ID</th>
                            <th>Total Berat</th>
                            <th>Di ubah oleh</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021-12-10</td>
                            <td>KLM762</td>
                            <td>117 Kg</td>
                            <td>Yogi Yulianto</td>
                            <td><small class="badge badge-success text-white">Active</small></td>
                        </tr>
                        <tr>
                            <td>2021-11-10</td>
                            <td>KLM762</td>
                            <td>107 Kg</td>
                            <td>Yogi Yulianto</td>
                            <td><small class="badge badge-success text-white">Active</small></td>
                        </tr>
                        <tr>
                            <td>2021-10-10</td>
                            <td>KLM762</td>
                            <td>90 Kg</td>
                            <td>Yogi Yulianto</td>
                            <td><small class="badge badge-success text-white">Active</small></td>
                        </tr>
                        <tr>
                            <td>2021-08-10</td>
                            <td>KLM762</td>
                            <td>70 Kg</td>
                            <td>Yogi Yulianto</td>
                            <td><small class="badge badge-success text-white">Active</small></td>
                        </tr>
                        <tr>
                            <td>2021-07-10</td>
                            <td>KLM762</td>
                            <td>80 Kg</td>
                            <td>Yogi Yulianto</td>
                            <td><small class="badge badge-success text-white">Active</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
