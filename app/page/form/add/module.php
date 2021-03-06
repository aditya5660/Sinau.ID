<?php
defined('SINAUID') OR exit('No direct script access allowed');

// Chcek role and block if not have access role
if (!isset($_SESSION['role']->{$_GET['add']}->add)) {
    $notice->addError("You don't have permission to access the feature !");
    header("location:".HTTP."?page=" . $_GET['add']);
    return;
}

$title = "Add Module";
include ROOT."app/theme/header.php";
include PATH_MODEL . 'model_module_type.php';

$m_type    = new model_module_type($db);
$arr_type  = $m_type->get_results(array(), 'all');

?>
<div class="br-mainpanel">
    <div class="br-pagetitle">
        <h4><?=isset($title) ? $title : 'Untitled';?></h4>
    </div>
    <div class="br-pagebody">

    <!-- Main content -->
	<div class="row">
		<div class="col-md-12">
			<form id="form-update" class="card shadow-base bd-0">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mg-b-0">
								<label class="form-control-label">Module Text: <span class="tx-danger">*</span></label>
								<input type="text" name="txtModule" class="form-control" required autofocus>
								<ul class="fields-message"></ul>
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Module Image <span class="tx-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="image_file" class="custom-file-input" id="customFile" placeholder="Choose file" required autofocus>
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Module File <span class="tx-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="module_file" class="custom-file-input" id="customFile2" placeholder="Choose file" required autofocus>
                                    <label class="custom-file-label" for="customFile2">Choose file</label>
                                </div>
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Module Type <span class="tx-danger">*</span></label>
                                <select id="select-brand" name="cbGroup" class="form-control select-two" data-placeholder="-- Select --" >
                                    <option></option>
                                    <?php foreach ($arr_type as $value): ?>
                                        <option value="<?php print $value['module_type_id'];?>" >
                                            <?php print $value['module_type'] . ' (' . $value['module_group_name'] . ')';?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
						<div class="col-md-6">
							<div class="form-group mg-b-0">
								<label class="form-control-label">Status: <span class="tx-danger">*</span></label>
								<select class="form-control select-two" name="cbStatus" data-placeholder=" -- Pilih Status --" required>
									<option></option>
									<option value="<?=STATUS_ENABLE;?>">Enable</option>
									<option value="<?=STATUS_DISABLE;?>">Disable</option>
								</select>
								<ul class="fields-message"></ul>
							</div>
						</div>

					</div>
				</div>
				<div class="card-footer bd-color-gray-lighter text-right">
					<button type="submit" class="btn btn-primary tx-size-xs ">Submit</button>
				</div>
			
			</form>
		</div>
	</div>


<script type="text/javascript">
$(document).ready(function() {
	$('#form-update').on('submit', function(event){
		event.preventDefault();
		var request 	= '?do=<?=$_GET['add'] . '&act=add';?>',
			form 		= $(this),
            data    	= new FormData(this);

		loading(form, 'show');
        $.ajax({
            type: 'POST',
            url: request,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                init_meta(result.meta);
                loading(form, 'hide');
            }
		});
	});

	$('.role-group-list').each(function(i, obj) {
		container = $(this).closest('div');
		if($(obj).find('input[type=checkbox]').not(':checked').length > 0) {
			container.find('.mark-all-ingroup').prop('checked', false);
		}else{
			container.find('.mark-all-ingroup').prop('checked', true);
		}
	});

	$('.role-group-list input[type=checkbox]').on('change', function() {
		container = $(this).closest('div');
		if(container.find('.role-group-list input[type=checkbox]:checked').length < container.find('.role-group-list input[type=checkbox]').length) {
			console.log(container.find('.mark-all-ingroup').prop('checked', false));
		}else{
			container.find('.mark-all-ingroup').prop('checked', true);
		}
	});


	$('input.mark-all-ingroup').on('change', function() {
		li = $(this).closest('div').find('li.list-group-item');
		//console.log(li.find('input[type=checkbox]:checked').length == li.find('input[type=checkbox]'));
		if( li.find('input[type=checkbox]:checked').length == li.find('input[type=checkbox]').length ) {
			li.find('input[type=checkbox]').prop('checked', false);
		} else {
			li.find('input[type=checkbox]').prop('checked', true);
		}
	});
});
</script>

<footer class="br-footer">
    <div class="footer-left">
    </div>
    <div class="footer-right d-flex align-items-center">
    </div>
</footer>
</div>
</div>
<?php include ROOT."app/theme/footer.php";?>