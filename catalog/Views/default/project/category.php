<?php echo $header; ?> <?php echo $menu; ?>
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

		<div class="col-12">
			<div class="companies-list">
				<?php foreach ($categories as $category) { ?>
				<a href="<?php echo $category['href']; ?>" class="company">
					<div class="company-inner-alignment">
						<span class="company-logo"><i class="<?php echo $category['icon']; ?> fa-5x"></i></span>
						<h4><?php echo $category['name']; ?></h4>
						<small><?php echo $category['description']; ?></small>
					</div>
				</a>
			<?php } ?>
			</div>
		</div>
		<hr />
		<div class="col-12 margin-top-40 margin-bottom-25">
			<h3><?php echo $heading_title; ?></h3>
			<div class="row">
			 <?php foreach ($categories as $category) { ?>
			 	<?php if ($category['children']) { ?>
			 	<div class="col">	
			 	<div class="section-headline border-top margin-top-40 padding-top-45 margin-bottom-25">
				    <h4><?php echo $category['name']; ?></h4>
			   </div>
			   
					<ul class="list-1">
						<?php foreach ($category['children'] as $child) { ?>
						<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
						<?php } ?>
					</ul>
				</div>	
				<?php } ?>
		<?php } ?>
		</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>
