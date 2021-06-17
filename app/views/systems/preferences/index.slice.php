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
    <div class="row">
        <div class="col-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills nav-primary nav-pills-no-bd" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @php $counter = 1 @endphp 
                        @forelse ($rs_groups as $item)
                        <a class="nav-link {{($counter == 1) ? 'active show' : ''}} mb-2" id="pills-{{$item['pref_group']}}" data-toggle="pill" href="#pills-{{$item['pref_group']}}-tab" role="tab" aria-controls="pills-{{$item['pref_group']}}" aria-selected="true">{{ucfirst($item['pref_group'])}}</a>
                        @php $counter++ @endphp 
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-8">
            <form action="{{$PAGE_URL.'update_process'}}" method="post">
                {{csrf_token()}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{$PAGE_TITLE }} List
                            <a href="{{$PAGE_URL.'master'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                                <span class="btn-label">
                                    <i class="las la-database"></i>
                                </span>
                                Master {{$PAGE_HEADER}}
                            </a>
                        </div>
                    </div>
                    <div class="card-body " >
                        <div class="tab-content" id="v-pills-tabContent">
                            @php $counter = 1 @endphp 
                            @forelse ($rs_prefs as $key => $item)
                            <div class="tab-pane fade {{($counter == 1) ? 'active show' : ''}}" id="pills-{{$key}}-tab" role="tabpanel" aria-labelledby="pills-{{$key}}">
                                @foreach ($item as $value)
                                    <div class="form-group row">
                                        <label>{{$value['pref_label']}}*</label>
                                        <input type="text" name="{{$value['pref_nm']}}" class="form-control {{error_form_class($value['pref_nm'])}}" placeholder="Enter {{$value['pref_label']}}" value="{{$value['pref_value']}}">
                                        <div class="error text-danger">{{error_form($value['pref_nm']) ?? ''}}</div>
                                    </div>
                                @endforeach
                            </div>
                            @php $counter++ @endphp 
                            @empty
                                
                            @endforelse
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary " type="submit">Update</button>
                    </div>
                        <!--end::Section-->
                    @if (isset($pagination))
                        <div class="card-footer">
                            @php echo $pagination @endphp
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
