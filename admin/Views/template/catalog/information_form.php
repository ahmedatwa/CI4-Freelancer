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
											<label for="input-title" class="col-md-2 col-form-label"><?php echo $entry_title; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-title-<?php echo $language['language_id']; ?>" name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo $information_description[$language['language_id']]['title'] ?? ''; ?>">
												<?php echo form_error("information_description.".$language['language_id'].".title"); ?>
											</div>
										</div>
										<div class="form-group row required">
											<label for="input-description" class="col-md-2 col-form-label"><?php echo $entry_description; ?></label>
											<div class="col-md-10">
												<textarea class="form-control" data-toggle="summernote" type="text" id="input-description" name="information_description[<?php echo $language['language_id']; ?>][description]"><?php echo $information_description[$language['language_id']]['description'] ?? ''; ?></textarea>
												<?php echo form_error("information_description.".$language['language_id'].".description"); ?>
											</div>
										</div>
										<div class="form-group row required">
											<label for="input-meta-title" class="col-md-2 col-form-label"><?php echo $entry_meta_title; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-meta-title" name="information_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo $information_description[$language['language_id']]['meta_title'] ?? ''; ?>">
												<?php echo form_error("information_description.".$language['language_id'].".meta_title"); ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="input-meta-description" class="col-md-2 col-form-label"><?php echo $entry_meta_description; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-meta-description" name="information_description[<?php echo $language['language_id']; ?>][meta_description]" value="<?php echo $information_description[$language['language_id']]['meta_description'] ?? ''; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="input-meta-keyword" class="col-md-2 col-form-label"><?php echo $entry_meta_keywords; ?></label>
											<div class="col-md-10">
												<input class="form-control" type="text" id="input-meta-keyword" name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" value="<?php echo $information_description[$language['language_id']]['meta_keyword'] ?? ''; ?>" data-toggle="tagsinput">
											</div>
										</div>
									</div>
								<?php } ?>
							</div><!-- tab content Language -->
						</div>
						<div class="tab-pane" id="<?php echo $tab_data; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_data; ?>-tab">
							<div class="form-group row">
								<label for="input-seo-url" class="col-md-2 col-form-label"><?php echo $entry_seo_url; ?></label>
								<div class="col-md-10">
									<?php foreach ($languages as $language) { ?>
										<div class="input-group mb-1">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1"><?php echo $language['code']; ?></span>
											</div>
											<input class="form-control" type="text" id="input-seo-url-<?php echo $language['language_id']; ?>" name="seo_url[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo $seo_url[$language['language_id']]['keyword'] ?? ''; ?>" onkeyup="generateSeo(<?php echo $language['language_id']; ?>)">
										</div>
									<?php } ?>		
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
							</div> <!-- </div> language Content   -->
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
<script type="text/javascript">
	$('#language a:first').tab('show');
</script>
<script type="text/javascript">
function generateSeo(language_id){
	var input = $("#input-title-" + language_id).val().trim();
	var keyword = input.replace(/[\W_]+/g,"-").toLowerCase();
	$("#input-seo-url-" + language_id).val(keyword);
}
</script>
<?php echo $footer; ?>
