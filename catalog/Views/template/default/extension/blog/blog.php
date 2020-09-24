<?php echo $header; ?>
<!-- Content -->
<div id="titlebar" class="white margin-bottom-30">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $heading_title; ?></h2>
				<span><?php echo $text_featured; ?></span>
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
<!-- Recent Blog Posts -->
<div class="section white padding-top-0 padding-bottom-60 full-width-carousel-fix">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="blog-carousel">
					<?php foreach ($featured as $value) { ?>
					<a href="<?php echo $value['href']; ?>" class="blog-compact-item-container">
						<div class="blog-compact-item">
							<img src="<?php echo $value['image']; ?>" alt="">
							<span class="blog-item-tag">Tips</span>
							<div class="blog-compact-item-content">
								<ul class="blog-post-tags">
									<li><?php echo $value['date_added']; ?></li>
								</ul>
								<h3><?php echo $value['title']; ?></h3>
								<p><?php echo $value['body']; ?></p>
							</div>
						</div>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Recent Blog Posts / End -->
<!-- Section -->
<div class="section gray">
	<div class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-8">
				<!-- Section Headline -->
				<div class="section-headline margin-top-60 margin-bottom-35">
					<h4><?php echo $text_recent; ?></h4>
				</div>
				<!-- Blog Post -->
				<?php foreach ($posts as $post) { ?>
				<a href="<?php echo $post['href']; ?>" class="blog-post">
					<!-- Blog Post Thumbnail -->
					<div class="blog-post-thumbnail">
						<div class="blog-post-thumbnail-inner">
							<!-- <span class="blog-item-tag">Tips</span> -->
							<img src="<?php echo $post['image']; ?>" alt="">
						</div>
					</div>
					<!-- Blog Post Content -->
					<div class="blog-post-content">
						<span class="blog-post-date"><?php echo $post['date_added']; ?></span>
						<h3><?php echo $post['title']; ?></h3>
						<p><?php echo $post['body']; ?></p>
					</div>
					<!-- Icon -->
					<div class="entry-icon"></div>
				</a>
				<?php } ?>
				<!-- Pagination -->
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12">
						<!-- Pagination -->
						<div class="pagination-container margin-top-10 margin-bottom-20">
							<nav class="pagination">
								<ul>
									<li><a href="#" class="current-page ripple-effect">1</a></li>
									<li><a href="#" class="ripple-effect">2</a></li>
									<li><a href="#" class="ripple-effect">3</a></li>
									<li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<!-- Pagination / End -->
			</div>
			<div class="col-xl-4 col-lg-4 content-left-offset">
				<div class="sidebar-container margin-top-65">
					<!-- Location -->
					<div class="sidebar-widget margin-bottom-40">
						<div class="input-with-icon">
							<input id="autocomplete-input" type="text" placeholder="Search">
							<i class="icon-material-outline-search"></i>
						</div>
					</div>
					<!-- Widget -->
					<div class="sidebar-widget">
						<h3><?php echo $text_trending; ?></h3>
						<ul class="widget-tabs">
							<!-- Post #3 -->
							<?php foreach ($trending as $value) { ?>
							<li>
								<a href="<?php echo $value['href']; ?>" class="widget-content">
									<img src="<?php echo $value['image']; ?>" alt="">
									<div class="widget-text">
										<h5><?php echo $value['title']; ?></h5>
										<span><?php echo $value['date_added']; ?></span>
									</div>
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
					<!-- Widget / End-->
					<!-- Widget -->
					<div class="sidebar-widget">
						<h3><?php echo $text_social; ?></h3>
						<div class="freelancer-socials margin-top-25">
							<ul>
								<li><a href="#" title="Dribbble" data-tippy-placement="top"><i class="icon-brand-dribbble"></i></a></li>
								<li><a href="#" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
								<li><a href="#" title="Behance" data-tippy-placement="top"><i class="icon-brand-behance"></i></a></li>
								<li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li>
							</ul>
						</div>
					</div>
					<!-- Widget -->
					<!-- <div class="sidebar-widget">
						<h3>Tags</h3>
						<div class="task-tags">
							<a href="#"><span>employer</span></a>
							<a href="#"><span>recruiting</span></a>
							<a href="#"><span>work</span></a>
							<a href="#"><span>salary</span></a>
							<a href="#"><span>tips</span></a>
							<a href="#"><span>income</span></a>
							<a href="#"><span>application</span></a>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<!-- Spacer -->
	<div class="padding-top-40"></div>
	<!-- Spacer -->
</div>
<!-- Section / End -->
<?php echo $footer; ?>