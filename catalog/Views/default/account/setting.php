<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-20">
	<div class="dashboard-content-inner">
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
		</div>
		<div class="row">
			<div class="col-12">
					<div class="shadow-sm p-3 mb-5 bg-white rounded border">
						<div class="mb-4">
							<h3><i class="icon-material-outline-account-circle"></i> <?php echo $text_account; ?></h3>
						</div>
						<div class="content with-padding padding-bottom-0" id="profile-form">
							<div class="row">
								<div class="col-sm-4 text-center">
									<div class="kv-avatar">
										<div class="file-loading">
											<input id="avatar-1" name="image" type="file">
										</div>
									</div>
									<div class="kv-avatar-hint">
										<small>Select file < 1500 KB | jpg,png,gif</small>
									</div>
									<div id="kv-avatar-errors" class="center-block" style="width:100%;display:none"></div>
								</div>
								<div class="col">
									<div class="row">
										<div class="col-12">
											<div class="submit-field required">
												<h5><?php echo $entry_firstname; ?></h5>
												<input type="text" class="form-control" id="input-firstname" name="firstname" value="<?php echo $firstname; ?>">
											</div>
										</div>
										<div class="col-12">
											<div class="submit-field required">
												<h5><?php echo $entry_lastname; ?></h5>
												<input type="text" class="form-control" id="input-lastname" name="lastname" value="<?php echo $lastname; ?>">
											</div>
										</div>
										<div class="col-12">
											<div class="submit-field">
												<h5><?php echo $entry_email; ?></h5>
												<input type="text" class="form-control" value="<?php echo $email; ?>" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 mt-4">
									<hr/>
									<div class="headline mb-4">
										<h3><i class="icon-material-outline-lock"></i> <?php echo $text_password_security; ?></h3>
									</div>
									<div class="row">	
										<div class="col-xs-12 col-md-4">
											<div class="submit-field required">
												<h5><?php echo $entry_current_password; ?></h5>
												<input type="password" class="form-control" id="input-current" name="current">
											</div>
										</div>
										<div class="col-xs-12 col-md-4">
											<div class="submit-field required">
												<h5><?php echo $entry_password; ?></h5>
												<input type="password" class="form-control" id="input-password" name="password">
											</div>
										</div>
										<div class="col-xs-12 col-md-4">
											<div class="submit-field required">
												<h5><?php echo $entry_confirm; ?></h5>
												<input type="password" class="form-control" id="input-confirm" name="confirm">
											</div>										
										</div>
									</div>
								</div>
								<div class="col-12">
									<button type="button" id="profile-form-button" class="button ripple-effect big margin-top-30 float-right">Update</button>
								</div>
							</div>
						</div>
					</div>
			</div>	
			<div class="col-12">
				<div class="shadow-sm p-3 mb-5 bg-white rounded border">
					<div class="headline mb-4">
						<h3><i class="icon-material-outline-face"></i> <?php echo $text_profile; ?> 
						<div class="progress my-2">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?php echo $profile_strength; ?>%" aria-valuenow="<?php echo $profile_strength; ?>" aria-valuemin="0" aria-valuemax="100">%<?php echo $profile_strength; ?></div>
						</div></h3>
						<small>Complete the information below for your profile to be considered as a Freelancer!</small>
					</div>
					<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" accept-charset="utf-8"> 
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="content">
						<ul class="fields-ul">
							<li>
								<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<span class="bidding-detail"><?php echo $text_hourly_rate; ?> : <?php echo $rate . ' ' .$currency; ?></span>
											<input class="range-slider" type="text" value="" data-provide="slider" data-slider-currency="$" data-slider-min="5" data-slider-max="150" data-slider-step="5" data-slider-value="<?php echo $rate; ?>" name="rate"/>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<h5><?php echo $entry_tagline; ?></h5>
											<input type="text" class="form-control" name="tag_line" value="<?php echo $tag_line; ?>">
										</div>
									</div>
									<div class="col-xl-12">
										<div class="submit-field">
											<h5><?php echo $text_about; ?></h5>
											<textarea cols="30" rows="5" name="about" class="form-control"><?php echo $about; ?></textarea>
										</div>
									</div>
									<legend>
										<div class="dropdown-divider"></div>
										<h4><?php echo $text_social; ?></h4>
									</legend>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5><?php echo $entry_facebook; ?></h5>
											<input type="text" class="form-control" name="facebook" value="<?php echo $facebook; ?>">
										</div>
									</div>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5><?php echo $entry_twitter; ?></h5>
											<input type="text" class="form-control" name="twitter" value="<?php echo $twitter; ?>">
										</div>
									</div>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5><?php echo $entry_linkedin; ?></h5>
											<input type="text" class="form-control" name="linkedin" value="<?php echo $linkedin; ?>">
										</div>
									</div>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5><?php echo $entry_github; ?></h5>
											<input type="text" class="form-control" name="github" value="<?php echo $github; ?>">
										</div>
									</div>
									<div class="col-12">
										<button type="submit" class="button ripple-effect big margin-top-30 float-right"><?php echo $button_submit; ?></button>
									</div>
									
									<div class="col-12 mt-4">
										<div class="dropdown-divider my-4"></div>
										<h5 class="mb-4">Profile Background Image:</h5>
										<div class="kv-avatar-2">
											<div class="file-loading">
												<input id="avatar-2" name="bg_image" type="file">
											</div>
										</div>
										<div class="kv-avatar2-hint">
											<small>Select file < 1500 KB | jpg,png,gif</small>
										</div>
										<div id="kv-avatar2-errors" class="center-block" style="width:100%;display:none"></div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
				<hr />
					<div class="headline">
						<h3><i class="fab fa-leanpub"></i> <?php echo $text_professional_heading; ?></h3>
						<small><?php echo $text_professional_sub; ?></small>
					</div>
					<div class="content with-padding">
						<!-- Certificates BEGIN -->
						<div class="accordion" id="certificatesAccordion">
							<div class="card-header p-2" id="headingOne">
								<h2 class="mb-0">
									<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#certificates" aria-expanded="true" aria-controls="collapseOne"><i class="fas fa-certificate"></i> <?php echo $tab_certificates; ?></button>
								</h2>
							</div>
							<div class="card-body">
								<div id="certificates" class="collapse" aria-labelledby="headingOne" data-parent="#certificatesAccordion">
									<div class="accordion-body__contents">
										<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="input-name"><?php echo $entry_certification; ?></label>
												<input type="text" class="form-control" id="input-certificate-name" name="certificate_name"
												placeholder="Certificate or Award">
											</div>
											<div class="form-group col-md-6">
												<label for="input-certificate-year"><?php echo $entry_year; ?></label>
												<select id="input-certificate-year" class="form-control" name="certificate_year">
													<?php foreach (seller_graduation_year() as $year) { ?>
														<option value="<?php echo $year['id']; ?>">
															<?php echo $year['text']; ?></option>
														<?php } ?>
													</select>
													<span class="lnr lnr-chevron-down"></span>
												</div>
												<div class="col-md-12">
													<button class="btn btn-primary btn-sm float-right" id="add-certificate" type="button"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>  
													</div>
												</div> 

												<hr />         
												<div id="certificates-list"></div>    
											</div>
										</div>
									</div>
								</div>
								<!-- Certificates END -->
								<div class="accordion" id="educationAccordion">
									<div class="card-header p-2" id="headingTwo">
										<h2 class="mb-0">
											<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#education" aria-expanded="true" aria-controls="headingTwo"><i class="fas fa-university"></i> <?php echo $tab_education; ?></button>
										</h2>
									</div>	
									<div class="card-body">
										<div id="education" class="collapse" aria-labelledby="headingTwo" data-parent="#educationAccordion">
											<div class="accordion-body__contents">
												<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
												<div class="form-row">
													<div class="form-group col-md-6">
														<label for="filter_university"><?php echo $entry_university; ?> <span data-toggle="tooltip" data-placement="top" title="Autocomplete"><i class="fas fa-info-circle"></i></span></label>
														<input type="text" class="form-control" id="filter_university" name="filter_university" placeholder="<?php echo $entry_university; ?>">
														<input name="university_id" id="input-university-id" type="hidden">
														<small class="form-text text-muted" id="error_filter_university"></small>
													</div>
													<div class="form-group col-md-4">
														<label for="country"><?php echo $entry_country; ?></label>
														<select class="form-control" name="education_country" id="input-education-country">
															<option value="*"><?php echo $text_select; ?></option>
															<?php foreach ($countries as $country) { ?>
																<option value="<?php echo $country['name'];?>"><?php echo $country['name'];?></option>
															<?php } ?>
														</select>
													</div>
													<div class="form-group col-md-3">
														<label for="major_title"><?php echo $entry_uni_title; ?></label>
														<select id="input-major-title" class="form-control" name="major_title">
															<option value=""><?php echo $text_select; ?></option>
															<?php foreach($education_titles as $title) { ?>
																<option value="<?php echo $title['value']; ?>">
																	<?php echo $title['text']; ?></option>
																<?php } ?>
															</select>
															<span class="lnr lnr-chevron-down"></span>
														</div>
														<div class="form-group col-md-6">
															<label for="filter_major"><?php echo $entry_major; ?> <span data-toggle="tooltip" data-placement="top" title="Autocomplete"><i class="fas fa-info-circle"></i></span></label>
															<input type="text" class="form-control" id="filter_major" name="filter_major">
															<input name="major_id" id="input-major-id" type="hidden">
														</div>
														<div class="form-group col-md-3">
															<label for="major_year"><?php echo $entry_year; ?></label>
															<select id="major_year" class="form-control" name="major_year">
																<?php foreach (seller_graduation_year() as $year) { ?>
																	<option value="<?php echo $year['id']; ?>">
																		<?php echo $year['text']; ?></option>
																	<?php } ?>
																</select>
																<span class="lnr lnr-chevron-down"></span>
															</div>
															<div class="col-md-12">
																<button class="btn btn-primary btn-sm ripple-effect float-right" id="add-education" type="button"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>  
																</div>
															</div>     
															<div id="educations-list"></div>    
														</div>
													</div>
												</div>
											</div>
											<!-- Education EDD  -->
											<div class="accordion" id="languageAccordion">
												<div class="card-header p-2" id="headingTwo">
													<h2 class="mb-0">
														<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#language" aria-expanded="true" aria-controls="headingTwo"><i class="fas fa-language"></i> <?php echo $tab_languages; ?></button>
													</h2>
												</div>	
												<div class="card-body">
													<div id="language" class="collapse" aria-labelledby="headingTwo" data-parent="#languageAccordion">
														<div class="accordion-body__contents">
															<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label for="filter_language"><?php echo $entry_language; ?> <span data-toggle="tooltip" data-placement="top" title="Autocomplete"><i class="fas fa-info-circle"></i></span></label>
																	<input type="hidden" name="language_id" value="">
																	<input type="text" class="form-control" id="input-language-name" name="language_name"
																	placeholder="<?php echo $text_add_language; ?>">
																</div>
																<div class="form-group col-md-6">
																	<label for="language_level"><?php echo $entry_language_level; ?></label>
																	<select id="input-language-level" class="form-control" name="language_level">
																		<option value=""><?php echo $text_select; ?></option>
																		<option value="1"><?php echo $text_basic; ?></option>
																		<option value="2"><?php echo $text_conversational; ?>
																	</option>
																	<option value="3"><?php echo $text_fluent; ?></option>
																	<option value="4"><?php echo $text_native_or_bilingual; ?></option>
																</select>
																<span class="lnr lnr-chevron-down"></span>
															</div>
															<div class="col-md-12">
																<button class="btn btn-primary float-right btn-sm" id="add-language" type="button"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>  
																</div>
															</div> 
															<div id="languages-list"></div>    
														</div>
													</div>
												</div>
											</div>
											<!-- Language EDD  -->
											<div class="accordion" id="skillsAccordion">
												<div class="card-header p-2" id="headingTwo">
													<h2 class="mb-0">
														<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#skills" aria-expanded="true" aria-controls="headingTwo"><i class="fas fa-chalkboard-teacher"></i> <?php echo $tab_skill; ?></button>
													</h2>
												</div>
												<div class="card-body">
													<div id="skills" class="collapse" aria-labelledby="headingTwo" data-parent="#skillsAccordion">
														<div class="accordion-body__contents">
															<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
															<input type="hidden" name="category_id" value="" />
															<div class="form-row">
																<label for="input-filter_skill"><?php echo $entry_skill; ?> <span data-toggle="tooltip" data-placement="top" title="Autocomplete"><i class="fas fa-info-circle"></i></span></label>
																<div class="input-group">
																	<input type="text" class="form-control" id="input-filter-skill" name="filter_category" placeholder="<?php echo $text_add_skill; ?>" value="">
																	<div class="input-group-append">
																		<button class="btn btn-primary" type="button" id="button-add-skill"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>
																	</div>
																</div>
															</div>      
															<div id="skills-list"></div>    
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> <!--row-->
						</div>
					</div>
