<?php
$section_details = $this->M_course->get_section_by_id(array($section_id));
$rs_lessons = $this->M_course->get_lesson_by_section_id(array($section_details['section_id']));
?>
<div class="row">
	<div class="col-12">
        <div class="row" id="parent-div" data-plugin="dragula" data-containers='["lesson-list"]'>
            <div class="col-md-12">
                <div class="bg-dragula p-2 p-lg-4">
                    <div id="sortable_lesson" class="py-2">
                    <div class="sortable-wrap">
                            <ul class="list-group" id="lesson_sortable">
                                <div id="result_section"></div>
                                <?php if(count($rs_lessons)): ?>
                                    <?php foreach($rs_lessons as $item): ?>
                                        <li class="ui-state-default list-group-item list-group-item-action btn" id="lessons_<?=$item['lesson_id']?>"><?= $item['title'] ?></li>
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
    <input type="button" class="btn btn-primary" value="Simpan" id="submit_sort_lesson">
</div>

<script>
$("#lesson_sortable").sortable();

$('#submit_sort_lesson').click(function() {
    var lesson_id_arr = [];
    $('#lesson_sortable li').each(function() {
        var id = $(this).attr('id');
        var split_id = id.split("_");
        lesson_id_arr.push(split_id[1]);
    });
    $.ajax({
        url: "<?= base_url('administrator/courses/ajax_save_sort_lesson') ?>",
        type: 'post',
        data: {
            lesson_id: lesson_id_arr
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