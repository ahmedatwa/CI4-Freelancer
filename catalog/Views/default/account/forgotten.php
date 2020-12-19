<?php echo $header; ?>
<div class="section gray padding-bottom-60 padding-top-60 full-width-carousel-fix">	
<div class="container">
	<div class="row">
		<div class="col-xl-5 offset-xl-3">
			<div class="login-register-page shadow p-3 mb-5 bg-white rounded">
				<div class="welcome-text">
					<h3><?php echo $heading_title; ?></h3>
				</div>
				<form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">
				<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
				 <div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="icon-material-baseline-mail-outline"></i></span>
					  </div>
						<input type="text" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>"/>
					</div>
					<?php echo formError('email'); ?>
				</div>
					<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit"><?php echo $button_reset; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>
				<p class="mt-3">
				<a href="<?php echo $login; ?>" class="forgot-password text-secondary"><?php echo $text_login; ?></a>
			    </p>
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