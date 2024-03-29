<?php echo $header; ?>
<div class="section gray padding-bottom-60 padding-top-60 full-width-carousel-fix">	
	<div class="container">
		<div class="row">
			<div class="col-xl-5 offset-xl-3">
				<div class="login-register-page shadow p-3 mb-5 bg-white rounded" id="register-wrapper">
					<div class="welcome-text">
						<h3 style="font-size: 26px;"><?php echo $text_register; ?></h3>
						<span><?php echo $text_login; ?></span>
					</div>
					<form enctype="multipart/form-data" accept-charset="utf-8" id="form-register">
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><i class="icon-material-baseline-mail-outline"></i></span>
								</div>
								<input type="text" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><i class="icon-material-outline-lock"></i></span>
								</div>
								<input type="password" class="form-control" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><i class="icon-material-outline-lock"></i></span>
								</div>
								<input type="password" class="form-control" name="confirm" id="input-confirm" placeholder="<?php echo $entry_confirm; ?>"/>
							</div>
						</div>
						<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="button" id=button-form-register><?php echo $button_register; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
					</form>
					<!-- Social Login -->
					<div class="social-login-separator"><span>or</span></div>
					<div class="social-login-buttons d-flex justify-content-center">
					<div id="my-signin2" class="mt-auto my-auto"></div></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Register -->
<script type="text/javascript">
$('#button-form-register').on('click', function() {
	$.ajax({
		url: 'account/register/create',
		headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/x-www-form-urlencoded',
        },
		type: 'post',
		dataType: 'json',
		data: $('#form-register').serialize(),
		beforeSend: function() {
		   $('#register-wrapper').removeClass('animate__animated animate__shakeX');
		   $('.form-group input').removeClass('is-invalid');
		   $('.alert, .invalid-feedback').remove();
		},
		success: function(json) {

		    if (json['errors']) {
			    for ( i in json['errors']) {
			    	$('#input-' + i).after('<div class="invalid-feedback">' + json['errors'][i] + '</div>');
			    	$('#input-' + i).addClass('is-invalid');
		        }
		    	$('.welcome-text').before('<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+ json['error_warning']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		        $('#register-wrapper').addClass('animate__animated animate__shakeX');
		    }

		    if (json['error_attempts']) {
                 $('.welcome-text').before('<div class="alert alert-danger fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+ json['error_attempts']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		    }

		    if (json['redirect']) {
				$('#register-wrapper').html('<h2 class="text-center"><i class="fas fa-thumbs-up text-danger"></i> Register Success</h2><p class="text-center">Please wait we will redirect you.</p><div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
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
<!-- Google Sign in -->
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script>
function onSuccess(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  var client_id = $('meta[name=\'google-signin-client_id\']').attr('content');
  $.ajax({
  	url: 'account/login/googleAuth',
  	headers: {
        'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    method: 'post',
  	dataType: 'json',
  	data: {'client_id': client_id, 'id_token': id_token},
  	beforeSend: function() {
  		$('#overlay').fadeIn().delay(2000);
  	},
  	complete: function() {
  		$('#overlay').fadeOut();
  	},
  	success: function(json) {
  		if (json['redirect']) {
  			location = json['redirect'];
  		}
  		if (json['error']) {
  			alert(json['error']);
  		}
  	}

  });
}

function onFailure(error) {}
function renderButton() {
  gapi.signin2.render('my-signin2', {
    'scope': 'profile email',
    'width': 270,
    'height': 50,
    'longtitle': true,
    'theme': 'dark',
    'onsuccess': onSuccess,
    'onfailure': onFailure
  });
}
</script>
<?php echo $footer; ?>