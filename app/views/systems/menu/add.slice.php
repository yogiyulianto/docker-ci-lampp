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
            <div class="card-title">Add {{$PAGE_HEADER }}
                <a href="{{$PAGE_URL. 'navigation/'. $portal_id}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-angle-left"></i>
                    </span>
                    Back
                </a>
            </div>
        </div>
		<!--begin::Form-->
		<form class="" method="POST" action="{{$PAGE_URL.'add_process'}}">
			{{ csrf_token() }}
			<input type="hidden" name="portal_id" value="{{$portal_id}}">
			<div class="card-body">
				<div class="form-group row ">
					<div class="col-lg-6">
						<label>Parent Menu *</label>
						<select name="parent_id" class="select-2 " style="width:100%">
							<option value="0"> * Jadikan Parent Menu </option>
							@foreach ($rs_menus as $item)
							<option value="{{$item['nav_id']}}"
								{{ set_select(old_input('parent_id') , $item['nav_id']) }}>{{$item['nav_title']}}
							</option>
							@endforeach
						</select>
						<div class="error text-danger">{{error_form('parent_id') ?? ''}}</div>
					</div>
					<div class="col-lg-6">
						<label> Nav Title *</label>
						<input type="text" class="form-control {{error_form_class('nav_title')}}" value="{{old_input('nav_title') ?? ''}}" name="nav_title" placeholder="Navigation Title Fields">
						<div class="error text-danger">{{error_form('nav_title') ?? ''}}</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<label>Nav Desc *</label>
						<input type="text" class="form-control {{error_form_class('nav_desc')}}" value="{{old_input('nav_desc') ?? ''}}" name="nav_desc" placeholder="Navigation Title Fields">
						<div class="error text-danger">{{error_form('nav_desc') ?? ''}}</div>
					</div>
					<div class="col-lg-6">
						<label>Nav URL *</label>
						<input type="text" class="form-control {{error_form_class('nav_url')}}" value="{{old_input('nav_url') ?? ''}}" name="nav_url" placeholder="Navigation URL Fields">
						<div class="error text-danger">{{error_form('nav_url') ?? ''}}</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<label>Nav Order *</label>
						<input type="text" class="form-control {{error_form_class('nav_no')}}" value="{{old_input('nav_no') ?? ''}}" name="nav_no" placeholder="Navigation Order Fields">
						<div class="error text-danger">{{error_form('nav_no') ?? ''}}</div>
					</div>
					<div class="col-lg-6">
						<label>Icon Class</label>
						<input type="text" class="form-control icp icp-auto icpauto {{error_form_class('nav_icon')}}" value="{{old_input('nav_icon') ?? ''}}" name="nav_icon" placeholder="Icon Class Fields">
						<div class="error text-danger">{{error_form('nav_icon') ?? ''}}</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<label>Active *</label>
						<select name="active_st" class="select-2" style="width:100%">
							<option value="1" {{ set_select(old_input('active_st'),1) }}> Yes </option>
							<option value="0" {{ set_select(old_input('active_st'),0) }}> No </option>
						</select>
						<div class="error text-danger">{{error_form('active_st') ?? ''}}</div>
					</div>
					<div class="col-lg-6">
						<label>Display *</label>
						<select name="display_st" class="select-2" style="width:100%">
							<option value="1" {{ set_select(old_input('display_st'),1) }}> Yes </option>
							<option value="0" {{ set_select(old_input('display_st'),0) }}> No </option>
						</select>
						<div class="error text-danger">{{error_form('display_st') ?? ''}}</div>
					</div>
				</div>              
			</div>
			
			<div class="card-action">
				<button type="submit" class="btn btn-info">Save</button>
				<button type="reset" class="btn btn-secondary">Reset</button>
			</div>
		</form>
		<!--end::Form-->
	</div>
</div>
@endsection