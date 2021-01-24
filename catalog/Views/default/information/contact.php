<?php echo $header;?>
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $heading_title; ?></h2>
			</div>
		</div>
	</div>
</div>
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-xl-12">
			<div class="contact-location-info margin-bottom-50">
				<div class="contact-address">
					<ul>
						<li class="contact-address-headline">Our Office</li>
						<li><?php echo $address; ?></li>
						<li><?php echo $telephone; ?></li>
					</ul>
				</div>
				<div id="single-job-map-container">
					<div id="singleListingMap" data-latitude="37.777842" data-longitude="-122.391805" data-map-icon="im im-icon-Hamburger"></div>
				</div>
			</div>
		</div>
		<div class="col">
			<section class="margin-bottom-60">
				<h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us! <br />
				<small><?php echo $text_help; ?></small></h3>
				<form enctype="multipart/form-data" id="form-contact-us" accept-charset="utf-8"> 
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-account-circle"></i></span>
								</div>
								<input class="form-control" name="name" type="text" id="input-name" />
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Email Address</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-email"></i></span>
								</div>
								<input class="form-control" name="email" type="email" id="input-email" />

							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Subject</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-assignment"></i></span>
								</div>
								<input class="form-control" name="subject" type="text" id="input-subject" />
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="inquiry" cols="40" rows="7" spellcheck="true" id="input-inquiry"></textarea>
						</div>
					</div>
					<div class="mx-auto text-right">
					<button type="button" class="submit button margin-top-15" id="button-contact-us">Send Message</button>
				</div>
				</form>
			</section>
		</div>
	</div>
</div>
<!-- Google API & Maps -->
<!-- Geting an API Key: https://developers.google.com/maps/documentation/javascript/get-api-key -->
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"></script>
<script src="catalog/default/javascript/infobox.min.js"></script>
<script src="catalog/default/javascript/markerclusterer.js"></script>
<script src="catalog/default/javascript/maps.js"></script>
<?php echo $footer;?>
<script type="text/javascript">
	$('#button-contact-us').on('click', function() {
		var node = this;
		$.ajax({
			url: 'information/contact/send',
			headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
              "X-Requested-With": "XMLHttpRequest"
           },
		   dataType: 'json',
		   method: 'post',
		   data:$("#form-contact-us").serialize(),
		   beforeSend: function() {
		   	$('.alert, .invalid-feedback').remove();
		   	$('form-contact-us input').removeClass('is-invalid');
		   	$(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
		   },
		   complete: function() {
			$(node).html('Send Message');
		   },
		   success: function(json) {
		   	if (json['errors']) {
		   		for (i in json['errors']) {
		   			var ele = $('#input-' + i );
		   			ele.addClass('is-invalid');
		   			ele.after('<div class="invalid-feedback">' + json['errors'][i] + '</div>');
		   		}
		   		// $('#form-contact-us').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' +json['error_warning'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		   	}

		   	if (json['success']) {
		   		$('#form-contact-us').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
		   	}
		   },
		   error: function(xhr, ajaxOptions, thrownError) {
		      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		   }
		});
	});
</script>
