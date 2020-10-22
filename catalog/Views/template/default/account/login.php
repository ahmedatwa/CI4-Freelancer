<?php echo $header; ?>
<div class="section gray padding-bottom-60 padding-top-60 full-width-carousel-fix">	
<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-xl-5 offset-xl-3">
			<div class="login-register-page shadow p-3 mb-5 bg-white rounded">
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3><?php echo $text_login; ?></h3>
					<span><?php echo $text_register; ?></span>
				</div>
				
				<!-- Form -->
				<form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">
				<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="X-CSRF-TOKEN" />
				 <div class="form-group">
					<div class="input-group is-invalid">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="icon-material-baseline-mail-outline"></i></span>
					  </div>
						<input type="text" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>"/>
					</div>
					<?php echo formError('email'); ?>
				</div>
				<div class="form-group">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="icon-material-outline-lock"></i></span>
					  </div>
						<input type="password" class="form-control" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>"/>
					</div>
					<?php echo formError('password'); ?>
				</div>
					<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit"><?php echo $button_login; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>
				<p class="mt-3">
				<a href="<?php echo $forgotton; ?>" class="forgot-password text-secondary"><?php echo $text_forgotten; ?></a>
			    </p>

				<!-- Social Login -->
				<div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons align-content-center">
					<div id="my-signin2" class="mt-auto"></div>
					
<!-- 					<a id="linkedin-button" class="btn btn-block btn-primary mt-3">
						  <i class="fab fa-linkedin"></i> Sign in with Linkedin
					</a>
 -->				</div>
			</div>

		</div>
	</div>
</div>
</div>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script>
function onSuccess(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  var client_id = $('meta[name=\'google-signin-client_id\']').attr('content');
  $.ajax({
  	url: 'account/login/googleAuth?client_id=' + client_id + '&id_token=' + id_token,
  	contentType: 'application/x-www-form-urlencoded',
  	beforeSend: function() {
  		$('#overlay').fadeIn().delay(2000);
  	},
  	complete: function() {
  		$('#overlay').fadeOut();
  	},
  	dataType: 'json',
  	success: function(json) {
  		if (json['redirect']) {
  			location = json['redirect'];
  		}
  	}

  });
}

function onFailure(error) {
}
function renderButton() {
  gapi.signin2.render('my-signin2', {
    'scope': 'profile email',
    'width': 300,
    'height': 50,
    'longtitle': true,
    'theme': 'dark',
    'onsuccess': onSuccess,
    //'onfailure': onFailure
  });
}
</script>
<!-- linked in  -->
<script type="text/javascript">
	$('#linkedin-button').on('click', function() {
  // Initialize with your OAuth.io app public key
  OAuth.initialize('YOUR_OAUTH_KEY');
  // Use popup for oauth
  OAuth.popup('linkedin2').then(linkedin => {
    console.log('linkedin:',linkedin);
    // Prompts 'welcome' message with User's email on successful login
    // #me() is a convenient method to retrieve user data without requiring you
    // to know which OAuth provider url to call
    linkedin.me().then(data => {
      console.log('me data:', data);
      alert('Linkedin says your email is:' + data.email + ".\nView browser 'Console Log' for more details");
    })
    // Retrieves user data from OAuth provider by using #get() and
    // OAuth provider url
    linkedin.get('/v2/me').then(data => {
      console.log('self data:', data);
    })
  });
})
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
	icon: 'fas fa-exclamation-circle',
	title: 'Success:',
	message: "<?php echo $success; ?>",
},{
	// settings
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