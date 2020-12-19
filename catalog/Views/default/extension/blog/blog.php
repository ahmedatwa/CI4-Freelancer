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
<!-- Recent Blog Posts -->
<div class="section mb-5 bg-white margin-top-30">		
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
<!-- Recent Blog Posts / End -->
<!-- Section -->
<div class="section mb-5 bg-white margin-top-30">		
		<div class="row">
			<div class="col-sm-12 col-md-9 mb-4">
				<!-- Section Headline -->
				<div class="section-headline margin-top-20 margin-bottom-35">
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
				<?php echo $pagination; ?>
				<!-- Pagination / End -->
			</div>
			<div class="col">
				<div class="sidebar-container margin-top-39">
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
	<!-- Spacer -->
	<div class="padding-top-40"></div>
	<!-- Spacer -->
</div>
</div>
<!-- Section / End -->
<?php echo $footer; ?>