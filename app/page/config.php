<?php
defined('SINAUID') OR exit('No direct script access allowed');

// Chcek role and block if not have access role
if (!isset($_SESSION['role']->config->index)) {
    $notice->addError("You don't have permission to access the feature !");
    header("location:".HTTP."?page=dashboard");
    return;
}

$title = "Configuration";
include ROOT."app/theme/header.php";
include PATH_MODEL . 'model_config.php';
$m_config = new model_config($db);
$arr_data = $m_config->get_row();

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
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">Face AI Server </label>
							<input class="form-control" type="text" name="txtFAServer" value="<?=$arr_data['faceai_server'];?>">
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">Face AI Login </label>
							<input class="form-control" type="text" name="txtFALogin" value="<?=$arr_data['faceai_login'];?>">
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">Face AI Password </label>
							<input class="form-control" type="text" name="txtFAPassword" value="<?=$arr_data['faceai_password'];?>">
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">PayPal Sandbox Account </label>
							<input class="form-control" type="text" name="txtPPSandbox" value="<?=$arr_data['paypal_sandbox_account'];?>">
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">PayPal Client ID </label>
							<input class="form-control" type="text" name="txtPPClientId" value="<?=$arr_data['paypal_client_id'];?>">
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">PayPal Client Secret </label>
							<input class="form-control" type="text" name="txtPPClientSecret" value="<?=$arr_data['paypal_client_secret'];?>">
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group mg-b-0">
							<label class="form-control-label">PayPal Live Payment <span class="tx-danger">*</span></label>
							<select class="form-control select-two" name="cbStatus" data-placeholder=" -- Pilih Status --" required>
								<option></option>
								<option value="<?=PAYPAL_LIVE;?>" <?=set_select(PAYPAL_LIVE, $arr_data['paypal_live_payment']);?>>Yes</option>
								<option value="<?=PAYPAL_DEBUG;?>" <?=set_select(PAYPAL_DEBUG, $arr_data['paypal_live_payment']);?>>No</option>
							</select>
							<ul class="fields-message"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">OVO Number </label>
							<input class="form-control" type="text" name="txtOVONumber" value="<?=$arr_data['ovo_number'];?>">
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
		var request 	= '<?=$_GET['page'] . '&act=update&id=1909';?>',
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