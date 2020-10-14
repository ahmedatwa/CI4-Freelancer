<?php echo $header; ?>
<div class="section gray padding-bottom-60 padding-top-60 full-width-carousel-fix">	
	<div class="container">
		<div class="row">
			<div class="col-xl-5 offset-xl-3">
				<div class="login-register-page shadow p-3 mb-5 bg-white rounded">
					<!-- Welcome Text -->
					<div class="welcome-text">
						<h3 style="font-size: 26px;"><?php echo $text_register; ?></h3>
						<span><?php echo $text_login; ?></span>
					</div>
					<!-- Form -->
					<form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">
						<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><i class="icon-material-baseline-mail-outline"></i></span>
								</div>
								<input type="text" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>"/>
							</div>
							<?php echo formError('email'); ?>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><i class="icon-material-outline-lock"></i></span>
								</div>
								<input type="password" class="form-control" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>"/>
							</div>
							<?php echo formError('password'); ?>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default"><i class="icon-material-outline-lock"></i></span>
								</div>
								<input type="password" class="form-control" name="confirm" id="input-password-confirm" placeholder="<?php echo $entry_confirm; ?>"/>
							</div>
							<?php echo formError('confirm'); ?>
						</div>
						<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit"><?php echo $button_register; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
					</form>
					<!-- Social Login -->
					<div class="social-login-separator"><span>or</span></div>
					<div class="social-login-buttons">
						<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register via Facebook</button>
						<button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Register via Google+</button>
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