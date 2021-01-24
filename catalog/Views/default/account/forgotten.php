<?php echo $header; ?>
<div class="section gray padding-bottom-60 padding-top-60 full-width-carousel-fix">	
<div class="container">
	<div class="row">
		<div class="col-xl-5 offset-xl-3">
			<div class="login-register-page shadow p-3 mb-5 bg-white rounded" id="forgot-wrapper">
				<div class="welcome-text">
					<h3><?php echo $heading_title; ?></h3>
				</div>
				<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8" id="form-forgot">
				 <div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="icon-material-baseline-mail-outline"></i></span>
					  </div>
						<input type="text" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>"/>
					</div>
				</div>
					<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="button" id="button-form-forgotten"><?php echo $button_reset; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>
				<p class="mt-3">
				<a href="<?php echo $login; ?>" class="forgot-password text-secondary"><i class="fas fa-sign-in-alt"></i> <?php echo $text_login; ?></a>
			    </p>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$('#button-form-forgotten').on('click', function() {
	$.ajax({
		url: 'account/forgotten/forgotten',
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/x-www-form-urlencoded',
        },
		type: 'post',
		dataType: 'json',
		data: $('#form-forgot').serialize(),
		beforeSend: function() {
		   $('#forgot-wrapper').removeClass('animate__animated animate__shakeX');
		   $('.form-group input').removeClass('is-invalid');
		   $('.alert, .invalid-feedback').remove();
		},
		success: function(json) {

		    if (json['error']) {
		    	if (json['error'].email) {
				    $('#input-email').after('<div class="invalid-feedback">' + json['error'].email + '</div>');
				    $('#input-email').addClass('is-invalid');
				    $('#forgot-wrapper').addClass('animate__animated animate__shakeX');
		     	}

		     	if (json['error'].not_found) {
                    $('.welcome-text').before('<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+ json['error'].not_found+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                 	$('#forgot-wrapper').addClass('animate__animated animate__shakeX');
		     	}
		    }

		    if (json['redirect']) {
				$('#forgot-wrapper').html('<h2 class="text-center"><i class="fas fa-thumbs-up text-danger"></i> Success! '+json['success']+'</h2><p class="text-center">Please wait we will redirect you to login.</p><div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
				setTimeout(function() {
					location = json['redirect'];
			    }, 2000); 
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
         }
	});
});
</script>
<?php echo $footer; ?>