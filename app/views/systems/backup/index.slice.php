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
            <div class="card-title">{{$PAGE_TITLE }} List
                <a href="{{$PAGE_URL.'start_backup'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-database"></i>
                    </span>
                    Backup Database
                </a>
            </div>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Backup Name</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $no = 1 @endphp
                    @forelse ($rs_id as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['file_name'] }}</td>
                        <td>{{ $this->tdtm->get_full_date($item['date'],'ins') }}</td>
                        <td class="text-right">
                            <a href="{{ $PAGE_URL.'download_db/'.$item['db_filename']}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Download Database">
                                <i class="fas fa-cloud-download-alt" ></i>
                            </a>
                            <a href="{{ $PAGE_URL.'restore_db/'.$item['db_filename']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Restore Database">
                                <i class="fas fa-cloud-upload-alt" ></i>
                            </a>
                            <a href="{{ $PAGE_URL.'delete_db/'.$item['db_filename']}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Database">
                                <i class="fas fa-trash" ></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="table-active text-center text-muted">
                            <br />
                            <i class="fas fa-archive" style="font-size: 60px"></i>
                            <p><small>Backup Empty</small></p>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if (isset($pagination))
            <div class="card-footer">
                @php echo $pagination @endphp
            </div>
        @endif
    </div>
</div>
@endsection
