<?php echo $header; ?>
<section class="hero-area single-page-header">
	<div class="dashboard_menu_area">
		<div class="container-fluid">
			<div class="row justify-content-center single-page-header-inner">
				<div class="col-md-10 text-left">
					<div class="header-details">
						<h3 class="text-white"><?php echo $text_tell_us; ?></h3><br />
						<small><?php echo $text_sub; ?></small>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="container">	
	<div class="container ">
		<div class="row justify-content-center">
			<!-- Dashboard Box -->
			<div class="col-md-12">
				<div class="add-project-box margin-top-30">
					<?php if($error_warning) { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<i class="fas fa-exclamation-circle"></i> <?php echo $error_warning; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } ?>
					<!-- Headline -->
					<div class="headline mb-2">
						<h3 class=""><i class="icon-feather-folder-plus"></i> <?php echo $text_form; ?>
						<hr />
					</div>
					<div class="content with-padding padding-bottom-10">
						<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" accept-charset="utf-8"> 
							<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
							<input type="hidden" name="employer_id" value="<?= $employer_id ?>" />
							<div class="form-group">
								<label for="staticEmail" class="col-form-label"><?php echo $entry_name; ?></label>
								<input type="text" class="form-control" placeholder="e.g. build me a website" name="project_description[<?php echo $language_id;?>][name]" value="<?php echo $project_description[$language_id]['name'] ?? ''; ?>">
								<?php echo formError("project_description." . $language_id.".name"); ?>
							</div>
							<div class="form-group">
								<label for="staticEmail" class="ol-form-label"><?php echo $entry_description; ?></label>
								<textarea cols="5" row="5" class="form-control" name="project_description[<?php echo $language_id;?>][description]"><?php echo $project_description[$language_id]['description'] ?? ''; ?></textarea>
								<?php echo formError("project_description." . $language_id.".description"); ?>
							</div>
							<div class="form-group">
								<label for="staticEmail" class="col-form-label"><?php echo $entry_category; ?></label>
								<select class="form-control" name="filter_category" data-width="100%" multiple="multiple">
									<option></option>
									<?php foreach($categories as $category) { ?>
										<?php if ($category['category_id'] == $category_id) { ?> 
											<option value="<?php echo $category['category_id']; ?>" selected><?php echo $category['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="form-group ">
								<label for="staticEmail" class="col-sm-2 col-form-label"><?php echo $text_estimate; ?></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text bg-danger text-white"><?php echo $entry_min; ?></span>
									</div>
									<input type="text" class="form-control" name="budget_min" value="<?php echo $budget_min; ?>">
									<div class="input-group-prepend">
										<span class="input-group-text bg-success text-white"><?php echo $entry_max; ?></span>
									</div>
									<input type="text" class="form-control" name="budget_max" value="<?php echo $budget_min; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="staticEmail" class="col-sm-2 col-form-label"><?php echo $text_type; ?></label>
								<div class="col-sm-10">
									<?php if ($type == 1)	 { ?>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="type" value="1" checked>
											<label class="form-check-label" for="inlineRadio1"><?php echo $text_fixed_price; ?></label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="type" value="2">
											<label class="form-check-label" for="inlineRadio1"><?php echo $text_per_hour; ?></label>
										</div>
									<?php } else { ?>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="type" value="1">
											<label class="form-check-label" for="inlineRadio1"><?php echo $text_fixed_price; ?></label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="type" value="2" checked>
											<label class="form-check-label" for="inlineRadio1"><?php echo $text_per_hour; ?></label>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label for="date-end" class="col-form-label"><?php echo $entry_days_open; ?><span data-toggle="tooltip" title="<?php echo $help_date_end; ?>" datat-placement="top" class="text-primary"> <i class="icon-material-outline-help-outline"></i></span></label>
									<input type="number" class="form-control" name="runtime" value="" min="3" max="30">
								</div>
							<div class="form-group">
								<label class="col-form-label"><?php echo $entry_status; ?></label>
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
							<div class="padding-top-20 text-right padding-bottom-30">
								<button type="submit" class="button btn-sm ripple-effect" data-toggle="tooltip" title="<?php echo $button_save; ?>" data-placement="top"><i class="icon-material-outline-add"></i> <?php echo $button_save; ?></button>
							</div>	
						</div>


					</form>
				</div>
				<!-- Row / End -->
				<div class="dashboard-footer-spacer"></div>
				<link href="catalog/default/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
				<script src="catalog/default/vendor/select2/js/select2.min.js"></script> 
				<script type="text/javascript">
					$('select[name^=\'filter_category\']').select2({
						ajax: {
							url: "category/autocomplete",
							dataType: 'json',
							delay: 250,
							data: function (params) {
								return {
									filter_category: params.term,
								};
							},
							processResults: function (data, params) {
								var results = $.map(data, function (item) {
									item.id = item.category_id;
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
// Skills
$('select[name^=\'skill_id\']').select2({
	ajax: {
		url: "account/skill/autocomplete",
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
				project_skill: params.term,
			};
		},
		processResults: function (data, params) {
			var results = $.map(data, function (item) {
				item.id = item.skill_id;
				item.text = item.text;
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

	$('#summernote').summernote({
		height: 300,                 
		focus: true,
		toolbar: [
		['style', ['style']],
		['font', ['bold', 'underline', 'clear']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['table', ['table']],
		['view', ['fullscreen', 'codeview', 'help']]
		]   
	});
</script>
