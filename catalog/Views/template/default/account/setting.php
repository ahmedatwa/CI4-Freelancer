<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-20">
	<div class="dashboard-content-inner" >
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
		</div>
		<div class="row">
		<div class="col-12">
			<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
				<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
			   <div class="shadow-sm p-3 mb-5 bg-white rounded">
						<div class="mb-4">
							<h3><i class="icon-material-outline-account-circle"></i> <?php echo $text_account; ?></h3>
						</div>
						<div class="content with-padding padding-bottom-0">
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
										<div class="col-xl-6">
											<div class="submit-field required">
												<h5><?php echo $entry_firstname; ?></h5>
												<input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
												<?php echo formError('firstname'); ?>
											</div>
										</div>

										<div class="col-xl-6">
											<div class="submit-field required">
												<h5><?php echo $entry_lastname; ?></h5>
												<input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
												<?php echo formError('lastname'); ?>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="submit-field">
												<h5><?php echo $entry_email; ?></h5>
												<input type="text" class="form-control" value="<?php echo $email; ?>" disabled>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<div class="headline mt-4">
							<h3><i class="icon-material-outline-face"></i> <?php echo $text_profile; ?></h3>
						</div>
						<div class="content">
							<ul class="fields-ul">
								<li>
									<div class="row">
										<div class="col-xl-6">
											<div class="submit-field">
													<span class="bidding-detail"><?php echo $text_hourly_rate; ?> : <?php echo $currency; ?></span>
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
								   <div class="col-12">
									<button type="submit" class="button ripple-effect big margin-top-30 float-right"><?php echo $button_submit; ?></button>
									</div>
									</div>
								</li>
							</ul>
						</div>
				</div>
				</div>	
				</form>
				<!-- Dashboard Box -->
				<div class="col-12">
					<div class="shadow-sm p-3 mb-5 bg-white rounded" id="password-form">
						<div class="headline mb-4">
							<h3><i class="icon-material-outline-lock"></i> <?php echo $text_password_security; ?></h3>
						</div>
						<div class="content with-padding">
							<div class="row">
								<div class="col-xl-4">
									<div class="submit-field required">
										<h5><?php echo $entry_current_password; ?></h5>
										<input type="password" class="form-control" id="input-current" name="current">
									</div>
								</div>
								<div class="col-xl-4">
									<div class="submit-field required">
										<h5><?php echo $entry_password; ?></h5>
										<input type="password" class="form-control" id="input-password" name="password">
										<?php echo formError('password'); ?>
									</div>
								</div>
								<div class="col-xl-4">
									<div class="submit-field required">
										<h5><?php echo $entry_confirm; ?></h5>
										<input type="password" class="form-control" id="input-confirm" name="confirm">
										<?php echo formError('confirm'); ?>
									</div>										
								</div>
								<div class="col-12">
									<button type="button" id="password-form-button" class="button ripple-effect big margin-top-30 float-right"><?php echo $button_submit; ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="col-12">
				<div class="shadow-sm p-3 mb-5 bg-white rounded">
					<div class="headline">
							<h3><i class="icon-material-outline-lock"></i> <?php echo $text_professional_heading; ?></h3>
							<small><?php echo $text_professional_sub; ?></small>
						</div>
					<div class="content with-padding">
						 <!-- Certificates BEGIN -->
						<div class="accordion" id="certificatesAccordion">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
									<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#certificates" aria-expanded="true" aria-controls="collapseOne"><i class="fas fa-certificate"></i> <?php echo $tab_certificates; ?></button>
								</h2>
                            </div>
                            <div class="card-body">
							<div id="certificates" class="collapse" aria-labelledby="headingOne" data-parent="#certificatesAccordion">
								<div class="accordion-body__contents">
									<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_token" />
									<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="input-name"><?php echo $entry_certification; ?></label>
											<input type="text" class="form-control" id="input-name" name="name" value=""
											placeholder="Certificate or Award">
											<small id="error_certificate_name" class="form-text text-muted"></small>
										</div>
										<div class="form-group col-md-6">
											<label for="input-certificate-year"><?php echo $entry_year; ?></label>
											<select id="certificate_year" class="form-control" name="certificate_year">
												<?php foreach (seller_graduation_year() as $year) { ?>
													<option value="<?php echo $year['id']; ?>">
														<?php echo $year['text']; ?></option>
													<?php } ?>
												</select>
												<span class="lnr lnr-chevron-down"></span>
												<small id="error_certificate_year" class="form-text text-muted"></small>
											</div>
											<div class="col-md-12">
												<button class="button ripple-effect float-right" id="add-certificate" data-loading-text="<?php echo $text_loading; ?>"
													type="button"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>  
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
								<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
									<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#education" aria-expanded="true" aria-controls="headingTwo"><i class="fas fa-university"></i> <?php echo $tab_education; ?></button>
								</h2>
                            </div>	
                            <div class="card-body">
								<div id="education" class="collapse" aria-labelledby="headingTwo" data-parent="#educationAccordion">
								<div class="accordion-body__contents">
									<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_token" />
									<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
									<div class="form-row">
										<div class="form-group col-md-6">
		                                <label for="filter_university"><?php echo $entry_university; ?></label>
		                                <input type="text" class="form-control" id="filter_university" name="filter_university" value="" placeholder="<?php echo $entry_university; ?>">
		                                <input name="university_id" type="hidden">
		                                <small class="form-text text-muted" id="error_filter_university"></small>
		                            </div>
		                             <div class="form-group col-md-4">
                                <label for="country"><?php echo $entry_country; ?></label>
                                <input type="text" class="form-control" id="education_country" name="education_country" value="">
                                 </div>
								<div class="form-group col-md-3">
                                <label for="major_title"><?php echo $entry_uni_title; ?></label>
                                    <select id="major_title" class="form-control" name="major_title">
                                        <option value=""><?php echo $text_select; ?></option>
                                        <?php foreach($education_titles as $title) { ?>
                                        <option value="<?php echo $title['value']; ?>">
                                            <?php echo $title['text']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="lnr lnr-chevron-down"></span>
                                <small class="form-text text-muted" id="error_major_title"></small>
                            </div>
                             <div class="form-group col-md-6">
                                <label for="filter_major"><?php echo $entry_major; ?></label>
                                <input name="major_id" type="hidden">
                                <input type="text" class="form-control" id="filter_major" name="filter_major" value="">
                                <small id="error_filter_major" class="form-text text-muted"></small>
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
												<button class="button ripple-effect float-right" id="add-education" data-loading-text="<?php echo $text_loading; ?>"
													type="button"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>  
												</div>
											</div> 

											<hr />         
											<div id="educations-list"></div>    
										</div>
                                    </div>
                                </div>
								</div>
			                <!-- Education EDD  -->
			                <div class="accordion" id="languageAccordion">
								<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
									<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#language" aria-expanded="true" aria-controls="headingTwo"><i class="fas fa-language"></i> <?php echo $tab_languages; ?></button>
								</h2>
							</div>	
							<div class="card-body">
			                <div id="language" class="collapse" aria-labelledby="headingTwo" data-parent="#languageAccordion">
								<div class="accordion-body__contents">
									<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_token" />
									<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
									<div class="form-row">
											<div class="form-group col-md-6">
												<label for="filter_language"><?php echo $entry_language; ?></label>
												<input type="hidden" name="language_id" value="">
												<input type="text" class="form-control" id="filter_language" name="filter_language"
												placeholder="<?php echo $text_add_language; ?>">
												<small id="error_filter_language" class="form-text text-muted"></small>
											</div>
											<div class="form-group col-md-6">
												<label for="language_level"><?php echo $entry_language_level; ?></label>
													<select id="language_level" class="form-control" name="language_level">
														<option value=""><?php echo $text_select; ?></option>
														<option value="1"><?php echo $text_basic; ?></option>
														<option value="2"><?php echo $text_conversational; ?>
													</option>
													<option value="3"><?php echo $text_fluent; ?></option>
													<option value="4"><?php echo $text_native_or_bilingual; ?></option>
												</select>
												<span class="lnr lnr-chevron-down"></span>
											<small id="error_language_level" class="form-text text-muted"></small>
										</div>
											<div class="col-md-12">
												<button class="button ripple-effect float-right" id="add-language" data-loading-text="<?php echo $text_loading; ?>"
													type="button"><i class="icon-material-outline-add"></i> <?php echo $button_add;?></button>  
												</div>
											</div> 

											<hr />         
											<div id="languages-list"></div>    
										</div>
									</div>
								</div>
								</div>
								<!-- Language EDD  -->
								<div class="accordion" id="skillsAccordion">
								<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
									<button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#skills" aria-expanded="true" aria-controls="headingTwo"><i class="fas fa-chalkboard-teacher"></i> <?php echo $tab_skill; ?></button>
								</h2>
							</div>
							<div class="card-body">
							<div id="skills" class="collapse" aria-labelledby="headingTwo" data-parent="#skillsAccordion">
								<div class="accordion-body__contents">
									<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="skills_csrf_token" />
									<input type="hidden" name="freelancer_id" value="<?php echo $customer_id; ?>" />
									<input type="hidden" name="category_id" value="" />
									<div class="form-row">
										<label for="input-filter_skill"><?php echo $entry_skill; ?></label>
										<div class="input-group mb-3">
											<input type="text" class="form-control" id="input-filter-skill" name="filter_category" placeholder="<?php echo $text_add_skill; ?>" value="">
											<div class="input-group-append">
												<button class="btn btn-primary" type="button" id="button-add-skill"><i class="icon-material-outline-add"></i></button>
											</div>
											
										</div>
										<small id="category_error" class="form-text text-muted"></small>
									</div>
									<hr />         
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
        type: 'post',
        dataType: 'json',
        data: $('#certificates input[name=\'name\'], #certificates select[name=\'certificate_year\'], #certificates #csrf_token, #certificates input[name=\'freelancer_id\']'),
        beforeSend: function() {
            $('#add-certificate').button('loading');
        },
        complete: function() {
            $('#add-certificate').button('reset');
        },
        success: function(json) {
            $('.alert').remove();
            $('.text-danger').remove();

            if (json['error']) {
                $('#certificates-card').before('<div class="alert alert-warning"><span class="alert_icon lnr lnr-warning"></span> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('#error_certificate_name').append('<span class="text-danger">' + json['error_name'] + '</span>');
                $('#error_certificate_year').append('<span class="text-danger">' + json['error_year'] + '</span>');
            }
            if (json['success']) {
                $('#certificates-list').load('account/setting/getCertificates');

                $('#certificates-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
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
    if (confirm('<?php echo $text_confirm; ?>')) {
        var node = this;
        $.ajax({
            url: 'account/setting/deleteCertificate?certificate_id=' + $(node).val(),
            method : 'POST',
            dataType: 'json',
            beforeSend: function() {
                $(node).button('loading');
            },
            complete: function() {
                $(node).button('reset');
            },
            success: function(json) {
                $('.alert').remove();
                $('.text-danger').remove();
                if (json['error']) {
                    $('#certificates-list').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#certificates-list').load('account/setting/getCertificates');
                    $('#certificates-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
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

$('#add-education').on('click', function(){
	 event.preventDefault();
    $.ajax({
        url: 'account/setting/addEducation',
        type: 'post',
        dataType: 'json',
        data: $('#educationAccordion input[name=\'education_country\'], #educationAccordion select[name=\'major_title\'], #educationAccordion input[name=\'major_id\'], #educationAccordion select[name=\'major_year\'], #educationAccordion input[type=\'hidden\']'),
        beforeSend: function() {
            $('#add-education').button('loading');
        },
        complete: function() {
            $('#add-education').button('reset');
        },
        success: function(json) {
            $('.alert').remove();
            $('.text-danger').remove();

            if (json['error']) {
                $('#educations-card').before('<div class="alert alert-warning"><span class="alert_icon lnr lnr-warning"></span> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('#error_filter_university').append('<span class="text-danger">' + json['error_university_name'] + '</span>');
                $('#error_major_title').append('<span class="text-danger">' + json['error_major_title'] + '</span>');
                $('#error_filter_major').append('<span class="text-danger">' + json['error_major_name'] + '</span>');
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
    if (confirm('<?php echo $text_confirm; ?>')) {
        var node = this;
        $.ajax({
            url: 'account/setting/deleteEducation?education_id=' + $(node).val(),
            dataType: 'json',
            beforeSend: function() {
                $(node).button('loading');
            },
            complete: function() {
                $(node).button('reset');
            },
            success: function(json) {
                $('.alert').remove();
                $('.text-danger').remove();

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
});
</script>
<!-- Education END -->
<!-- Languages Start -->
<script type="text/javascript">
$('input[name=\'filter_language\']').autocomplete({
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
        $('input[name=\'filter_language\']').val(ui.item.label);
        $('input[name=\'language_id\']').val(ui.item.value);
    }
});

$('#add-language').on('click', function(){
    $.ajax({
        url: 'account/setting/addLanguage',
        type: 'post',
        dataType: 'json',
        data: $('#languageAccordion select[name=\'language_level\'], #languageAccordion input[type=\'hidden\']'),
        beforeSend: function() {
            $('#add-language').button('loading');
        },
        complete: function() {
            $('#add-language').button('reset');
        },
        success: function(json) {
            $('.alert').remove();
            $('.text-danger').remove();

            if (json['error']) {
                $('#languages-card').before('<div class="alert alert-warning"><span class="alert_icon lnr lnr-warning"></span> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('#error_filter_language').append('<span class="text-danger">' + json['error_language_id'] + '</span>');
                $('#error_language_level').append('<span class="text-danger">' + json['error_language_level'] + '</span>');
            }

            if (json['success']) {
                $('#languages-list').load('account/setting/getLanguages');
                $('#languages-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
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
    if (confirm('<?php echo $text_confirm; ?>')) {
        var node = this;
        $.ajax({
            url: 'account/setting/deleteLanguage?language_id=' + $(node).val(),
            dataType: 'json',
            beforeSend: function() {
                $(node).button('loading');
            },
            complete: function() {
                $(node).button('reset');
            },
            success: function(json) {
                $('.alert').remove();

                if (json['error']) {
                    $('#languages-list').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#languages-list').load('account/setting/getLanguages');
                    $('#languages-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' +json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
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
$('#button-add-skill').on('click', function(){
	 event.preventDefault();
    $.ajax({
        url: 'account/setting/addSkill',
        type: 'post',
        dataType: 'json',
        data: $('#skillsAccordion input[type=\'hidden\']'),
        beforeSend: function() {
            $('#add-skill').button('loading');
        },
        complete: function() {
            $('#add-skill').button('reset');
        },
        success: function(json) {
            $('.alert').remove();
            $('.text-danger').remove();

            if (json['error']) {
                //$('#skills-list').before('<div class="alert alert-warning"><span class="alert_icon lnr lnr-warning"></span> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('#category_error').append('<span class="text-danger">' + json['error_category'] + '</span>');
            }

            if (json['success']) {
                $('#skills-list').load('account/setting/getSkills');
                $('#skills-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
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
    if (confirm('<?php echo $text_confirm; ?>')) {
        var node = this;
        $.ajax({
            url: 'account/setting/deleteSkill?category_id=' + $(node).val(),
            dataType: 'json',
            beforeSend: function() {
                $(node).button('loading');
            },
            complete: function() {
                $(node).button('reset');
            },
            success: function(json) {
                $('.alert').remove();
                $('.text-danger').remove();

                if (json['error']) {
                    $('#skills-list').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {
                    $('#skills-list').load('account/setting/GetSkills');
                    $('#skills-list').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
});
</script>
<link href="catalog/default/vendor/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="catalog/default/vendor/bootstrap-fileinput/themes/fas/theme.min.js"></script>
<script type="text/javascript">
$("#avatar-1").fileinput({
	uploadUrl: 'account/setting/avatarUpload',
    maxFileSize: 1500,
    showClose: false,
    showCaption: false,
    showUpload: false,
    showBrowse: false,
    theme: 'fas',
    browseOnZoneClick: true,
    fileActionSettings: {
       showZoom: false,
       showDrag: false,
       removeClass: 'd-none',
    },
    removeLabel: 'Remove',
    removeIcon: '<i class="far fa-window-close"></i>',
    removeClass: 'btn btn-danger',
    removeTitle: 'Cancel or reset changes',
    uploadExtraData: {
            '<?php echo csrf_token(); ?>': '<?php echo csrf_hash(); ?>', 
    },
    //showRemove: false,
    elErrorContainer: '#kv-avatar-errors',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="images/catalog/avatar.jpg" style="height:260px;"alt="Your Avatar"><h6 class="text-muted">Click to select</h6>',
    overwriteInitial: true,
    initialPreviewAsData: true,
    initialPreview: ['<?php echo base_url('images/catalog/' . $thumb); ?>'],
    allowedFileExtensions: ["jpg", "png", "gif"]
});
</script>
<!-- password change -->
<script type="text/javascript">
	$('#password-form-button').on('click', function (){
		var node = this;
		$.ajax({
			url: 'account/setting/passwordUpdate',
			method: 'post',
			dataType : 'json',
			data: $('#csrf_token, #password-form input[name=\'current\'], #password-form input[name=\'password\'], #password-form input[name=\'confirm\']'), 
			beforeSend: function() {
				$('.alert, .text-danger').remove();
				$(node).prop('disabled', true);
				$(node).html('<p id="loading-state"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</p>');
			},
			complete: function () {
				$(node).prop('disabled', false);
				$(node).html('Save Changes');
			},
			success: function (json) {
				// validation errors
				if (json['error_required']) {
					for(i in json['error_required']) {
						var el = $('#input-' + i.replace('_', '-'));
			            if (el) {
							el.after('<div class="text-danger">' + json['error_required'][i] + '</div>');
						} 
					}
				}

				if (json['error_password_form']) {
					$('#password-form .content').before('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ json['error_password_form'] +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				}

				if (json['success_password_form']) {
					$('#password-form .content').before('<div class="alert alert-success alert-dismissible fade show" role="alert">'+ json['success_password_form'] +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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