<!-- Certifications START -->
<script type="text/javascript">
$('#add-certificate').on('click', function(){
	event.preventDefault();
    $.ajax({
        url: 'account/setting/addCertificate',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
			'X-Requested-With': 'XMLHttpRequest'
        },
        type: 'post',
        dataType: 'json',
        data: $('#certificates input, #certificates select'),
        beforeSend: function() {
        	$('.alert, .text-danger, .invalid-feedback').remove();
        	$('#input-certificate-name, #input-certificate-year').removeClass('is-invalid');
            $('#add-certificate').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('#certificates-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
        },
        complete: function() {
        	$('#spinner').remove();
            $('#add-certificate').html('<i class="icon-material-outline-add"></i> <?php echo $button_add;?>');
        },
        success: function(json) {

            if (json['error']) {
            	for (i in json['error']) {
            		var element = i.replace('_', '-');
            		$('#input-' + element).addClass('is-invalid')
                    $('#input-' + element).after('<div class="invalid-feedback">' + json['error'][i] + '</div>');
                }
            }

            if (json['success']) {
                $('#certificates-list').load('account/setting/getCertificates');

                $('#certificates').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
           alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
// Certificates List Table Pagination
$('#certificates-list').on('click', '.pagination a', function(e) {
    e.preventDefault();
    $('#certificates-list').fadeOut('slow');
    $('#certificates-list').load(this.href);
    $('#certificates-list').fadeIn('slow');
});
// load the Certificates List Table 
$('#certificates-list').load('account/setting/getCertificates');
//  Certificates Delete Button 
$('#certificates-list').on('click', 'button[id^=\'button-delete-certificate\']', function() {
	var node = this;
    bootbox.confirm({
    message: "Are You Sure?",
    size: 'small',
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
    	if (result === true) {
    	 $.ajax({
            url: 'account/setting/deleteCertificate?certificate_id=' + $(node).val(),
            headers: {
               'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
			   'X-Requested-With': 'XMLHttpRequest'
            },
            method : 'post',
            dataType: 'json',
            beforeSend: function() {
            	$('.alert, .text-danger').remove();
                $(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $('#certificates-list').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
            },
            complete: function() {
                $(node).html('<i class="icon-feather-trash-2"></i>');
            },
            success: function(json) {

                if (json['error']) {
                    $('#certificates-list').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#certificates-list').load('account/setting/getCertificates');
                    $('#certificates').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
      }
    }
 });
});
</script>
<!--Certifications END  -->
<!-- Education START -->
<script type="text/javascript">
$('input[name=\'filter_university\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'account/setting/universitiesAutocomplete?filter_university=' + encodeURIComponent(request.term),
            dataType : 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['university'],
                        value: item['university_id'],
                        country: item['country']
                    }
                }));
            }
        });
    },
    'select': function(event, ui) {
    	event.preventDefault();
        $('input[name=\'filter_university\']').val(ui.item.label);
        $('input[name=\'university_id\']').val(ui.item.value);
        $('input[name=\'education_country\']').val(ui.item.country);
    }
});
// Major
$('input[name=\'filter_major\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'account/setting/majorsAutocomplete?filter_major=' + encodeURIComponent(request.term),
            dataType : 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['text'],
                        value: item['major_id'],
                    }
                }));
            }
        });
    },
    'select': function(event, ui) {
        event.preventDefault();
        $('input[name=\'filter_major\']').val(ui.item.label);
        $('input[name=\'major_id\']').val(ui.item.value);
    }
});

