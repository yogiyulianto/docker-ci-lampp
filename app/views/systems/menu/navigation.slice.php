@extends('base.default.app')
@section('title')
	{{$PAGE_TITLE}}
@endsection
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
                <a href="{{$PAGE_URL}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Back
                </a>
                <a href="{{$PAGE_URL.'add/'.$portal_id}}" class="float-right btn btn-info btn-border btn-round btn-sm mr-1">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Add {{$PAGE_HEADER}}
                </a>
            </div>
        </div>
        <div class="card-header">
            <form action="{{$PAGE_URL.'search_process/'.$portal_id}}" method="post" >
                {{ csrf_token() }}
                <div class="form-group row ">
                    <div class="col-md-12 col-sm-12 ">
                        <select name="parent_id" class="select-2 " style="width:100%">
                            <option value="">Please Select Parent Menu</option>
                            @foreach ($rs_parents as $item)
                                <option value="{{$item['nav_id']}}"{{ set_select($rs_search['parent_id'] , $item['nav_id']) }} >{{$item['nav_title']}}</option>
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
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>	
                            <th class="text-center">Icon</th>
                            <th>Menu Title</th>
                            <th>Menu URL </th>
                            <th class="text-center">Active St</th>
                            <th class="text-center">Display St</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($html))
                            @php echo $html @endphp
                        @else
                        <tr>
                            <td colspan="6" class="table-active text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Portal Empty</small></p>
                            </td>
                        </tr>
                        @endif
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
