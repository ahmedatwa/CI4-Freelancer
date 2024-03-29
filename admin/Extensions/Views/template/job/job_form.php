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
				<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
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

							<div class="form-group row required">
								<label for="input-name" class="col-md-2 col-form-label"><?php echo $entry_name; ?></label>
								<div class="col-md-10">
									<input class="form-control" type="text" id="input-name" name="job_description[name]" value="<?php echo $job_description['name'] ?? ''; ?>">
									<?php echo form_error("job_description.name"); ?>
								</div>
							</div>
							<div class="form-group row required">
								<label for="input-description" class="col-md-2 col-form-label"><?php echo $entry_description; ?></label>
								<div class="col-md-10">
									<textarea class="form-control" data-toggle="summernote" type="text" id="input-description" name="job_description[description]"><?php echo $job_description['description'] ?? ''; ?></textarea>
									<?php echo form_error("job_description.description"); ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="input-meta-title" class="col-md-2 col-form-label"><?php echo $entry_meta_title; ?></label>
								<div class="col-md-10">
									<input class="form-control" type="text" id="input-meta-title" name="job_description[meta_title]" value="<?php echo $job_description['meta_title'] ?? ''; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="input-meta-description" class="col-md-2 col-form-label"><?php echo $entry_meta_description; ?></label>
								<div class="col-md-10">
									<input class="form-control" type="text" id="input-meta-description" name="job_description[meta_description]" value="<?php echo $job_description['meta_description'] ?? ''; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="input-meta-keyword" class="col-md-2 col-form-label"><?php echo $entry_meta_keywords; ?></label>
								<div class="col-md-10">
									<input class="form-control" type="text" id="input-meta-keyword" name="job_description[meta_keyword]" value="<?php echo $job_description['meta_keyword'] ?? ''; ?>" data-toggle="tagsinput">
								</div>
							</div>
						</div>
						<div class="tab-pane" id="<?php echo $tab_data; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_data; ?>-tab">
							<div class="form-group row">
								<label class="col-md-2 col-form-label"><?php echo $entry_employer; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="customer_id" data-width="100%">
										<option></option>
										<?php foreach($customers as $customer) { ?>
										<?php if ($customer['customer_id'] == $customer_id) { ?> 
											<option value="<?php echo $customer['customer_id']; ?>" selected><?php echo $customer['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div> 
							<div class="form-group row">
								<label class="col-md-2 col-form-label"><?php echo $entry_type; ?></label>
								<div class="col-md-10">
									<select class="form-control" name="type">
										<?php if ($type == 1) { ?> 
											<option value="1" selected><?php echo $text_full_time; ?></option>
											<option value="2"><?php echo $text_part_time; ?></option>
											<option value="3"><?php echo $text_intern; ?></option>
											<option value="4"><?php echo $text_temporary; ?></option>
										<?php } elseif ($type == 2) { ?>
											<option value="1"><?php echo $text_full_time; ?></option>
											<option value="2" selected><?php echo $text_part_time; ?></option>
											<option value="3"><?php echo $text_intern; ?></option>
											<option value="4"><?php echo $text_temporary; ?></option>
										<?php } elseif ($type == 3) { ?>
											<option value="1"><?php echo $text_full_time; ?></option>
											<option value="2"><?php echo $text_part_time; ?></option>
											<option value="3" selected=""><?php echo $text_intern; ?></option>
											<option value="4"><?php echo $text_temporary; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_full_time; ?></option>
											<option value="2"><?php echo $text_part_time; ?></option>
											<option value="3"><?php echo $text_intern; ?></option>
											<option value="4" selected><?php echo $text_temporary; ?></option>
										<?php } ?> 
									</select>
								</div>
							</div> 
							<div class="form-group row">
								<label for="input-salary" class="col-md-2 col-form-label"><?php echo $entry_salary; ?></label>
								<div class="col-md-10">
									<input class="form-control" type="text" id="input-salary" name="salary" value="<?php echo $salary; ?>">
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
									<select class="form-control" name="status">
										<?php if ($status) { ?> 
											<option value="1" selected><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div> 
						</div>
					</div>
				</form>
			</div><!-- Card -->
		</div><!-- container-fluid -->
	</div>
</div>
<link href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script src="assets/vendor/summernote/summernote-bs4.js"></script> 
<script src="assets/vendor/summernote/image-manager.js"></script> 
<link href="assets/vendor/summernote/summernote-bs4.css" rel="stylesheet">
<link href="assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/select2/js/select2.min.js"></script> 
<script type="text/javascript">
$('select[name=\'customer_id\']').select2({
ajax: {
	url: "index.php/customer/customer/autocomplete?user_token=<?php echo $user_token; ?>",
	dataType: 'json',
	delay: 250,
	data: function (params) {
		return {
			filter_name: params.term,
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
minimumInputLength: 1,
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
<?php echo $footer; ?>
