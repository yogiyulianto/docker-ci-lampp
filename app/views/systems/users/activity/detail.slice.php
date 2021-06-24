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
            <div class="card-title">{{$rs_id[0]['full_name']}} Activity 
                <a href="{{$PAGE_URL}}" class="ml-1 float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="la la-angle-left"></i>
                    </span>
                    Back
                </a>
                <a href="{{$PAGE_URL.'download_data/'}}" class="float-right btn btn-success btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="la la-file-excel"></i>
                    </span>
                    Download Report
                </a>
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead >
                        <tr>
                            <th>Date</th>
                            <th>Action Type</th>
                            <th>Log Message</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$this->tdtm->get_full_date($item['mdd'] ?? '-')}}</td>
                            <td>
                                @if ($item['action_type'] == 'C')
                                <label class="badge badge-primary text-white">Create</label>
                                @elseif ($item['action_type'] == 'U')
                                <label class="badge badge-success text-white">Update</label>
                                @elseif($item['action_type'] == 'D')
                                <label class="badge badge-danger text-white">Delete</label>
                                @endif
                            </td>
                            <td>{{$item['log_message']}}</td>
                            <td>{{$item['ip_address']}}</td>
                            
                            <td class="nowrap">
                                @php $agent = json_decode($item['user_agent']) @endphp
                                <div class="badge badge-info">
                                    <i class="la la-globe la-sm"></i>
                                    <span>{{ !empty($agent->ip) ? $agent->ip : "-" }}</span>
                                </div>
                                <div class="badge badge-warning">
                                    <i class="la la-desktop la-sm"></i>
                                    <span>{{ !empty($agent->browser) ? $agent->browser : "-" }}</span>
                                </div>
                                <div class="badge badge-success">
                                    @if (strstr(!empty($agent->platform) ? $agent->platform : "-",'Mac'))
                                    <i class="la la-apple la-sm"></i>
                                    <span>{{ !empty($agent->platform) ? $agent->platform : "-" }}</span>
                                    @else
                                    <i class="la la-windows la-sm"></i>
                                    <span>{{ !empty($agent->platform) ? $agent->platform : "-" }}</span>
                                    @endif 
                                </div>
                            </td>	
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Log Empty</small></p>
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