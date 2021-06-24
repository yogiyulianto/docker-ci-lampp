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
            <div class="card-title">Daftar {{$PAGE_TITLE }}
                <a href="{{$PAGE_URL.'add'}}" class="float-right btn btn-primary btn-round btn-sm text-white">
                    <span class="btn-label">
                        <i class="las la-plus "></i>
                    </span>
                    Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body p-0 m-0 ">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama </th>
                            <th>Jenis </th>
                            <th>Satuan </th>
                            <th>Harga </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1 @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['nama']}}</td>
                            <td>{{$item['type']}}</td>
                            <td>{{$item['satuan'] ?? '-' }}</td>
                            <td>{{$item['harga'] ?? '-' }}</td>
                            <td class="text-right">
                                <a href="{{ $PAGE_URL.'edit/'.$item['jenis_treatment_id']}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Data">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="deleteData('{{$item['jenis_treatment_id']}}')">
                                    <i class="fas fa-trash" ></i>
                                </a>
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td colspan="7" class="table-active text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Belum Ada Data</small></p>
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
@section('scripts')
<script>
    function deleteData(id)
    {
        var url = "<?= base_url('administrator/master/jenis_treatment/delete_process/')?>";
        $("#deleteId").attr("value", id);
        $("#deleteForm").attr("action", url);
        $("#deleteModal").modal("show");
    }
</script>
@endsection
