<?php
defined('SINAUID') OR exit('No direct script access allowed');

// Chcek role and block if not have access role
if (!isset($_SESSION['role']->{$_GET['update']}->update)) {
    $notice->addError("You don't have permission to access the feature !");
    header("location:".HTTP."?page=" . $_GET['update']);
    return;
}

if(!isset($_GET['id']) || empty($_GET['id'])) {
    $notice->addError("Parameter id can't be empty !");
    header("location:".HTTP."?page=" . $_GET['update']);
    return; 
}

$title = "Update Admin Group";
include ROOT."app/theme/header.php";
include PATH_MODEL . 'model_admin.php';
include PATH_MODEL . 'model_admin_group.php';

$m_admin 	= new model_admin($db);
$m_group    = new model_admin_group($db);
$arr_data   = $m_admin->get_row(array("admin_id" => $_GET['id']/1909));
if(!$arr_data) {
    $notice->addError("Data not found in our database !");
    header("location:".HTTP."?page=" . $_GET['update']);
    return;
}
$arr_group  = $m_group->get_results(array(), 'all');

?>
<div class="br-mainpanel">
    <div class="br-pagetitle">
        <h4><?=isset($title) ? $title : 'Untitled';?></h4>
    </div>
    <div class="br-pagebody">

	<div class="row">
    	<div class="col-md-7 col-sm-12">
			<form id="form-update" class="card shadow-base bd-0">
				<div class="card-body">
					<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Full Name </label>
                                <input class="form-control" type="text" name="txtFullName" placeholder="Full Name" value="<?=$arr_data['admin_name'];?>">
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Login </label>
                                <input class="form-control" type="text" name="txtLogin" placeholder="Login" value="<?=$arr_data['admin_login'];?>">
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Admin Group </label>
                                <select id="select-brand" name="cbGroup" class="form-control select-two" data-placeholder="-- Select --" >
                                    <option></option>
                                    <?php foreach ($arr_group as $value): ?>
                                        <option value="<?php print $value['admin_group_id'];?>" <?=set_select($value['admin_group_id'], $arr_data['admin_group_id']);?> >
                                            <?php print $value['admin_group_name'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Email </label>
                                <input class="form-control" type="email" name="txtEmail" placeholder="Email" value="<?=$arr_data['admin_email'];?>">
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Password </label>
                                <input class="form-control" type="password" name="txtPassword" placeholder="Password">
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Repeat Password </label>
                                <input class="form-control" type="password" name="txtRepeatPassword" placeholder="Repeat Password">
                                <ul class="fields-message"></ul>
                            </div>
                        </div>
						<div class="col-md-6">
							<div class="form-group mg-b-0">
								<label class="form-control-label">Status: <span class="tx-danger">*</span></label>
								<select class="form-control select-two" name="cbStatus" data-placeholder=" -- Pilih Status --" required>
									<option></option>
									<option value="<?=STATUS_ENABLE;?>" <?=set_select(STATUS_ENABLE, $arr_data['admin_status']);?>>Enable</option>
									<option value="<?=STATUS_DISABLE;?>" <?=set_select(STATUS_DISABLE, $arr_data['admin_status']);?>>Disable</option>
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

        <div class="col-md-5 col-sm-12 mg-t-20 mg-md-t-0">

            <div class="card shadow-base bd-0 mg-b-20">
                <?php if (!empty($arr_data['updated']) && !empty($arr_data['updated_by']) && !empty($arr_data['created']) && !empty($arr_data['created_by'])): ?>
                <div class="card-body bg-transparent pd-0 bd-gray-200 mg-t-auto">
                    <div class="row no-gutters tx-center">
                        <?php if (!empty($arr_data['updated']) && !empty($arr_data['updated_by'])): ?>
                        <div class="col pd-y-15">
                            <p class="mg-b-5 tx-uppercase tx-12 tx-mont tx-semibold">Terakhir Diubah</p>
                            <h4 class="tx-16 tx-bold mg-b-0 tx-inverse">
                                <?=strtoupper($arr_data['updated_by']);?>
                            </h4>
                            <span class="tx-12 tx-primary tx-roboto">
                                <?=timestamp_to_date($arr_data['updated']);?>
                            </span>
                        </div>
                        <?php endif;?>


                        <div class="col pd-y-15 bd-l bd-gray-200">
                            <?php if (!empty($arr_data['created']) && !empty($arr_data['created_by'])): ?>
                            <p class="mg-b-5 tx-uppercase tx-12 tx-mont tx-semibold">Dibuat</p>
                            <h4 class="tx-16 tx-inverse tx-bold mg-b-0">
                                <?=strtoupper($arr_data['created_by']);?>
                            </h4>
                            <span class="tx-12 tx-primary tx-roboto">
                                <?=timestamp_to_date($arr_data['created']);?>
                            </span>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif;?>
            </div>

            <?php include ROOT."app/theme/change_log.php";?>
        </div>
	</div>

<script type="text/javascript">
$(document).ready(function() {
	get_action_log();

	$('#form-update').on('submit', function(event){
		event.preventDefault();
		var request 	= '<?=$_GET['update'] . '&act=update&id=' . $_GET['id'];?>',
			form 		= $(this);

		loading(form, 'show');
		ajax_post(request, form.serialize(), function(result) {

			init_meta(result.meta);
			get_action_log();
			loading(form, 'hide');
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