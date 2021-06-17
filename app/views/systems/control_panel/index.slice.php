@extends('base.default.app')
@section('title')
{{ $PAGE_TITLE }}
@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Control Panel</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Hardware statistics</div>
                    <div class="card-category">Daily information about statistics in system</div>
                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-1"></div>
                            <h6 class="fw-bold mt-3 mb-0">CPU</h6>
                            <p class="text-center ">Total : {{$server_cpu_usage['total'] }} % | Used : {{$server_cpu_usage['usage'] }} % | Free : {{$server_cpu_usage['free'] }} %</p>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-2"></div>
                            <h6 class="fw-bold mt-3 mb-0">Memory</h6>
                            <p class="text-center ">Total : {{$server_memory_usage['total'] }}  | Used : {{$server_memory_usage['usage'] }}  | Free : {{$server_memory_usage['free'] }} </p>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-3"></div>
                            <h6 class="fw-bold mt-3 mb-0">Disk</h6>
                            <p class="text-center ">Total : {{$server_disk_usage['total'] }}  | Used : {{$server_disk_usage['usage'] }}  | Free : {{$server_disk_usage['free'] }} </p>
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
                    <div class="card-head-row">
                        <div class="card-title">Server Information</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1"><span class="text-muted">Hostname</span></div>
                        <div class="float-right pt-1"><span class="text-muted">{{$server_information['hostname']}}</span></div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1"><span class="text-muted">Operating System</span></div>
                        <div class="float-right pt-1"><span class="text-muted">
                            @foreach ($server_information['os'] as $item)
                            {{ $item .'<br>' }}
                            @endforeach</span>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1"><span class="text-muted">IP Address</span></div>
                        <div class="float-right pt-1"><span class="text-muted">{{$server_information['ip_address']}}</span></div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1"><span class="text-muted">CPU Core</span></div>
                        <div class="float-right pt-1"><span class="text-muted">{{$server_information['cpu_core']}}</span></div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1"><span class="text-muted">Memory</span></div>
                        <div class="float-right pt-1"><span class="text-muted">{{$server_information['memory']}}</span></div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="flex-1 ml-3 pt-1"><span class="text-muted">Disk Space</span></div>
                        <div class="float-right pt-1"><span class="text-muted">{{$server_disk_usage['total']}}</span></div>
                    </div>
                    <div class="separator-dashed"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    Circles.create({
        id:'circles-1',
        radius:90,
        value: {{ $server_cpu_usage['usage'] }},
        maxValue:100,
        width:10,
        text: {{ $server_cpu_usage['usage'] }} + '%',
        colors:['#f1f1f1', '#FF9E27'],
        duration:400,
        wrpClass:'circles-wrp',
        textClass:'circles-text',
        styleWrapper:true,
        styleText:true
    }),
    Circles.create({
        id:'circles-2',
        radius:90,
        value: {{ $server_memory_usage['usage_percentage'] }},
        maxValue:100,
        width:10,
        text: {{ $server_memory_usage['usage_percentage'] }} + '%',
        colors:['#f1f1f1', '#2BB930'],
        duration:400,
        wrpClass:'circles-wrp',
        textClass:'circles-text',
        styleWrapper:true,
        styleText:true
    }),
    Circles.create({
        id:'circles-3',
        radius: 90,
        value: {{ $server_disk_usage['usege_percentage']}},
        maxValue:100,
        width:10,
        text: {{ $server_disk_usage['usege_percentage'] }} + '%',
        colors:['#f1f1f1', '#F25961'],
        duration:400,
        wrpClass:'circles-wrp',
        textClass:'circles-text',
        styleWrapper:true,
        styleText:true
    })

</script>
@endsection
