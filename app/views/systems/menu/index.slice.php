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
            <div class="card-title">{{$PAGE_TITLE }} List </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Portal Name</th>
                            <th>Portal Desc</th>
                            <th>Total Menu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$item['portal_id']}}</td>
                            <td><i class="{{$item['portal_icon'] ?? 'la la-desktop'}} "></i> - {{$item['portal_nm']}}</td>
                            <td>{{$item['portal_title' ?? '-']}}</td>
                            <td>{{$item['total_nav'] ?? '-'}}</td>
                            <td class="text-right">
                                <a href="{{ $PAGE_URL.'navigation/'.$item['portal_id']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Navigation">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="5" class=" text-center text-muted">
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
        <!--end::Section-->
        @if (isset($pagination))
        <div class="card-footer">
            @php echo $pagination @endphp
        </div>
        @endif
    </div>
</div>
@endsection
