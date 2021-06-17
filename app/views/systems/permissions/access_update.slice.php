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
			<div class="card-title">{{$PAGE_TITLE}}  for {{ $result['role_name']}} 
				<a href="{{$PAGE_URL}}" class="float-right btn btn-success btn-border btn-round btn-sm">
					<span class="btn-label">
						<i class="las la-angle-left"></i>
					</span>
					Back
				</a>
			</div>
        </div>
        <div class="card-header">
            <form action="{{$PAGE_URL.'filter_portal_process/'.$result['role_id']}}" method="post">
				{{ csrf_token() }}
				<div class="form-group row ">
					<div class="col-md-12 col-sm-12 select2-input">
						<select name="portal_id" class="form-control select-2" style="width:100%">
							<option value="">Please Select Portal Menu</option>
							@foreach ($rs_portal as $item)
								<option value="{{$item['portal_id']}}"{{ set_select($default_portal_id , $item['portal_id']) }}>{{$item['portal_title']}}</option>
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

        	<div class="card-body">
			<!--begin::Section-->
				<div class="kt-section kt-section__content mb-1">
					
				</div>
		<form action="{{$PAGE_URL.'process/'.$result['role_id']}}" method="post">
            	<div class="kt-section kt-section__content mb-0">
					{{ csrf_token() }}
					<input type="hidden" name="role_id" value="{{$result['role_id']}}" />
					<div class="table-responsive">
						<table class="table table-hover table-wrap">
							<thead>
								<tr>
									<th class="text-center">
										<input type="checkbox" name="" id="checked-all-menu" class="checked-all-menu">
									</th>
									<th>Nav Title</th>
									<th class="text-center">Create</th>
									<th class="text-center">Read</th>
									<th class="text-center">Update</th>
									<th class="text-center">Delete</th>
								</tr>
							</thead>
							<tbody>
								@if (isset($list_menu))
								@php echo $list_menu @endphp
								@else
								<tr>
									<td colspan="5" class="table-active text-center text-muted">
										<br />
										<i class="fas fa-archive" style="font-size: 60px"></i>
										<p><small>Role Empty</small></p>
									</td>
								</tr>

								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
        	</div>
			
				<div class="card-action">
					<div class="row">
						<div class="col-lg-6">
							<button type="submit" class="btn btn-info">Update</button>
						</div>
					</div>
				</div>
			</div>
		</form>
        <!--end::Section-->
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function () {
		$(".checked-all").click(function () {
			var status = $(this).is(":checked");
			if (status === true) {
				$(".r" + $(this).val()).prop('checked', true);
			} else {
				$(".r" + $(this).val()).prop('checked', false);
			}
		});
		$(".checked-all-menu").click(function () {
			var status = $(this).is(":checked");
			if (status === true) {
				$(".r-menu").prop('checked', true);
			} else {
				$(".r-menu").prop('checked', false);
			}
		});
	});
</script>
@endsection
