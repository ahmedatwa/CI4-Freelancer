<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 data-target="#collapse_1"><?php echo $text_quick_links; ?></h3>
					<div class="collapse dont-collapse-sm links" id="collapse_1">
						<ul>
						<li><a href="<?php echo $blog; ?>"><?php echo $text_blog; ?></a></li>	
						<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>	
						<?php if ($informations) { ?>
						<?php foreach ($informations as $information) { ?>
							<li><a href="<?php echo $information['href']; ?>"><?php echo $information['name']; ?></a></li>
						<?php } ?>
						<?php } ?>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-target="#collapse_2"><?php echo $text_categories; ?></h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
					<?php if ($categories) { ?>
						<ul>
						<?php foreach ($categories as $category) { ?>
							<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
						<?php } ?>	
						</ul>
						<?php } ?>	
					</div>
				</div>
				<div class="col-lg-3 offset-lg-3 col-md-6">
					<h3 data-target="#collapse_4"><?php echo $text_in_touch; ?></h3>
					<div class="collapse dont-collapse-sm" id="collapse_4">
						<div id="newsletter">
							<div id="message-newsletter"></div>
							<form method="post" action="assets/newsletter.php" name="newsletter_form" id="newsletter_form">
								<div class="form-group">
									<input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="<?php echo $text_email; ?>">
									<button type="submit" id="submit-newsletter"><i class="arrow_carrot-right"></i></button>
								</div>
							</form>
						</div>
						<div class="follow_us">
							<ul>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/twitter_icon.svg" alt="" class="lazy"></a></li>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/facebook_icon.svg" alt="" class="lazy"></a></li>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/instagram_icon.svg" alt="" class="lazy"></a></li>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/youtube_icon.svg" alt="" class="lazy"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- /row-->
			<hr>
			<div class="row add_bottom_25">
				<div class="col-lg-6">
					<ul class="footer-selector clearfix">
						<li>
							<div class="styled-select lang-selector">
								<select>
									<option value="English" selected>English</option>
									<option value="French">French</option>
									<option value="Spanish">Spanish</option>
									<option value="Russian">Russian</option>
								</select>
							</div>
						</li>
						<li>
							<div class="styled-select currency-selector">
								<select>
									<option value="US Dollars" selected>US Dollars</option>
									<option value="Euro">Euro</option>
								</select>
							</div>
						</li>
						<li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/cards_all.svg" alt="" width="230" height="35" class="lazy"></li>
					</ul>
				</div>
				<div class="col-lg-6">
					<ul class="additional_links">
						<li><span><?php echo $text_footer; ?></span></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!--/footer-->
	<div id="toTop"></div><!-- Back to top button -->
	<div class="layer"></div><!-- Opacity Mask Menu Mobile -->
	<!-- Sign In Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="login"><?php echo $text_login; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="login-body">
		<form enctype="multipart/form-data" id="form-login">
		<?= csrf_meta() ?>
		<?= csrf_field() ?>
				<a href="#0" class="social_bt facebook"><?php echo $text_facebook; ?></a>
				<a href="#0" class="social_bt google"><?php echo $text_google; ?></a>
				<div class="divider"><span>Or</span></div>
				<div class="form-group">
				 <label><?php echo $entry_email; ?></label>
					<input type="email" class="form-control" name="email" id="input-login-email">
				</div>
				<div class="form-group">
					<label><?php echo $entry_password; ?></label>
					<input type="password" class="form-control" name="password" id="input-login-password">
				</div>
				<div class="clearfix add_bottom_15">
					<div class="float-right mt-1"><a id="forgot" href="javascript:void(0);"><?php echo $text_forgotton; ?></a></div>
				</div>
				<div class="text-center">
					<button type="button" class="btn_1 full-width mb_5" id="login-button" data-loading-text="Loading..."><?php echo $button_login; ?> <i class="fas fa-sign-in-alt"></i></button> 
				</div>
			</div>
			<!--form -->
			</div>
  			</div>
		</div>
<!-- /Register In Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="register"><?php echo $text_register; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="register-body">
		<form enctype="multipart/form-data" id="form-register">
		<?= csrf_meta() ?>
		<?= csrf_field() ?>
			<div class="form-group">
					<label><?php echo $entry_email; ?></label>
					<input type="email" class="form-control" name="email" id="input-register-email">
				</div>
				<div class="form-group">
					<label><?php echo $entry_password; ?></label>
					<input type="password" class="form-control" name="password" id="input-register-password">
				</div>
				<div class="form-group">
					<label><?php echo $entry_confirm; ?></label>
					<input type="password" class="form-control" name="confirm" id="input-register-confirm">
				</div>
				<div class="text-center">
					<button type="button" class="btn_1 full-width mb_5" id="register-button" data-loading-text="Loading..."><?php echo $button_register; ?> <i class="fas fa-sign-in-alt"></i></button>
				</div>
				</form>
			</div>
		<!--form -->
		</div>
  </div>
</div>
<!-- COMMON SCRIPTS -->
<script src="catalog/default/js/common_scripts.min.js"></script>
<script src="catalog/default/js/common_func.js"></script>
<!-- SPECIFIC SCRIPTS -->
<script src="catalog/default/js/modernizr.min.js"></script>
<script src="catalog/default/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="catalog/default/vendor/bootstrap-4.5.0/js/bootstrap.min.js"></script>	
    <!-- SPECIFIC SCRIPTS -->
	<script src="catalog/default/js/jquery.cookiebar.js"></script>
	<script>
		$(document).ready(function() {
			'use strict';
			$.cookieBar({
				fixed: true
			});
		});
	</script>

</body>
</html>