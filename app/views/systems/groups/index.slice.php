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
                            <th>ID</th>
                            <th>Group Name</th>
                            <th>Group Desc</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$item['group_id']}}</td>
                            <td>{{$item['group_name']}}</td>
                            <td>{{$item['group_desc']}}</td>
                            <td class="text-right">
                                <a href="{{ $PAGE_URL.'edit/'.$item['group_id']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Group">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                                <a href="{{ $PAGE_URL.'delete/'.$item['group_id']}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Group">
                                    <i class="fas fa-trash" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="5" class="table-active text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Group Empty</small></p>
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
