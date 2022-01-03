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
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Umur</th>
                            <th>Survey</th>
                            <th>Image</th>
                            <th>address</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($survey as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td>{{date('Y-m-d', strtotime($item['datetime']))}}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['age']}}</td>
                            <td>{{$item['description']}}</td>
                            <td>{{$item['image']}}</td>
                            <td>{{$item['address']}}</td>
                            <td class="text-right">
                            <a href="{{ $PAGE_URL.'edit/'.$item['id']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ $PAGE_URL.'delete/'.$item['id']}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User">
                                <i class="fas fa-trash"></i>
                            </a>
                            </td>
						</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
