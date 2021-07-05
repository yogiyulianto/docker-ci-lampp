  
<div class="form-group row">
    <div class="col-md-12">
        <a href="{{$PAGE_URL.'add_section/'.$result['course_id']}}" class=" btn btn-success btn-border btn-round btn-sm" data-toggle="tooltip" data-placement="top" title="Tambahkan Bab">
            <span class="btn-label">
                <i class="las la-plus"></i>
                Tambahkan Bab
            </span>
        </a>
        <a href="{{$PAGE_URL.'add_lesson/'.$result['course_id']}}" class=" btn btn-success btn-border btn-round btn-sm" data-toggle="tooltip" data-placement="top" title="Tambahkan Materi/Tugas">
            <span class="btn-label">
                <i class="las la-plus"></i>
                Tambahkan Materi / Tugas
            </span>
        </a>
        <a href="{{$PAGE_URL.'add_quiz/'.$result['course_id']}}" class=" btn btn-success btn-border btn-round btn-sm" data-toggle="tooltip" data-placement="top" title="Tambahkan Kuis">
            <span class="btn-label">
                <i class="las la-plus"></i>
                Tambahkan Kuis
            </span>
        </a>
        <a onclick="showLargeModal('{{base_url('administrator/courses/sort_section/'.$result['course_id'])}}', 'Urutkan Bab ')" class=" btn btn-success btn-border btn-round btn-sm" data-toggle="tooltip" data-placement="top" title="Urutkan Bab">
            <span class="btn-label">
                <i class="las la-sort-amount-down"></i>
                Urutkan Bab
            </span>
        </a>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        @php $section_no = 1; @endphp
        @forelse ($rs_section as $item)
        <div class="card" >
                <div class="card-header">
                    <div class="card-title">Bab {{$section_no}} : {{$item['title']}}
                        <a onclick="actControl('delete', '{{$item['section_id']}}', '{{$item['title']}}');" class="float-right btn btn-danger btn-border btn-round btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Bab">
                            <span class="btn-label">
                                <i class="las la-trash"></i>
                            </span>
                        </a>


                        <a href="{{$PAGE_URL.'edit_section/'.$course_id.'/'.$item['section_id']}}" class="float-right btn btn-info btn-border btn-round btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="Ubah Bab">
                            <span class="btn-label">
                                <i class="las la-pen"></i>
                            </span>
                        </a>
                        <button type="button" class="float-right btn btn-warning btn-border btn-round btn-sm mr-1" name="button" onclick="showLargeModal('{{base_url('administrator/courses/sort_lesson/'.$item['section_id'])}}', 'Urutkan Materi')" >
                            <i class="las la-sort-amount-down"></i> 
                            Urutkan Materi
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-head-bg-primary ">
                            <tbody>
                                @php $lesson_counter = 0; @endphp
                                @php $quiz_counter = 0; @endphp
                                @php $assignment_counter = 0; @endphp
                                @forelse ($item['lessons'] as $value)
                                <tr>
                                    @php
                                        if ($value['lesson_type'] == 'quiz') {
                                            $quiz_counter++; 
                                            $lesson_type = $value['lesson_type'];
                                        }elseif ($value['lesson_type'] == 'assignment') {
                                            $assignment_counter++; 
                                            $lesson_type = $value['lesson_type'];
                                        }else {
                                            $lesson_counter++; 
                                            if ($value['attachment_type'] == 'txt' || $value['attachment_type'] == 'pdf' || $value['attachment_type'] == 'doc' || $value['attachment_type'] == 'img') {
                                                $lesson_type = $value['attachment_type'];
                                            }else {
                                                $lesson_type = 'video';
                                            }
                                        }
                                    @endphp
                                    <td>
                                        @if ($value['lesson_type'] == 'quiz')
                                            Kuis {{$quiz_counter}} 
                                        @elseif($value['lesson_type'] == 'assignment')
                                            Tugas {{$assignment_counter}} 
                                        @else
                                            Materi {{$lesson_counter}} 
                                        @endif 
                                        : {{$value['title']}}</td>
                                    <td class="text-right">
                                        @if ($value['lesson_type'] == 'quiz')
                                            <a href="{{ $PAGE_URL.'list_question/'.$course_id.'/'.$value['lesson_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Daftar Pertanyaan Kuis">
                                                <i class="fas fa-question-circle" ></i> Daftar Pertanyaan Kuis
                                            </a>
                                            <a href="{{ $PAGE_URL.'edit_quiz/'.$course_id.'/'.$value['lesson_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Ubah Kuis">
                                                <i class="fas fa-pencil-alt" ></i>
                                            </a>
											<a onclick="actControl('delete_quiz', '{{$value['section_id']}}', '{{$value['title']}}');" class="btn" data-toggle="tooltip" data-placement="top" title="Hapus Quiz">
                                                <i class="fas fa-trash" ></i>
                                            </a>
                                        @else    
                                            <a href="{{ $PAGE_URL.'edit_lesson/'.$course_id.'/'.$value['lesson_id']}}" class="btn"  data-toggle="tooltip" data-placement="top" title="Ubah Pelajaran">
                                                <i class="fas fa-pencil-alt" ></i>
                                            </a>
											<a onclick="actControl('delete_lesson', '{{$value['section_id']}}', '{{$value['title']}}');" class="btn" data-toggle="tooltip" data-placement="top" title="Hapus Pelajaran">

                                                <i class="fas fa-trash" ></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class=" text-center text-muted">
                                        <br />
                                        <i class="fas fa-archive" style="font-size: 60px"></i>
                                        <p><small>Tidak Ada Pelajaran</small></p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
        @php $section_no++ @endphp
        @empty
        <div class="card">
            <div class="table-responsive">
                <table class="table table-head-bg-primary ">
                    <tbody>
                    <tr>
                        <td colspan="6" class=" text-center text-muted">
                            <br />
                            <i class="fas fa-archive" style="font-size: 60px"></i>
                            <p><small>Tidak Ada Bab</small></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endforelse
    </div>
</div>



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
                        const response = axios.get('<?= base_url()?>administrator/courses/delete_section?section_id=' + y);
                        var data = response.data;
						swal("Terhapus !", "Data berhasil dihapus.", "success");

                        setTimeout(function () {
                            window.location.reload();
                        }, 500);

                    } catch (error) {
                        console.error(error);
                    }
				}
				});

		} else if (x == "delete_lesson") {

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
                        const response = axios.get('<?= base_url()?>administrator/courses/delete_lesson?lesson_id=' + y);
                        var data = response.data;
						swal("Terhapus !", "Data berhasil dihapus.", "success");

                        setTimeout(function () {
                            window.location.reload();
                        }, 500);

                    } catch (error) {
                        console.error(error);
                    }
				}
				});

		} else if (x == "delete_quiz") {

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
						const response = axios.get('<?= base_url()?>administrator/courses/delete_lesson?lesson_id=' + y);
						var data = response.data;
						swal("Terhapus !", "Data berhasil dihapus.", "success");

						setTimeout(function () {
							window.location.reload();
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