$('#add-education').on('click', function() {
	 event.preventDefault();
    $.ajax({
        url: 'account/setting/addEducation',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
		  'X-Requested-With': 'XMLHttpRequest'
        },
        type: 'post',
        dataType: 'json',
        data: $('#education input, #education select'),
        beforeSend: function() {
        	$('.alert, .text-danger, .invalid-feedback').remove();
        	$('#education input, #education select').removeClass('is-invalid')
            $('#add-education').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('#languages-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
        },
        complete: function() {
            $('#spinner').remove();
            $('#add-education').html('<i class="icon-material-outline-add"></i> <?php echo $button_add;?>');
        },
        success: function(json) {

            if (json['error']) {
                for (i in json['error']) {
            		var element = i.replace('_', '-');
            		$('#input-' + element).addClass('is-invalid')
                    $('#input-' + element).after('<div class="invalid-feedback">' + json['error'][i] + '</div>');
                }
            }

            if (json['success']) {
                $('#educations-list').load('account/setting/getEducation');
                $('#education').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
    });
});
// Skills List Table Pagination
$('#educations-list').on('click', '.pagination a', function(e) {
    e.preventDefault();
    $('#educations-list').fadeOut('slow');
    $('#educations-list').load(this.href);
    $('#educations-list').fadeIn('slow');
});
// load the Educations List Table 
$('#educations-list').load('account/setting/getEducation');
//  Educations Delete Button 
$('#educations-list').on('click', 'button[id^=\'button-delete-education\']', function() {
	var node  = this;
    bootbox.confirm({
    message: "Are You Sure?",
    size: 'small',
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
    	if (result === true) {
    	 $.ajax({
            url: 'account/setting/deleteEducation?education_id=' + $(node).val(),
            headers: {
               'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
			   'X-Requested-With': 'XMLHttpRequest'
            },
            method: 'post',
            dataType: 'json',
            beforeSend: function() {
            	$('.alert, .text-danger').remove();
                $(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $('#educations-list-list').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')

            },
            complete: function() {
                $(node).html('<i class="icon-feather-trash-2"></i>');
            },
            success: function(json) {

                if (json['error']) {
                    $('#educations-list').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#educations-list').load('account/setting/getEducation');
                    $('#educations-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
      }
    }
 });
});
</script>
<!-- Education END -->
<!-- Languages Start -->
<script type="text/javascript">
$('input[name=\'language_name\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'account/setting/languagesAutocomplete?filter_language=' + encodeURIComponent(request.term),
            dataType : 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['text'],
                        value: item['language_id'],
                    }
                }));
            }
        });
    },
    'select': function(event, ui) {
        event.preventDefault();
        $('input[name=\'language_name\']').val(ui.item.label);
        $('input[name=\'language_id\']').val(ui.item.value);
    }
});

