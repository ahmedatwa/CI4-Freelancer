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
			<div class="card-body">
				
				<ul class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true"><?php echo $tab_general; ?></a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false"><?php echo $tab_history; ?></a>
					</li>
				</ul>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
						<fieldset class="mb-4">
							<legend><?php echo $text_details; ?></legend>
							<ul class="list-group list-group-flush">
								<li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i> Employer: <?php echo $employer; ?></li>
								<li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i> Freelancer: <?php echo $freelancer; ?></li>
								<li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i> Comment: <?php echo $comment; ?></li>
								<li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i> Project: <?php echo $project; ?></li>
							</ul>
						</fieldset>
						<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
							<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
							<div class="form-group row">
								<label class="col-md-2 col-form-label"><?php echo $entry_dispute_action; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="dispute_action_id">
										<?php foreach ($dispute_actions as $dispute_action) { ?>
											<?php if ($dispute_action['dispute_action_id'] == $dispute_action_id) { ?>
												<option value="<?php echo $dispute_action['dispute_action_id']; ?>" selected><?php echo $dispute_action['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $dispute_action['dispute_action_id']; ?>"><?php echo $dispute_action['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div> 
						</form>
					</div> <!----Tab general ./Div ---->
					<div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
					<fieldset class="mb-4">
						<legend><?php echo $text_history; ?></legend>
						<div id="history"></div>
					<fieldset class="mb-4">
						<legend><?php echo $text_add_history; ?></legend>
						<form id="form-history"> 
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $entry_dispute_status; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="dispute_status_id">
										<?php foreach ($dispute_statuses as $dispute_status) { ?>
											<?php if ($dispute_status['dispute_status_id'] == $dispute_status_id) { ?>
												<option value="<?php echo $dispute_status['dispute_status_id']; ?>" selected><?php echo $dispute_status['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $dispute_status['dispute_status_id']; ?>"><?php echo $dispute_status['name']; ?></option>
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
					</div>
				</div> <!---nav-tabContent ./Div --->

			</div><!-- Card -->
		</div><!-- container-fluid -->
	</div>
<script type="text/javascript">
	$('#history').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#history').load(this.href);
});			

$('#history').load('index.php/catalog/dispute/history?user_token=<?php echo $user_token; ?>&dispute_id=<?php echo $dispute_id; ?>');

$('#button-history').on('click', function(e) {
	e.preventDefault();

	$.ajax({
		url: 'index.php/catalog/dispute/addhistory?user_token=<?php echo $user_token; ?>&dispute_id=<?php echo $dispute_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'dispute_status_id=' + encodeURIComponent($('#nav-history select[name=\'dispute_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('#nav-history textarea[name=\'comment\']').val()) + '&<?= csrf_token() ?>=<?= csrf_hash() ?>' ,
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
				$('#history').load('index.php/catalog/dispute/history?user_token=<?php echo $user_token; ?>&dispute_id=<?php echo $dispute_id; ?>');
				
				$('#nav-history').prepend('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#nav-history textarea[name=\'comment\']').val('');
			}
		}
	});
});
</script>	
<?php echo $footer; ?>
