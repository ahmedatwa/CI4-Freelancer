<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<!-- Page Header Begin -->
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-right">
				<button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_save; ?>"><i class="far fa-save"></i></button>
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
			<div class="card-body">
				<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
					<ul class="nav nav-tabs mb-3" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active mr-2" id="<?php echo $tab_general;?>-tab" data-toggle="tab" href="#<?php echo $tab_general;?>" role="tab" aria-controls="<?php echo $tab_general; ?>" aria-selected="false"><?php echo $tab_general;?></a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link mr-2" id="<?php echo $tab_data;?>-tab" data-toggle="tab" href="#<?php echo $tab_data;?>" role="tab" aria-controls="<?php echo $tab_data;?>" aria-selected="false"><?php echo $tab_data;?></a>
						</li>
					</ul> 
					<div class="tab-content">
						<div class="tab-pane fade show active" id="<?php echo $tab_general; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_general; ?>-tab">
							<ul class="nav nav-tabs mb-3" id="language" role="tablist">
								<?php foreach ($languages as $language ) { ?>
									<li class="nav-item" role="presentation">
										<a class="nav-link mr-2" id="<?php echo $language['code']; ?>-tab" data-toggle="tab" href="#<?php echo $language['code']; ?>" role="tab" aria-controls="<?php echo $language['code']; ?>" aria-selected="false"><?php echo $language['name']; ?></a>
									</li>
								<?php } ?>
							</ul> 
							<div class="tab-content">
								<?php foreach ($languages as $language ) { ?>
									<div class="tab-pane" id="<?php echo $language['code']; ?>" role="tabpanel" aria-labelledby="<?php echo $language['code']; ?>-tab">
										<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
										<div class="form-group row required">
											<label for="input-name" class="col-md-2 col-form-label"><?php echo $entry_name; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-name-<?php echo $language['language_id']; ?>" name="project_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo $project_description[$language['language_id']]['name'] ?? ''; ?>">
												<?php echo form_error("project_description." . $language['language_id'].".name"); ?>
											</div>
										</div>
										<div class="form-group row required">
											<label for="input-description" class="col-md-2 col-form-label"><?php echo $entry_description; ?></label>
											<div class="col-md-10">
												<textarea class="form-control" data-toggle="summernote" type="text" id="input-description" name="project_description[<?php echo $language['language_id']; ?>][description]"><?php echo $project_description[$language['language_id']]['description'] ?? ''; ?></textarea>
												<?php echo form_error("project_description." . $language['language_id'].".description"); ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="input-meta-title" class="col-md-2 col-form-label"><?php echo $entry_meta_title; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-meta-title" name="project_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo $project_description[$language['language_id']]['meta_title'] ?? ''; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="input-meta-description" class="col-md-2 col-form-label"><?php echo $entry_meta_description; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-meta-description" name="project_description[<?php echo $language['language_id']; ?>][meta_description]" value="<?php echo $project_description[$language['language_id']]['meta_description'] ?? ''; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="input-meta-keyword" class="col-md-2 col-form-label"><?php echo $entry_meta_keywords; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-meta-keyword" name="project_description[<?php echo $language['language_id']; ?>][meta_keyword]" value="<?php echo $project_description[$language['language_id']]['meta_keyword'] ?? ''; ?>" data-toggle="tagsinput">
											</div>
										</div>
										<div class="form-group row">
											<label for="input-tags" class="col-md-2 col-form-label"><?php echo $entry_tags; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-tags" name="project_description[<?php echo $language['language_id']; ?>][tags]" value="<?php echo $project_description[$language['language_id']]['tags'] ?? ''; ?>" data-toggle="tagsinput">
											</div>
										</div>
									</div>
								<?php } ?>
							</div><!-- tab content Language -->
						</div>
						<div class="tab-pane" id="<?php echo $tab_data; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_data; ?>-tab">
							<div class="form-group row">
								<label class="col-md-2 col-form-label"><?php echo $entry_employer; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="employer_id" data-width="100%">
										<option></option>
										<?php foreach($customers as $customer) { ?>
										<?php if ($customer['customer_id'] == $employer_id) { ?> 
											<option value="<?php echo $customer['customer_id']; ?>" selected><?php echo $customer['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div> 
							<div class="form-group row">
								<label for="input-sort-order" class="col-md-2 col-form-label"><?php echo $entry_sort_order; ?></label>
								<div class="col-md-10">
									<input class="form-control" type="text" id="input-sort-order" name="sort_order" value="<?php echo $sort_order; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-2 col-form-label"><?php echo $entry_status; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="status_id">
										<?php if ($status_id) { ?> 
											<option value="1" selected><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div> 
							<div class="form-group row">
								<label class="col-md-2 col-form-label"><?php echo $entry_type; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="type">
										<?php if ($type) { ?> 
											<option value="1" selected><?php echo $text_fixed_price; ?></option>
											<option value="2"><?php echo $text_per_hour; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_fixed_price; ?></option>
											<option value="2" selected><?php echo $text_per_hour; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="input-image" class="col-md-2 col-form-label"><?php echo $entry_image; ?></label>
								<div class="col-md-10">
									<a href="" id="thumb-image" data-toggle="image" class="img-fluid">
										<img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" class="img-thumbnail" /></a>
										<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
									</div>
								</div>  
							</div> <!--Tab Data --->
						</div> <!--- Tab Content -->
					</form>
				</div><!-- Card -->
			</div><!-- container-fluid -->
		</div>		
<link href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script src="assets/vendor/summernote/summernote-bs4.js"></script> 
<script src="assets/vendor/summernote/image-manager.js"></script> 
<link href="assets/vendor/summernote/summernote-bs4.css" rel="stylesheet">
<link href="assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/select2/js/select2.min.js"></script> 
<script type="text/javascript">
$('select[name=\'employer_id\']').select2({
		ajax: {
			url: "index.php/customer/customer/autocomplete?user_token=<?php echo $user_token; ?>",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					customer_id: params.term,
				};
			},
			processResults: function (data, params) {
				var results = $.map(data, function (item) {
					item.id = item.customer_id;
					item.text = item.name;
					return item;
				});
				return {
					results: results,
				};
			},
			cache: true
		},
	minimumInputLength: 3,
	placeholder: '<?php echo $text_select; ?>',
	allowClear: true,
	minimumResultsForSearch: 5
});
</script>
<!-- // tags input -->
<script type="text/javascript">
	$('input[data-toggle=\'tagsinput\']').tagsinput({
		maxTags: 5,
		trimValue: true,
		confirmKeys: [13, 44, 32]
	});
</script>
<script type="text/javascript">
	$('#language a:first').tab('show');
</script>
<?php echo $footer; ?>
