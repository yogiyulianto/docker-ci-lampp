<div id="deleteModal" class="modal fade text-danger" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <form action="" id="deleteForm" method="post">
            {{csrf_token()}}
            <input type="hidden" name="id" id="deleteId" value="">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title text-center">
                        <div id="modalTitle">Apakah anda yakin ?</div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                    <div class="alert alert-warning show fade">
                        <div class="alert-body">
                            Data yang dihapus tidak akan bisa dikembalikan !
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function formSubmit()
    {
        $("#deleteForm").submit();
    }
</script>