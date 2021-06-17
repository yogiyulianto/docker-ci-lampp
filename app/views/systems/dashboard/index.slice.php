@extends('base.default.app')
@section('title')
Dashboard
@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Systems Summary</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="flaticon-imac"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">App Portal</p>
                                <h4 class="card-title">{{$total_portal}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="flaticon-list"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Menu</p>
                                <h4 class="card-title">{{$total_menu}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="flaticon-lock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Roles</p>
                                <h4 class="card-title">{{$total_role}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="flaticon-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Users</p>
                                <h4 class="card-title">{{$total_user}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-head">
                        <div class="card-title">Recent Activity
                            <a class="float-right btn btn-primary btn-sm btn-sm" href="{{base_url('systems/users/activity')}}">More</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($rs_activity_log as $item)
                    <div class="d-flex">
                        <div class="avatar ">
                            <img src="{{base_url($item['user_img'])}}" class="avatar-img rounded-circle" alt="rounded" srcset="">
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">{{$item['full_name']}}
                                    @if ($item['action_type'] == 'C')
                                    <span class="text-success pl-3">CREATE</span>
                                    @elseif ($item['action_type'] == 'U')
                                    <span class="text-info pl-3">UPDATE</span>
                                    @elseif($item['action_type'] == 'D')
                                    <span class="text-warning pl-3">DELETE</span>
                                    @endif 
                            </h6>
                            <span class="text-muted">{{$item['log_message']}}</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">{{$this->tdtm->nicetime($item['mdd'])}}</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-head">
                        <div class="card-title">User Last Login</div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($rs_login_log as $item)
                    <div class="d-flex">
                        <div class="avatar ">
                            <img src="{{base_url($item['user_img'])}}" class="avatar-img rounded-circle" alt="rounded" srcset="">
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">{{$item['full_name']}}
                            </h6>
                            <span class="text-muted">{{$item['ip_address']}}</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">{{$this->tdtm->nicetime($item['login_date'])}}</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
