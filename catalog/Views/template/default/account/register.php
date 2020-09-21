<?php echo $header; ?>
<!-- Titlebar -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $heading_title; ?></h2>
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<?php foreach ($breadcrumbs as $breadcrumb) { ?>
							<li><a href="<?php echo $breadcrumb['href']; ?>"></a><?php echo $breadcrumb['text']; ?></a></li>
						<?php } ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-xl-5 offset-xl-3">
			<div class="login-register-page">
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3 style="font-size: 26px;"><?php echo $text_register; ?></h3>
					<span><?php echo $text_login; ?></span>
				</div>
				<!-- Account Type -->
				<div class="account-type">
					<?php if ($success) { ?>
						<div class="notification success closeable">
							<p><?php echo $success; ?></p>
							<a class="close" href="#"></a>
						</div>
					<?php } ?>
					<?php if ($error_warning) { ?>
						<div class="notification error closeable">
							<p><?php echo $error_warning; ?></p>
							<a class="close" href="#"></a>
						</div>
					<?php } ?>
				</div>	
				<!-- Form -->
				<form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="input-with-icon-left" title="Valid E-Mail Address" data-tippy-placement="bottom">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>"/>
						<?php echo formError('email'); ?>
					</div>
					<div class="input-with-icon-left" title="Should be at least 4 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>"/>
						<?php echo formError('password'); ?>
					</div>
					<div class="input-with-icon-left" title="Should be at least 4 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="confirm" id="input-password-confirm" placeholder="<?php echo $entry_confirm; ?>"/>
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
<!-- Spacer -->
<div class="margin-top-70"></div>
<!-- Spacer / End-->
<?php echo $footer; ?>