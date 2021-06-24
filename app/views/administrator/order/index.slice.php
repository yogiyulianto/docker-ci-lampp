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
            </div>
        </div>
        <div class="card-body p-0 m-0 ">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pasien </th>
                            <th>Perawat </th>
                            <th>Treatment </th>
                            <th>Total </th>
                            <th>Status </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1 @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item['pasien_name']}}</td>
                            <td>{{$item['perawat_name']}}</td>
                            <td>{{$item['treatment'] ?? '-' }}</td>
                            <td>{{$item['jumlah'] ?? '-' }}</td>
                            <td>
                                @if ($item['order_st'] == 0)
                                <small class="badge badge-warning text-white">Belum pilih perawat</small>
                                @elseif ($item['order_st'] == 1)
                                <small class="badge badge-primary text-white">Dalam proses treatment</small>
                                @elseif ($item['order_st'] == 2)
                                <small class="badge badge-success text-white">Selesai</small>
                                @else
                                <small class="badge badge-danger text-white">Batal</small>
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($item['perawat_id'] == '')
                                <a href="{{ $PAGE_URL.'edit/'.$item['order_id']}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Tentukan Perawat">
                                    <i class="fas fa-pencil-alt" ></i>
                                </a>
                                @endif
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="deleteData('{{$item['order_id']}}')">
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
        var url = "<?= base_url('administrator/master/order/delete_process/')?>";
        $("#deleteId").attr("value", id);
        $("#deleteForm").attr("action", url);
        $("#deleteModal").modal("show");
    }
</script>
@endsection
