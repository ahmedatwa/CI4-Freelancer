<?php echo $header; ?><?php echo $menu; ?>
<div class="jumbotron">
	<div class="container-fluid">
		<h2 class="display-5"><?php echo $heading_title; ?></h2>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<nav id="breadcrumbs">
				<ul>
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</nav>
		</div>
	</div>
	<!-- Container -->
	<div class="section margin-top-30">
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<section id="contact" class="margin-bottom-60">
					<?php echo $description; ?>
				</section>

			</div>
		</div>
	</div>
</div>
<!-- Container / End -->
<?php echo $footer; ?>