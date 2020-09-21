<?php echo $header; ?>
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $heading_title; ?></h2>
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>	
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>	
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>
<!-- Content-->
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12">
			<section id="contact" class="margin-bottom-60">
				<?php echo $description; ?>
			</section>

		</div>
	</div>
</div>
<!-- Container / End -->
<?php echo $footer; ?>