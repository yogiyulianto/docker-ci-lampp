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
            <div class="card-title">Delete {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL. 'navigation/'. $portal_id}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Back
                </a>
            </div>
        </div>
		<!--begin::Form-->
		<form class="" method="POST" action="{{$PAGE_URL.'delete_process'}}" onsubmit="return confirm('Apakah anda yakin akan menghapus data dibawah ini?');">
			{{ csrf_token() }}
			<input type="hidden" name="nav_id" value="{{$result['nav_id']}}">
			<input type="hidden" name="portal_id" value="{{$result['portal_id']}}">
			<div class="card-body">
				<div class="form-group row ">
					<div class="col-lg-6">
						<label>Parent Menu *</label>
						<select name="parent_id" class="select-2" style="width:100%" disabled>
							<option value="0"> * </option>
							@foreach ($rs_menus as $item)
							<option value="{{$item['nav_id']}}"
								{{ set_select($result['parent_id'] , $item['nav_id']) }}>{{$item['nav_title']}}
							</option>
							@endforeach
						</select>
					</div>
					<div class="col-lg-6">
						<label> Nav Title *</label>
						<input type="text" class="form-control" value="{{$result['nav_title'] ?? ''}}" name="nav_title" placeholder="Navigation Title Fields" disabled>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<label>Nav Desc *</label>
						<input type="text" class="form-control" value="{{$result['nav_desc'] ?? ''}}" name="nav_desc" placeholder="Navigation Title Fields" disabled>
					</div>
					<div class="col-lg-6">
						<label>Nav URL *</label>
						<input type="text" class="form-control" value="{{$result['nav_url'] ?? ''}}" name="nav_url" placeholder="Navigation URL Fields" disabled>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<label>Nav Order *</label>
						<input type="text" class="form-control" value="{{$result['nav_no'] ?? ''}}" name="nav_no" placeholder="Navigation Order Fields" disabled>
					</div>
					<div class="col-lg-6">
						<label>Icon Class</label>
						<input type="text" class="form-control" value="{{$result['nav_icon'] ?? ''}}" name="nav_icon" placeholder="Icon Class Fields" disabled>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<label>Active *</label>
						<select name="active_st" class="select-2" style="width:100%" disabled>
							<option value="1" {{ set_select($result['active_st'],1) }}> Yes </option>
							<option value="0" {{ set_select($result['active_st'],0) }}> No </option>
						</select>
					</div>
					<div class="col-lg-6">
						<label>Display *</label>
						<select name="display_st" class="select-2" style="width:100%" disabled>
							<option value="1" {{ set_select($result['display_st'],1) }}> Yes </option>
							<option value="0" {{ set_select($result['display_st'],0) }}> No </option>
						</select>
					</div>
				</div>              
			</div>
			
			<div class="card-action">
				<button type="submit" class="btn btn-danger">Delete</button>
			</div>
		</form>
		<!--end::Form-->
	</div>
</div>
@endsection
