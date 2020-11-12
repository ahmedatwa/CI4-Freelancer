<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header"> <!-- Page Header Begin -->
		<div class="container-fluid">
			<div class="float-right">
				<button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_save; ?>"><i class="far fa-save"></i></button></div>
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
		</div> <!-- Page Heaedr End -->
		<div class="container-fluid">
			<?php if ($error_warning){ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fas fa-exclamation-circle"></i> <?php echo $error_warning; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php } ?>
			<div class="card">
				<div class="card-header"><i class="far fa-edit"></i> <?php echo $text_form; ?></div>
				<div class="card-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation"><a class="nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true"><?php echo $tab_general; ?></a></li>
						<li class="nav-item" role="presentation"><a class="nav-link" id="nav-site-tab" data-toggle="tab" href="#nav-site" role="tab" aria-controls="nav-site" aria-selected="true"><?php echo $tab_site; ?> </a></li>
						<li class="nav-item" role="presentation"><a class="nav-link" id="nav-local-tab" data-toggle="tab" href="#nav-local" role="tab" aria-controls="nav-local" aria-selected="true"><?php echo $tab_local; ?> </a></li>
						<li class="nav-item" role="presentation"><a class="nav-link" id="nav-option-tab" data-toggle="tab" href="#nav-option" role="tab" aria-controls="nav-option" aria-selected="true"><?php echo $tab_option; ?> </a></li>
						<li class="nav-item" role="presentation"><a class="nav-link" id="nav-social-tab" data-toggle="tab" href="#nav-social" role="tab" aria-controls="nav-social" aria-selected="true"><?php echo $tab_social; ?> </a></li>
						<li class="nav-item" role="presentation"><a class="nav-link" id="nav-server-tab" data-toggle="tab" href="#nav-server" role="tab" aria-controls="nav-server" aria-selected="true"><?php echo $tab_server; ?> </a></li>
					</ul>
					<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
						<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
						<div class="tab-content">
							<!-- ./General Tab -->
							<div role="tabpanel" class="tab-pane fade show active mt-3" id="nav-general" aria-labelledby="nav-general-tab">
								<div class="form-group row required">
									<label class="col-sm-2 control-label" for="config-meta-title"><?php echo $entry_meta_title; ?> </label>
									<div class="col-sm-10">
										<input type="text" id="config-meta-title" name="config_meta_title" value="<?php echo $config_meta_title; ?>" placeholder="<?php echo $entry_meta_title; ?>" class="form-control">
										<?php echo form_error('config_meta_title'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label" for="input-meta-description"><?php echo $entry_meta_description; ?> </label>
									<div class="col-sm-10">
										<textarea id="config-meta-description" name="config_meta_description" row="5" class="form-control" placeholder="<?php echo $entry_meta_description; ?>"><?php echo $config_meta_description; ?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label" for="input-meta-keyword"><?php echo $entry_meta_keyword; ?> </label>
									<div class="col-sm-10">
										<textarea id="input-meta-keyword" name="config_meta_keyword" row="5" class="form-control" placeholder="<?php echo $entry_meta_keyword; ?>" data-toggle="tagsinput"><?php echo $config_meta_keyword; ?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label" for="input-theme"><?php echo $entry_theme; ?> </label>
									<div class="col-sm-10">
										<select class="form-control" name="config_theme">
											<?php foreach ($themes as $theme) { ?>
												<?php if ($theme['value'] == $config_theme) { ?>	
													<option value="<?php echo $theme['value']; ?>" selected><?php echo $theme['text']; ?></option>
												<?php } else { ?>
													<option value="<?php echo $theme['value']; ?>"><?php echo $theme['text']; ?></option>
												<?php } ?>	
											<?php } ?>	
										</select>	
									</div>
								</div>
								<div class="form-group row">
									<label for="input-image" class="col-md-2 col-form-label"><?php echo $entry_logo; ?></label>
									<div class="col-md-10">
										<a href="" id="thumb-config-logo" data-toggle="image">
											<img src="<?php echo $logo; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" class="img-thumbnail" /></a>
											<input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" id="input-config-logo" />
										</div>
									</div>
								</div><!-- ./End General Tab -->

								<!-- ./tab_store -->
								<div role="tabpanel" class="tab-pane fade mt-3" id="nav-site" aria-labelledby="nav-site-tab">
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-name" name="config_name" class="form-control" placeholder="<?php echo $entry_name; ?>" value="<?php echo $config_name; ?>">
											<?php echo form_error('config_name'); ?>
										</div>
									</div>
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-owner"><?php echo $entry_owner; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-owner" name="config_owner" class="form-control" placeholder="<?php echo $entry_owner; ?>" value="<?php echo $config_owner; ?>">
											<?php echo form_error('config_owner'); ?>
										</div>
									</div>
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-address" name="config_address" class="form-control" placeholder="<?php echo $entry_address; ?>" value="<?php echo $config_address; ?>">
											<?php echo form_error('config_address'); ?>
										</div>
									</div>
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-email" name="config_email" class="form-control" placeholder="<?php echo $entry_email; ?>" value="<?php echo $config_email; ?>">
											<?php echo form_error('config_email'); ?>
										</div>
									</div>
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-telephone" name="config_telephone" class="form-control" placeholder="<?php echo $entry_telephone; ?>" value="<?php echo $config_telephone; ?>">
											<?php echo form_error('config_telephone'); ?>
										</div>
									</div>
								</div><!-- ./End tab_store -->
								<!-- ./tab_local -->
								<div role="tabpanel" class="tab-pane fade mt-3" id="nav-local" aria-labelledby="nav-local-tab">
									<div class="form-group row">
										<label class="col-sm-2 control-label" for="input-langauge"><?php echo $entry_language; ?> </label>
										<div class="col-sm-10">
											<select name="config_language_id" class="form-control">
												<?php foreach($languages as $language) { ?>
													<?php if ($language['language_id'] == $config_language_id) { ?>
														<option value="<?php echo $language['language_id']; ?>" selected><?php echo $language['name']; ?></option>	
													<?php } else { ?>
														<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>	
													<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 control-label" for="input-admin-langauge"><?php echo $entry_admin_language; ?> </label>
										<div class="col-sm-10">
											<select name="config_admin_language_id" class="form-control">
												<?php foreach($languages as $language) { ?>
													<?php if ($language['language_id'] == $config_admin_language_id) { ?>
														<option value="<?php echo $language['language_id']; ?>" selected><?php echo $language['name']; ?></option>	
													<?php } else { ?>
														<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>	
													<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 control-label" for="input-currency"><?php echo $entry_currency; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-currency" name="config_currency" class="form-control" placeholder="<?php echo $entry_currency; ?>" value="<?php echo $config_currency; ?>">
										</div>
									</div>
								</div><!-- ./End tab_option -->
								<div role="tabpanel" class="tab-pane fade mt-3" id="nav-option" aria-labelledby="nav-option-tab">
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-config-admin-limit"><?php echo $entry_admin_limit; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-admin-limit" name="config_admin_limit" class="form-control" placeholder="<?php echo $entry_admin_limit; ?>" value="<?php echo $config_admin_limit; ?>">
											<?php echo form_error('config_admin_limit'); ?>
										</div>
									</div>
									<div class="form-group row required">
										<label class="col-sm-2 control-label" for="input-login-attempts"><?php echo $entry_login_attempts; ?> </label>
										<div class="col-sm-10">
											<input type="text" id="input-login-attempts" name="config_login_attempts" class="form-control" placeholder="<?php echo $entry_login_attempts; ?>" value="<?php echo $config_login_attempts; ?>">
											<?php echo form_error('config_login_attempts'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 control-label" for="input-project-status"><?php echo $entry_project_status; ?> </label>
										<div class="col-sm-10">
											<select name="config_project_status_id" class="form-control">
												<?php foreach($project_statuses as $project_status) { ?>
													<?php if ($project_status['status_id'] == $config_project_status_id) { ?>
														<option value="<?php echo $project_status['status_id']; ?>" selected><?php echo $project_status['name']; ?></option>	
													<?php } else { ?>
														<option value="<?php echo $project_status['status_id']; ?>"><?php echo $project_status['name']; ?></option>	
													<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 control-label" for="input-project-status"><?php echo $entry_project_completed_status; ?> </label>
										<div class="col-sm-10">
											<select name="config_project_completed_status" class="form-control">
												<?php foreach($project_statuses as $project_status) { ?>
													<?php if ($project_status['status_id'] == $config_project_completed_status) { ?>
														<option value="<?php echo $project_status['status_id']; ?>" selected><?php echo $project_status['name']; ?></option>	
													<?php } else { ?>
														<option value="<?php echo $project_status['status_id']; ?>"><?php echo $project_status['name']; ?></option>	
													<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>									
									<div class="form-group row">
										<label class="col-sm-2 control-label" for="input-project-status"><?php echo $entry_project_expired_status; ?> </label>
										<div class="col-sm-10">
											<select name="config_project_expired_status" class="form-control">
												<?php foreach($project_statuses as $project_status) { ?>
													<?php if ($project_status['status_id'] == $config_project_expired_status) { ?>
														<option value="<?php echo $project_status['status_id']; ?>" selected><?php echo $project_status['name']; ?></option>	
													<?php } else { ?>
														<option value="<?php echo $project_status['status_id']; ?>"><?php echo $project_status['name']; ?></option>	
													<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<fieldset>
										<legend><?php echo $text_customer; ?></legend>
										<div class="form-group row">
											<label class="col-sm-2 control-label" for="input-customer-activity"><?php echo $entry_customer_activity; ?> </label>
											<div class="col-sm-10">
												<?php if ($config_customer_activity == 1)	 { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_activity" value="1" checked>
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_activity" value="0">
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
													</div>
												<?php } else { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_activity" value="1">
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_activity" value="0" checked>
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 control-label" for="input-customer-activity"><?php echo $entry_customer_online; ?> </label>
											<div class="col-sm-10">
												<?php if ($config_customer_online == 1)	 { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_online" value="1" checked>
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_online" value="0">
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
													</div>
												<?php } else { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_online" value="1">
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_customer_online" value="0" checked>
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
													</div>
												<?php } ?>
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend><?php echo $text_fees; ?></legend>
										<div class="form-group row">
											<label class="col-sm-2 control-label" for="input-customer-activity"><?php echo $entry_freelancer_fee; ?> </label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="config_freelancer_fee" value="<?php echo $config_freelancer_fee; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 control-label" for="input-customer-activity"><?php echo $entry_processing_fee; ?> </label>
											<div class="col-sm-10">
												<div class="input-group mb-3">
													<input type="text" class="form-control" name="config_processing_fee" value="<?php echo $config_processing_fee; ?>" aria-label="" aria-describedby="basic-addon2">
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2">%</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 control-label" for="input-customer-activity"><?php echo $entry_upgrade_sponser; ?> </label>
											<div class="col-sm-10">
												<div class="input-group mb-3">
													<input type="text" class="form-control" name="config_upgrade_sponser" value="<?php echo $config_upgrade_sponser; ?>" aria-label="" aria-describedby="basic-addon2">
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2">EGP</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 control-label" for="input-customer-activity"><?php echo $entry_upgrade_highlight; ?> </label>
											<div class="col-sm-10">
												<div class="input-group mb-3">
													<input type="text" class="form-control" name="config_upgrade_highlight" value="<?php echo $config_upgrade_highlight; ?>" aria-label="" aria-describedby="basic-addon2">
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2">EGP</span>
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset>
									</div><!-- ./End tab_option -->
									<!-- ./tab_image -->
									<div role="tabpanel" class="tab-pane fade mt-3" id="nav-social" aria-labelledby="nav-social-tab">
										<div class="form-group row">
											<label for="facebook" class="col-sm-2 col-form-label"><?php echo $entry_facebook; ?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="config_facebook" value="<?php echo $config_facebook; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="facebook" class="col-sm-2 col-form-label"><?php echo $entry_twitter; ?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="config_twitter" value="<?php echo $config_twitter; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="facebook" class="col-sm-2 col-form-label"><?php echo $entry_pintrest; ?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="config_pintrest" value="<?php echo $config_pintrest; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="facebook" class="col-sm-2 col-form-label"><?php echo $entry_linkedin; ?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="config_linkedin" value="<?php echo $config_linkedin; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="facebook" class="col-sm-2 col-form-label"><?php echo $entry_instagram; ?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="config_instagram" value="<?php echo $config_instagram; ?>">
											</div>
										</div>

									</div><!-- ./End tab_social -->
									<!-- ./tab_server -->
									<div role="tabpanel" class="tab-pane fade mt-3" id="nav-server" aria-labelledby="nav-server-tab">
										<div class="form-group row">
											<label for="input-maintenance" class="col-sm-2 col-form-label"><?php echo $entry_maintenance; ?></label>
											<div class="col-sm-10">
												<?php if ($config_maintenance == 1)	 { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_maintenance" value="1" checked>
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_maintenance" value="0">
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
													</div>
												<?php } else { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_maintenance" value="1">
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="config_maintenance" value="0" checked>
														<label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>  <!-- ./End tab_server -->
								</div> <!-- End of Nav Tabs -->
							</form>
						</div><!-- Card Body -->
					</div><!-- Card -->
				</div><!-- container-fluid -->
			</div>
<link href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script type="text/javascript">
$('textarea[data-toggle=\'tagsinput\']').tagsinput({
		maxTags: 5,
		trimValue: true,
		confirmKeys: [13, 44, 32]
	});
</script> 
<?php if ($success) { ?>
    <!-- Success SweetAlert -->
    <script type="text/javascript">
        swal({
            title: 'Success!',
            text: '<?php echo $success; ?>',
            type: "success",
        }); 
    </script>
<?php } ?>
<?php echo $footer; ?>
