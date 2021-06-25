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
                            <th>Full Name</th>
                            <th>Create</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Last Activity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$item['mdb']}}</td>
                            <td>{{$item['full_name']}}</td>
                            <td>{{$item['create']}}</td>
                            <td>{{$item['update']}}</td>
                            <td>{{$item['delete']}}</td>
                            <td>{{$this->tdtm->get_full_date($item['mdd'])}}</td>
                            <td class="text-right">
                                    <a href="{{ $PAGE_URL.'detail/'.$item['mdb']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detail User Log">
                                        <i class="fas fa-eye"></i>
                                    </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Log Empty</small></p>
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