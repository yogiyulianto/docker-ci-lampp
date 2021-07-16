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
        <div class="card-header">
            <form action="{{$PAGE_URL.'search_process'}}" method="post">
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-md-6 col-sm-12 mb-1">
                        <input type="text" class="form-control" name="full_name" value="{{$rs_search['full_name'] ?? ''}}" placeholder="Full Name">
                    </div>
                    <div class="col-md-6 col-sm-12 select2-input">
                        <select name="user_st" class="select-2" style="width:100%">
                            <option value="">Please Select Status</option>
                            <option value="1" {{ set_select($rs_search['user_st'] , 1 ) }} >Active</option>
                            <option value="2" {{ set_select($rs_search['user_st'] , 2 ) }} >Disabled</option>
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
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$item['user_id']}}</td>
                            <td>{{$item['full_name']}}</td>
                            <td>{{$item['user_name']}}</td>
                            <td>{{$item['role_name']}}</td>
                            <td>
                                @if ($item['user_st'] == 1)
                                <small class="badge badge-success text-white">Active</small>
                                @elseif ($item['user_st'] == 0)
                                <small class="badge badge-danger text-white">Non Active</small>
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($item['user_st'] == 1)
                                <a href="{{ $PAGE_URL.'deactivate_user/'.$item['user_id']}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Lock User">
                                    <i class="fas fa-unlock"></i>
                                </a>
                                @elseif ($item['user_st'] == 0)
                                <a href="{{ $PAGE_URL.'activate_user/'.$item['user_id']}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Unlock User">
                                    <i class="fas fa-lock"></i>
                                </a>
                                @endif
                                <a href="{{ $PAGE_URL.'edit/'.$item['user_id']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="{{ $PAGE_URL.'delete/'.$item['user_id']}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>User Empty</small></p>
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
