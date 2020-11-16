<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<!-- Page Header Begin -->
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-right">
				<button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" name="<?php echo $button_save; ?>"><i class="far fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_cancel; ?>"><i class="fas fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?> </h1>
			<nav aria-label="breadcrumb" id="breadcrumb">
				<ol class="breadcrumb">
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
						<li class="breadcrumb-item">
							<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb-link"><?php echo $breadcrumb['text']; ?></a>
						</li>
					<?php } ?>
				</ol>
			</nav>	
		</div>
	</div>
	<!-- Page Heaedr End -->
	<div class="container-fluid">
		<div class="alert alert-info" role="alert"><i class="fas fa-info-circle"></i> <?php echo $help_form; ?></div>
		<?php if ($error_warning){ ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-exclamation-triangle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
		<div class="card">
			<div class="card-header"><i class="far fa-edit"></i> <?php echo $text_form; ?></div>
			<div class="card-body" id="withdraw-form">
					<fieldset class="mb-4">
						<legend><?php echo $text_history; ?></legend>
						<div id="history"></div>
					<fieldset class="mb-4">
						<legend><?php echo $text_add_history; ?></legend>
						<form id="form-history"> 
							<input type="hidden" name="amount" value="<?php echo $amount; ?>">
							<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $entry_withdrawal_status; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="withdraw_status_id">
										<?php foreach ($withdraw_statuses as $withdraw_status) { ?>
											<?php if ($withdraw_status['withdraw_status_id'] == $withdraw_status_id) { ?>
												<option value="<?php echo $withdraw_status['withdraw_status_id']; ?>" selected><?php echo $withdraw_status['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $withdraw_status['withdraw_status_id']; ?>"><?php echo $withdraw_status['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label"><?php echo $entry_notify; ?></label>
								<div class="col-sm-10">
									<input type="checkbox" name="notify" value="1" id="input-notify" />
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label"><?php echo $entry_comment; ?></label>
								<div class="col-sm-10">
									<textarea name="comment" rows="8" id="input-history-comment" class="form-control"></textarea>
								</div>
							</div>
							<div class="text-right">
                			<button id="button-history" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $entry_comment; ?></button>
             			 </div>
						</form>	
					</fieldset>	

			</div><!-- Card -->
		</div><!-- container-fluid -->
	</div>
<script type="text/javascript">
	$('#history').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#history').load(this.href);
});			

$('#history').load('index.php/finance/withdrawal/history?user_token=<?php echo $user_token; ?>&withdraw_id=<?php echo $withdraw_id; ?>');

$('#button-history').on('click', function(e) {
	e.preventDefault();

	$.ajax({
		url: 'index.php/finance/withdrawal/addhistory?user_token=<?php echo $user_token; ?>&withdraw_id=<?php echo $withdraw_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'withdraw_status_id=' + encodeURIComponent($('#form-history select[name=\'withdraw_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('#form-history textarea[name=\'comment\']').val()) + '&<?= csrf_token() ?>=<?= csrf_hash() ?>&amount='  + encodeURIComponent($('#form-history input[name=\'amount\']').val()) + '&customer_id='  + encodeURIComponent($('#form-history input[name=\'customer_id\']').val()),
		beforeSend: function() {
			$('#button-history').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...');	
		},
		complete: function() {
			$('#button-history').html('<?php echo $entry_comment; ?>');	
		},
		success: function(json) {
			$('.alert-dismissible').remove();
	
			if (json['error']) {
				 $('#nav-history').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#history').load('index.php/finance/withdrawal/history?user_token=<?php echo $user_token; ?>&withdraw_id=<?php echo $withdraw_id; ?>');
				
				$('#nav-history').prepend('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#nav-history textarea[name=\'comment\']').val('');
			}
		}
	});
});
</script>	
<?php echo $footer; ?>
