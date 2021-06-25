@extends('settings.profile.index')
@section('styles')
<link rel="stylesheet" href="{{$asset_url}}plugins/dropify/dist/css/dropify.min.css">
@endsection
@section('app_content')
<form method="POST" action="{{$PAGE_URL.'edit_process'}}" enctype="multipart/form-data">
    {{csrf_token()}}
    <div class="card-body">
        <div class="form-group row">
            <div class="col-lg-6 col-xl-6">
                <label>Avatar 
                    <label class="link text-primary" data-toggle="modal" data-target="#modalProfile" data-original-title="Change avatar">
                        <small>change picture</small>
                    </label>
                </label>
                <div class="profile-picture">
                    <div class="avatar avatar-xl">
                        <img src="{{base_url($result['user_img'])}}" alt="..." class="avatar-img rounded-circle">
                    </div>
                </div>
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-lg-6 col-xl-6">
                <label >Full Name</label>
                <input class="form-control {{error_form_class('full_name')}}" name="full_name" type="text" value="{{$result['full_name'] ?? '-'}}">
                <div class="error text-danger">{{error_form('full_name') ?? ''}}</div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <label>Gender</label>
                <select class="form control select-2" name="gender_st" style="width:100%">
                    <option value="L" {{set_select('L',$result['gender_st'])}}>Male</option>
                    <option value="P" {{set_select('P',$result['gender_st'])}}>Female</option>
                </select>
                <div class="error text-danger">{{error_form('gender_st') ?? ''}}</div>
            </div>
        </div>
        <div class="form-group row">
            <div class=" col-xl-12">
                <label>Address</label>
                <input class="form-control {{error_form_class('address')}}" name="address" type="text" value="{{$result['address'] ?? '-'}}">
                <div class="error text-danger">{{error_form('address') ?? ''}}</div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6 col-xl-6">
                <label >Username </label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
                    <input type="text" class="form-control {{error_form_class('user_name')}}" name="user_name" value="{{$result['user_name']}}" placeholder="Username" aria-describedby="basic-addon1">
                </div>
                <div class="error text-danger">{{error_form('user_name') ?? ''}}</div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <label> Phone</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                    <input type="text" class="form-control {{error_form_class('phone')}}" name="phone" value="{{$result['phone']}}" placeholder="Phone">
                </div>
                <div class="error text-danger">{{error_form('phone') ?? ''}}</div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Email Address</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                    <input type="text" class="form-control {{error_form_class('user_mail')}}" name="user_mail" value="{{$result['user_mail']}}" placeholder="Email" aria-describedby="basic-addon1">
                </div>
                <div class="error text-danger">{{error_form('user_mail') ?? ''}}</div>
            </div>
        </div>
    </div>
    <div class="card-action">
        <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
        <button type="reset" class="btn btn-warning">Cancel</button>
    </div>
</form>
<div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Profile Picture</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" action="{{base_url('settings/profile/edit_img_process')}}" method="post"
				enctype="multipart/form-data">
				{{csrf_token()}}
				<div class="modal-body">
					<input name="page" type="hidden" value="profil" />
					<div class="form-group row">
						<label class="col-form-label">Browse Foto</label>
                        <div class="col-md-12">
                            <input type="file" name="user_img_upload" class="dropify" data-default-file="{{base_url($result['user_img'])}}" data-max-file-size="3M" data-show-errors="true"/>
                        </div>
					</div>
					<!--Modal footer-->
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-warning btn-sm" type="button">Back</button>
						<button class="btn btn-primary btn-sm">Upload dan Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script src="{{$asset_url}}plugins/dropify/dist/js/dropify.js"></script>
<script>
    $('.dropify').dropify();
</script>
@endsection