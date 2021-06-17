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
        <div class="card-header">
            <form action="{{$PAGE_URL.'search_process'}}" method="post">
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-md-6 col-sm-12 mb-1">
                        <input type="text" class="form-control" name="role_name" value="{{$rs_search['role_name']}}"
                            placeholder="Role Name">
                    </div>
                    <div class="col-md-6 col-sm-12 select2-input">
                        <select name="group_id" class="form-control select-2" style="width:100%">
                            <option value="">Please Select Groups</option>
                            @foreach ($rs_groups as $item)
                            <option value="{{$item['group_id']}}" {{ set_select($item['group_id'],$rs_search['group_id'] ) }}>{{$item['group_name']}}</option>
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
        <div class="card-body px-0">
            <!--begin::Section-->
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th>ID</th>
                            <th>Group Name</th>
                            <th>Role Name</th>
                            <th>Role Desc</th>
                            <th>Default Page</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$item['role_id']}}</td>
                            <td>{{$item['group_name']}}</td>
                            <td>{{$item['role_name']}}</td>
                            <td>{{$item['role_desc']}}</td>
                            <td>{{$item['default_page']}}</td>
                            <td class="text-right">
                                <a href="{{ site_url('systems/permissions/access_update/'.$item['role_id'])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Permissions">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="5" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Role Empty</small></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!--end::Section-->
            @if (isset($pagination))
            <div class="card-footer">
                @php echo $pagination @endphp
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
