<?php echo $header; ?>
<div class="jumbotron">
	<div class="container-fluid">
		<h3 class="display-5"><?php echo $text_tell_us; ?></h3><br />
		<p class="lead"><?php echo $text_sub; ?></p>
	</div>
</div>
<div class="section padding-bottom-60 full-width-carousel-fix">
<div class="container">	
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="add-project-box margin-top-30 shadow-sm p-3 mb-5 bg-white rounded border">
					<div class="headline mb-2">
						<h3 class=""><i class="icon-feather-folder-plus"></i> <?php echo $text_form; ?></h3>
						<hr />
					</div>
					<div class="content with-padding padding-bottom-10">
						<form enctype="multipart/form-data" method="post" action="" accept-charset="utf-8" id="form-project-add"> 
							<input type="hidden" name="employer_id" value="<?= $employer_id ?>" />
							<div class="form-group row">
								<label for="input-name" class="col-sm-3 col-form-label"><?php echo $entry_name; ?></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="e.g. build me a website" name="project_description[<?php echo $language_id;?>][name]" value="<?php echo $project_description[$language_id]['name'] ?? ''; ?>" id="input-<?php echo $language_id;?>-name">
								</div>
							</div>
							<div class="form-group row mb-4">
								<label for="input-description" class="col-sm-3 col-form-label"><?php echo $entry_description; ?></label>
								<div class="col-sm-9">
									<textarea rows="10" class="form-control" name="project_description[<?php echo $language_id;?>][description]" id="input-<?php echo $language_id;?>-description"><?php echo $project_description[$language_id]['description'] ?? ''; ?></textarea>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group row margin-top-30">
							<label for="input-upload" class="col-sm-3 col-form-label"><?php echo $entry_upload; ?><span data-toggle="tooltip" title="<?php echo $help_upload; ?>" datat-placement="top" class="text-primary"> <i class="icon-material-outline-help-outline"></i></span></label>
								<div class="col-sm-9">
									<input type="file" class="form-control" name="file" id="input-upload" value="">
									<input type="hidden" name="download_id" value="">
									<div id="kartik-file-errors"></div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group row">
								<label for="input-category" class="col-sm-3 col-form-label"><?php echo $entry_skills; ?></label>
								<div class="col-sm-9">
									<select class="form-control" name="category[]" data-width="100%" multiple="multiple" id="input-category">
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
							</div>
							<div class="form-group row align-items-center mb-3">
								<label for="input-budget" class="col-sm-3 col-form-label"><?php echo $text_budget; ?><span data-toggle="tooltip" title="<?php echo $help_budget; ?>" datat-placement="top" class="text-primary"> <i class="icon-material-outline-help-outline"></i></span></label>
								<div class="col">
									<label class="sr-only" for="inlineFormInput"><?php echo $entry_min;?></label>
									<div class="input-group mb-2">
										<div class="input-group-prepend">
											<div class="input-group-text"><?php echo $config_currency;?></div>
										</div>
										<input type="text" class="form-control" placeholder="<?php echo $entry_min;?>" name="budget_min" value=""id="input-budget_min">
									</div>
								</div>
								<div class="col">
									<label class="sr-only" for="inlineFormInputGroup"><?php echo $entry_max;?></label>
									<div class="input-group mb-2">
										<div class="input-group-prepend">
											<div class="input-group-text"><?php echo $config_currency;?></div>
										</div>
										<input type="text" class="form-control" placeholder="<?php echo $entry_max;?>" name="budget_max" value=""id="input-budget_max">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="input-type" class="col-sm-3 col-form-label"><?php echo $text_type; ?></label>
								<div class="col-sm-9">
									<?php if ($type == 1) { ?>
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
							<div class="form-group row">
								<label for="date-end" class="col-sm-3 col-form-label"><?php echo $entry_delivery_time; ?><span data-toggle="tooltip" title="<?php echo $help_delivery; ?>" datat-placement="top" class="text-primary"> <i class="icon-material-outline-help-outline"></i></span></label>
								<div class="col-sm-9">
									<input type="number" class="form-control" name="delivery_time" placeholder="<?php echo $entry_delivery_time; ?>" value="" min="1" max="30" id="input-delivery_time">
								</div>
							</div>
							<div class="form-group row">
								<label for="date-end" class="col-sm-3 col-form-label"><?php echo $entry_run_time; ?><span data-toggle="tooltip" title="<?php echo $help_bidding_duration; ?>" datat-placement="top" class="text-primary"> <i class="icon-material-outline-help-outline"></i></span></label>
								<div class="col-sm-9">
									<input type="number" class="form-control" name="runtime" placeholder="<?php echo $entry_run_time; ?>" id="input-runtime" min="1" max="30">
								</div>
							</div>
							<div class="padding-top-20 text-right padding-bottom-30">
								<button type="button" class="button btn-sm ripple-effect" id="button-project-add"><i class="icon-material-outline-add"></i> <?php echo $button_save; ?></button>
							</div>	
						</div>
						</div>
					</form>
				</div>
				<!-- Row / End -->
			</div>
		</div>
	</div>
</div>
<script src="catalog/default/vendor/jQuery-Text-Counter/textcounter.min.js"></script> 
<link href="catalog/default/vendor/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="catalog/default/vendor/bootstrap-fileinput/themes/fas/theme.min.js"></script>
<script type="text/javascript">
$('select[name^=\'category\']').select2({
ajax: {
	url: "project/category/autocomplete",
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
theme: 'bootstrap4',
placeholder: '<?php echo $text_select; ?>',
allowClear: true,
minimumResultsForSearch: 5
});
</script>
<script type="text/javascript">
$("#input-upload").fileinput({
	uploadUrl: 'tool/upload?type=1',
	enableResumableUpload: false,
    uploadExtraData: {
        'csrf-token': $('meta[name="csrf-token"]').attr('content'), 
        'X-Requested-With': 'XMLHttpRequest'
    },
    maxFileCount: 1,
    showPreview: false,
    showUpload: true,
    showCancel: true,
    autoReplace: true,
	theme: 'fas',
    preferIconicPreview: true, 
    elErrorContainer: '#kartik-file-errors',
    allowedFileExtensions: <?php echo json_encode($allowedFileExtensions); ?>,
 }).on('fileuploaded', function(event, data, previewId, index) {
 	   var response = data.response, reader = data.reader;
       $('input[name=\'download_id\']').val(response.download_id);
       $('#input-upload').fileinput('lock');
	   //$('#input-upload').fileinput('refresh', {showUpload: false}).fileinput('disable');
 });

</script>
<!-- // tags input -->
<script type="text/javascript">
$('#input-<?php echo $language_id; ?>-description').textcounter({
	min: 30,
	max: 1000,
	countDown: true,
	stopInputAtMaximum : true,  
	minimumErrorText : "Please enter at least 30 characters", 
});
$('#input-<?php echo $language_id; ?>-name').textcounter({
	min: 10,
	max: 64,
	countDown: true,
	stopInputAtMaximum : true,  
	minimumErrorText : "Please enter at least 10 characters", 
});
</script>
<!-- Add Project -->
<script type="text/javascript">
$('#button-project-add').on('click', function() {
	const node = this;
	$.ajax({
	    url: 'project/project/add',
	    headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	      'X-Requested-With': 'XMLHttpRequest',
	      'Content-Type': 'application/x-www-form-urlencoded',
	    },
	    type: 'post',
	    dataType: 'json',
	    data: $('#form-project-add').serialize(),
	    beforeSend: function() {
	    	$('.invalid-feedback, .alert').remove();
			$('input, textarea').removeClass('is-invalid');
			$(node).prop('disabled', true);
			$(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
	    },
	    complete: function() {
			$(node).prop('disabled', false);
			$(node).html('<i class="icon-material-outline-add"></i> <?php echo $button_save; ?>');
	    },
	    success: function(json) {
	    	if (json['error']) {
	    		for (i in json['error']) { 
				  var el = i.split('.').join('-');
                  var input = $('#' + el.replace('project_description', 'input'));

				  if (input) {
					input.addClass('is-invalid');
	    		    input.after('<div class="invalid-feedback">' + json['error'][i]+ '</div>'); 
				  } 
	    		    $('#input-' + i).addClass('is-invalid');
	    		    $('#input-' + i).after('<div class="invalid-feedback">' + json['error'][i]+ '</div>');
	    		
				}
	            $('#form-project-add').before('<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error']['error_warning'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
	    	}

			if (json['redirect']) {
				location = json['redirect'];
			}

	    },
	    error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }	
    });
});
</script>
<?php echo $footer; ?>