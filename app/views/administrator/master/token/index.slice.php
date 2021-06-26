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
                <a href="{{$PAGE_URL.'add'}}" class="float-right btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="las la-plus"></i>
                    </span>
                    Add {{$PAGE_HEADER}}
                </a>
            </div>
        </div>
        <div class="card-header">
            <form action="{{$PAGE_URL.'search_process'}}" method="post">
                {{ csrf_token() }}
                <div class="form-group row">
                    <div class="col-md-6 col-sm-12 mb-1">
                        <input type="text" class="form-control" name="token" value="{{$rs_search['token'] ?? ''}}" placeholder="Token">
                    </div>
                    <div class="col-md-6 col-sm-12 select2-input">
                        <select name="token_sts" class="select-2" style="width:100%">
                            <option value="">Please Select Status</option>
                            <option value="1">Terpakai</option>
                            <option value="0" >Belum Terpakai</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mx-2">
                        <button type="submit" name="search" value="submit" class="btn btn-primary btn-sm">
                            Search
                        </button>
                        <button type="submit" name="search" value="reset" class="btn btn-warning btn-sm">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-head-bg-primary mt-1">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" class="text-center">No</th>
                            <th style="vertical-align: middle" class="text-center">Token</th>
                            <th style="vertical-align: middle" class="text-center">Tanggal Kadaluarsa</th>
                            <th style="vertical-align: middle" class="text-center">Status</th>
							<th style="vertical-align: middle" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						@php $no = 1 @endphp
                        @forelse ($rs_id as $item)
                        <tr>
                            <td style="vertical-align: middle" class="text-center">{{$no++}}</td>
                            <td style="vertical-align: middle" class="text-center">{{$item['token']}}</td>
                            <td style="vertical-align: middle" class="text-center">{{indoDateCvt($item['expired_at'])}}</td>
                            <td style="vertical-align: middle" class="text-center">
                                @if ($item['token_sts'] == 1)
                                <small class="badge badge-danger text-white">Terpakai</small>
                                @elseif ($item['token_sts'] == 0)
                                <small class="badge badge-success text-white">Belum Terpakai</small>
                                @endif
                            </td>
                            <td style="vertical-align: middle" class="text-center">
                                <a href="{{ $PAGE_URL.'edit/'.$item['token_id']}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Token">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
								<a onclick="actControl('delete', '{{$item['token_id']}}', '{{$item['token']}}');" role="button" class="btn btn-danger text-white btn-sm " data-toggle="tooltip" data-placement="bottom" data-original-title="Hapus" style="cursor:pointer"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class=" text-center text-muted">
                                <br />
                                <i class="fas fa-archive" style="font-size: 60px"></i>
                                <p><small>Data Kosong</small></p>
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
@section('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


	async function actControl(x, y, z) {
		if (x == "delete") {

			swal({
				title: "Konfirmasi",
				text: "Apakah anda akan menghapus data " + z + " ?",
				icon: "warning",
				dangerMode: true,
				buttons: ["Batalkan!", "Ok, Lanjutkan!"],
				})
				.then((willDelete) => {
				if (willDelete) {
					try {
                        const response = axios.get('<?= base_url()?>administrator/master/token/delete?token_id=' + y);
                        var data = response.data;
						swal("Terhapus !", "Data berhasil dihapus.", "success");

                        setTimeout(function () {
                            window.location.replace("<?= base_url()?>administrator/master/token/");
                        }, 500);

                    } catch (error) {
                        console.error(error);
                    }
				}
				});

		}
			}
</script>
@endsection
