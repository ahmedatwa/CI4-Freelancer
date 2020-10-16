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
				<h2><?php echo $text_404; ?> <i class="icon-line-awesome-question-circle"></i></h2>
				<p><?php echo $text_sorry; ?></p>
			</section>

			<div class="row">
				<div class="col-xl-8 offset-xl-2">
						<div class="intro-banner-search-form not-found-search margin-bottom-50">
							<!-- Search Field -->
							<div class="intro-search-field ">
								<input id="intro-keywords" type="text" placeholder="What Are You Looking For?">
							</div>

							<!-- Button -->
							<div class="intro-search-button">
								<button class="button ripple-effect">Search</button>
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