$('#add-language').on('click', function() {
    $.ajax({
        url: 'account/setting/addLanguage',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
		  'X-Requested-With': 'XMLHttpRequest'
        },
        type: 'post',
        dataType: 'json',
        data: $('#language select, #language input'),
        beforeSend: function() {
        	$('.alert, .text-danger').remove();
        	$('#input-language-name, #input-language-level').removeClass('is-invalid');
            $('#add-language').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('#languages-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
        },
        complete: function() {
        	$('#spinner').remove();
            $('#add-language').html('<i class="icon-material-outline-add"></i> <?php echo $button_add;?>');
        },
        success: function(json) {
            if (json['error']) {
            	for (i in json['error']) {
            		var element = i.replace('_', '-');
            		$('#input-' + element).addClass('is-invalid')
                    $('#input-' + element).after('<div class="invalid-feedback">' + json['error'][i] + '</div>');
                }
            }

            if (json['success']) {
                $('#languages-list').load('account/setting/getLanguages');
                $('#language').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
    });
});
// Languages List Table Pagination
$('#languages-list').on('click', '.pagination a', function(e) {
    e.preventDefault();
    $('#languages-list').fadeOut('slow');
    $('#languages-list').load(this.href);
    $('#languages-list').fadeIn('slow');
});
// load the Languages List Table 
$('#languages-list').load('account/setting/getLanguages');
//  Languages Delete Button 
$('#languages-list').on('click', 'button[id^=\'button-delete-language\']', function() {
	var node = this
	bootbox.confirm({
    message: "Are You Sure?",
    size: 'small',
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
    	if (result === true) {
        $.ajax({
            url: 'account/setting/deleteLanguage?language_id=' + $(node).val(),
            headers: {
              'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
			  'X-Requested-With': 'XMLHttpRequest'
            },
            method: 'post',
            dataType: 'json',
            beforeSend: function() {
            	$('.alert, .text-danger').remove();
                $('#languages-list').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
            },
            complete: function() {
                $('#languages-list').html('');
            },
            success: function(json) {
                if (json['error']) {
                    $('#language').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#languages-list').load('account/setting/getLanguages');
                    $('#language').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
      }
    }
 });
});
</script>
<!-- languages End -->
<!-- Skills Start -->
<script type="text/javascript">
$('input[name=\'filter_category\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'project/category/autocomplete?filter_category=' + encodeURIComponent(request.term),
            dataType : 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['name'],
                        value: item['category_id'],
                    }
                }));
            }
        });
    },
    'select': function(event, ui) {
    	event.preventDefault();
        $('input[name=\'category_id\']').val(ui.item.value);
        $('input[name=\'filter_category\']').val(ui.item.label);
    }
});

