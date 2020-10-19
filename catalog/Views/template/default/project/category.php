<?php echo $header; ?> 
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
</div>
<!-- Page Content -->
<div class="container">
	<div class="row">

		<div class="col-xl-12">
			<div class="companies-list">
				<?php foreach ($categories as $category) { ?>
				<a href="<?php echo $category['href']; ?>" class="company">
					<div class="company-inner-alignment">
						<span class="company-logo"><img src="images/company-logo-placeholder.png" alt=""></span>
						<h4><?php echo $category['name']; ?></h4>
						<small><?php echo $category['description']; ?></small>
					</div>
				</a>
			<?php } ?>

			</div>
		</div>
	</div>
</div>

<?php echo $footer; ?>
