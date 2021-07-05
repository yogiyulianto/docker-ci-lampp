<?php
$rs_sections = $this->M_course->get_section_by_course_id(array($course_id));
?>
<div class="row">
	<div class="col-12">
        <div class="row" id="parent-div" data-plugin="dragula" data-containers='["section-list"]'>
            <div class="col-md-12">
                <div class="bg-dragula p-2 p-lg-4">
                    <div id="sortable_section" class="py-2">
                    <div class="sortable-wrap">
                            <ul class="list-group" id="section_sortable">
                                <div id="result_section"></div>
                                <?php if(count($rs_sections)): ?>
                                    <?php foreach($rs_sections as $item): ?>
                                        <li class="ui-state-default list-group-item list-group-item-action btn" id="sections_<?=$item['section_id']?>"><?= $item['title'] ?></li>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
    <input type="button" class="btn btn-primary" value="Simpan" id="submit_sort_section">
</div>

<script>
$("#section_sortable").sortable();

$('#submit_sort_section').click(function() {
    var section_id_arr = [];
    $('#section_sortable li').each(function() {
        var id = $(this).attr('id');
        var split_id = id.split("_");
        section_id_arr.push(split_id[1]);
    });
    $.ajax({
        url: "<?= base_url('administrator/courses/ajax_save_sort_section') ?>",
        type: 'post',
        data: {
            section_id: section_id_arr
        },
        success: function(response) {
            $.notify('Sort Successfully');
            setTimeout(
                function(){
                    location.reload();
            }, 1000);
        }
    });
});
</script>