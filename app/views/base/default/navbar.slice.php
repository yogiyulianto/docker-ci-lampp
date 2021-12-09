<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="blue">       
        <a href="{{url($com_user['default_page'])}}" class="logo">
            <img src="{{asset('images/logo-putih.svg')}}" alt="navbar brand" class="navbar-brand" style="width:90%">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
        <div class="container-fluid">
            <div class="text-white d-none d-sm-block"> </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <div class="mr-2 text-white">
                    {{$com_user['full_name']}}
                </div>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{url($com_user['user_img'])}}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg"><img src="{{url($com_user['user_img'])}}" alt="image profile" class="avatar-img rounded"></div>
                                    <div class="u-text">
                                        <h4>{{$com_user['full_name']}}</h4>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('settings/profile')}}">Profil Saya</a>
                                <a class="dropdown-item" href="{{url('settings/profile/activity')}}">Aktifitas Saya </a>
                                <a class="dropdown-item" href="{{url('settings/profile/change_password')}}">Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('auth/logout_process')}}">Keluar</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
