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
			<div class="card-body">
				<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="form-group row required">
						<label for="input-author" class="col-md-2 col-form-label"><?php echo $entry_author; ?></label>
						<div class="col-md-10">
							<input class="form-control" type="text" id="input-author" value="<?php echo $author; ?>" disabled>
						</div>
					</div>
					<div class="form-group row required">
						<label for="input-project-id" class="col-md-2 col-form-label"><?php echo $entry_project; ?></label>
						<div class="col-md-10">
							<select class="form-control" name="project_id" data-width="100%" disabled>
								<option></option>
								<?php foreach ($projects as $project) {?>
									<?php if ($project['project_id'] == $project_id) {?>
										<option value='<?php echo $project['project_id'] ?>' selected><?php echo $project['name'] ?> </option>
									<?php } else {?>
										<option value='<?php echo $project['project_id'] ?>'><?php echo $project['name'] ?> </option>
									<?php }?>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-text" class="col-md-2 col-form-label"><?php echo $entry_text; ?></label>
						<div class="col-md-10">
							<textarea class="form-control" type="text" id="input-text" cols="60" rows="8" disabled><?php echo $comment; ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-rating" class="col-md-2 col-form-label"><?php echo $entry_rating; ?></label>
						<div class="col-md-10">
							<input class="form-control" type="text" id="input-meta-description" value="<?php echo $rating; ?>" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-date-added" class="col-md-2 col-form-label"><?php echo $entry_date_added; ?></label>
						<div class="col-md-10">
							<input class="form-control" type="text" id="input-date-added" value="<?php echo $date_added; ?>" disabled>
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
				</form>
			</div><!-- Card -->
		</div><!-- container-fluid -->
	</div>
	<link href="assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
	<script src="assets/vendor/select2/js/select2.min.js"></script> 
	<script type="text/javascript">
		$('select[name=\'project_id\']').select2({
			ajax: {
				url: "index.php/catalog/review/autocomplete?user_token=<?php echo $user_token; ?>",
				dataType: 'json',
				delay: 250,
				theme: 'bootstrap4',
				data: function (params) {
					return {
						parent_id: params.term,
					};
				},
				processResults: function (data, params) {
					var results = $.map(data, function (item) {
						item.id = item.parent_id;
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
	<?php echo $footer; ?>
