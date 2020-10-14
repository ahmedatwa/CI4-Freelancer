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
				<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
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
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
					<button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
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
<?php echo $footer; ?>