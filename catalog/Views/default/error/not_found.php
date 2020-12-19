<?php echo $header; ?>
<!-- Titlebar -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
		</div>
	</div>
</div>
<!-- Page Content-->
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-xl-12">

			<section id="not-found" class="center margin-top-50 margin-bottom-25">
				<h2><?php echo $text_404; ?> <i class="far fa-question-circle fa-4x"></i></h2>
				<p><?php echo $text_sorry; ?></p>
			</section>

			<div class="row">
				<div class="col-xl-8 offset-xl-2">
					<div class="intro-banner-search-form margin-top-95" id="search-container">
					<!-- Search Field -->
					<div class="intro-search-field">
						<div class="input-group input-group-lg">
						  <input type="text" class="form-control" placeholder="What job you want?">
						  <div class="input-group-append">
						    <button class="button ripple-effect" type="button" id="button-addon2">Search</button>
						  </div>
						</div>
					</div>
				</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Container / End -->
<!-- Spacer -->
<div class="margin-top-70"></div>
<!-- Spacer / End-->
<?php echo $footer; ?>