$('#button-add-skill').on('click', function() {
	 event.preventDefault();
    $.ajax({
        url: 'account/setting/addSkill',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
		  'X-Requested-With': 'XMLHttpRequest'
        },
        type: 'post',
        dataType: 'json',
        data: $('#skillsAccordion input[type=\'hidden\']'),
        beforeSend: function() {
        	$('.alert, .text-danger, .invalid-feedback').remove();	
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('#skills-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>')
        },
        complete: function() {
        	$('#spinner').remove();
            $(this).html('<i class="icon-material-outline-add"></i> <?php echo $button_add;?>');
        },
        success: function(json) {
            if (json['error']) {
            	$('#input-filter-skill').addClass('is-invalid');
                $('#skills .input-group').after('<div class="invalid-feedback d-block">' + json['error'] + '</div>');
            }

            if (json['success']) {
                $('#skills-list').load('account/setting/getSkills');
                $('#skills').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
         alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
    });
});
// Skills List Table Pagination
$('#skills-list').on('click', '.pagination a', function(e) {
    e.preventDefault();
    $('#skills-list').fadeOut('slow');
    $('#skills-list').load(this.href);
    $('#skills-list').fadeIn('slow');
});
// load the Skills List Table 
$('#skills-list').load('account/setting/getSkills');
//  Skills Delete Button 
$('#skills-list').on('click', 'button[id^=\'button-delete-skill\']', function() {
	var node  = this;
    bootbox.confirm({
    message: "Are You Sure?",
    size: 'small',
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
    	if (result === true) {
        $.ajax({
            url: 'account/setting/deleteSkill?category_id=' + $(node).val(),
            headers: {
              'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
			  'X-Requested-With': 'XMLHttpRequest'
            },
            method: 'post',
            dataType: 'json',
            beforeSend: function() {
            	$('.alert, .text-danger').remove();
                $(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            },
            complete: function() {
                $(node).html('<i class="icon-feather-trash-2"></i>');
            },
            success: function(json) {
                if (json['error']) {
                    $('#skills-list').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#skills-list').load('account/setting/getSkills');
                    $('#skills').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
      }
    }
 });
});
</script>
<link href="catalog/default/vendor/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="catalog/default/vendor/bootstrap-fileinput/themes/fas/theme.min.js"></script>
<script type="text/javascript">
$("#avatar-1").fileinput({
	uploadUrl: 'account/setting/avatarUpload',
    maxFileSize: 1500,
    overwriteInitial: true,
	initialPreviewAsData: true,
    showClose: false,
    showCaption: false,
    showUpload: true,
    showBrowse: false,
	showRemove: true,
    theme: 'fas',
    browseOnZoneClick: true,
    fileActionSettings: {
       showZoom: false,
       showDrag: false,
	   removeClass: 'd-none',
	   showUpload: false,
    },
    removeIcon: '<i class="far fa-window-close"></i>',
	removeLabel: '',
	removeTitle: 'Cancel or reset changes',
    removeClass: 'btn btn-danger',
    uploadExtraData: {
        'csrf-token': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
        'X-Requested-With': 'XMLHttpRequest'
    },
    elErrorContainer: '#kv-avatar-errors',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<?php echo $thumb; ?>',
    allowedFileExtensions: ["jpg", "png", "gif"]
});

// BG Image
$("#avatar-2").fileinput({
	uploadUrl: 'account/setting/backgroundImageUpload',
    maxFileSize: 1500,
    overwriteInitial: true,
	initialPreviewAsData: true,
    showClose: false,
    showCaption: true,
    showUpload: true,
    showBrowse: true,
	showRemove: true,
    theme: 'fas',
    browseOnZoneClick: false,
    fileActionSettings: {
       showZoom: false,
       showDrag: false,
	   removeClass: 'd-none',
	   showUpload: false,
    },
    removeIcon: '<i class="far fa-window-close"></i>',
	removeLabel: 'Remove',
	removeTitle: 'Cancel or reset changes',
    removeClass: 'btn btn-danger',
    uploadExtraData: {
        'csrf-token': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
        'X-Requested-With': 'XMLHttpRequest'
    },
    elErrorContainer: '#kv-avatar2-errors',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<?php echo $bg_thumb; ?>',
    allowedFileExtensions: ["jpg", "png", "gif"]
});
</script>
<!-- password change -->
<script type="text/javascript">
	$('#profile-form-button').on('click', function() {
		var node = this;
		$.ajax({
			url: 'account/setting/profileUpdate',
			headers: {
               'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
			method: 'post',
			dataType : 'json',
			data: $('#profile-form input'), 
			beforeSend: function() {
				$('.alert, .text-danger, .invalid-feedback').remove();
				$('#profile-form input').removeClass('is-invalid');
				$(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
			},
			complete: function () {
				$('.spinner-border').remove();
				$(node).html('Update');
			},
			success: function (json) {
				// validation errors
				if (json['error']) {
				    for(i in json['error']) {
						var el = $('#input-' + i.replace('_', '-'));
			            if (el) {
							el.after('<div class="invalid-feedback">' + json['error'][i] + '</div>');
							el.addClass('is-invalid');
						} 
					}

					if (json['error']['error_password']) {
						$('input-password').prepend('<div class="invalid-feedback">' + json['error']['error_password'] + '</div>');
					}

					if (json['error']['old_password']) {
						$('#profile-form-form .content').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+ json['error']['old_password'] +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					}
				}

				if (json['success']) {
					$(node).before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> '+ json['success'] +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#profile-form-form input').val('');
				}
			},
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
		});
	});
</script>
<?php if ($error_warning) { ?>
<script type="text/javascript">
	$.notify({
	// options
	icon: 'fas fa-exclamation-circle',
	title: 'Warning:',
	message: "<?php echo $error_warning; ?>",
},{
	// settings
	element: 'body',
	type: "danger",
	allow_dismiss: false,
	placement: {
		from: "bottom",
		align: "left"
	},
	animate: {
		enter: 'animate__animated animate__fadeInDown',
		exit: 'animate__animated animate__fadeOutUp'
	},
});	
</script>								
<?php } ?>
<?php if ($success) { ?>
<script type="text/javascript">
	$.notify({
	// options
	icon: 'fas fa-check-circle',
	title: 'Success:',
	message: "<?php echo $success; ?>",
},{
	// settings
	element: 'body',
	type: "success",
	allow_dismiss: false,
	placement: {
		from: "bottom",
		align: "left"
	},
	animate: {
		enter: 'animate__animated animate__fadeInDown',
		exit: 'animate__animated animate__fadeOutUp'
	},
});	
</script>								
<?php } ?>
<?php echo $footer; ?>