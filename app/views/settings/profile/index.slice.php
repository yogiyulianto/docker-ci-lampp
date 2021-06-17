@extends('base.default.app')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Personal Information</h4>
    @include('base.default.notification')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-with-nav">
                <div class="card-header">
                    <div class="row row-nav-line">
                        <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
                            <li class="nav-item submenu"> <a class="nav-link {{ ($this->uri->segment(3) == '') ? 'active' : ''}}"  href="{{base_url('settings/profile')}}" >Personal Information</a> </li>
                            <li class="nav-item submenu"> <a class="nav-link {{ ($this->uri->segment(3) == 'activity') ? 'active' : ''}}"  href="{{base_url('settings/profile/activity')}}" >Activity Log</a> </li>
                            <li class="nav-item submenu"> <a class="nav-link {{ ($this->uri->segment(3) == 'change_password') ? 'active' : ''}}"  href="{{base_url('settings/profile/change_password')}}" >Change Password</a> </li>
                        </ul>
                    </div>
                </div>
                @yield('app_content')
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-header bg-primary-gradient" >
                    <div class="profile-picture">
                        <div class="avatar avatar-xl">
                            <img src="{{base_url($result['user_img'])}}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{$result['full_name']}}</div>
                        <div class="job">{{$result['role_name']}}</div>
                        <div class="job">{{$result['user_mail']}}</div>
                        <div class="job">{{$result['phone']}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection