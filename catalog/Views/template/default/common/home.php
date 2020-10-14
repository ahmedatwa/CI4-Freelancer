<?php echo $header; ?>
<!-- Intro Banner-->
<!-- add class "disable-gradient" to enable consistent background overlay -->
<div class="intro-banner dark-overlay big-padding">
	
	<!-- Transparent Header Spacer -->
	<div class="transparent-header-spacer"></div>

	<div class="container">
		
		<!-- Intro Headline -->
		<div class="row">
			<div class="col-md-12">
				<div class="banner-headline-alt">
					<h3>Don't Just Dream, Do</h3>
					<span>Find the best jobs in the digital industry</span>
				</div>
			</div>
		</div>
		
		<!-- Search Bar -->
		<div class="row">
			<div class="col-md-12">
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

		<!-- Stats -->
		<div class="row">
			<div class="col-md-12">
				<ul class="intro-stats margin-top-45 hide-under-992px">
					<li>
						<strong class="counter">1,586</strong>
						<span>Jobs Posted</span>
					</li>
					<li>
						<strong class="counter">3,543</strong>
						<span>Tasks Posted</span>
					</li>
					<li>
						<strong class="counter">1,232</strong>
						<span>Freelancers</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- Video Container -->
	<div class="video-container" data-background-image="catalog/default/video/intro.png">
		<video loop autoplay muted>
			<source src="catalog/default/video/intro.mp4" type="video/mp4">
			<source src="catalog/default/video/intro.webm" type="video/webm">
			<source src="catalog/default/video/intro.ogv" type="video/ogv">
		</video>
	</div>

</div>
<!-- Content -->



<!-- Features Jobs -->
<div class="section gray margin-top-30 padding-top-20 padding-bottom-75">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-35">
					<h3><?php echo $text_featured; ?></h3>
					<a href="<?php echo $projects_all; ?>" class="headline-link"><?php echo $text_browse; ?></a>
				</div>
				<!-- Jobs Container -->
				<div class="listings-container compact-list-layout margin-top-35">
					<?php foreach ($featured as $f) { ?>
					<!-- Job Listing -->
					<a href="<?php echo $f['href']; ?>" class="job-listing with-apply-button">
						<!-- Job Listing Details -->
						<div class="job-listing-details">
							<!-- Logo -->
							<div class="job-listing-company-logo">
								<img src="images/company-logo-01.png" alt="">
							</div>
							<!-- Details -->
							<div class="job-listing-description">
								<h3 class="job-listing-title"><?php echo $f['name']; ?></h3>

								<!-- Job Listing Footer -->
								<div class="job-listing-footer">
									<ul>
										<!-- <li><i class="icon-material-outline-location-on"></i> San Francissco</li>-->										
										<li><i class="icon-material-outline-business-center"></i> <?php echo $f['type']; ?></li>
										<li><i class="icon-material-outline-access-time"></i> <?php echo $f['date_added']; ?></li>
									</ul>
								</div>
							</div>
							<!-- Apply Button -->
							<span class="list-apply-button ripple-effect"><?php echo $text_apply; ?></span>
						</div>
					</a>
					<?php } ?>	
				</div>
				<!-- Jobs Container / End -->
			</div>
		</div>
	</div>
</div>
<!-- Featured Jobs / End -->
<!-- Icon Boxes -->
<div class="section padding-top-65 padding-bottom-65">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline centered margin-top-0 margin-bottom-5">
					<h3>How It Works?</h3>
				</div>
			</div>
			
			<div class="col-xl-4 col-md-4">
				<!-- Icon Box -->
				<div class="icon-box with-line">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-lock"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Create an Account</h3>
					<p>Bring to the table win-win survival strategies to ensure proactive domination going forward.</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<!-- Icon Box -->
				<div class="icon-box with-line">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-legal"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Post a Task</h3>
					<p>Efficiently unleash cross-media information without. Quickly maximize return on investment.</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<!-- Icon Box -->
				<div class="icon-box">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class=" icon-line-awesome-trophy"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Choose an Expert</h3>
					<p>Nanotechnology immersion along the information highway will close the loop on focusing solely.</p>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Icon Boxes / End -->
<!-- Highest Rated Freelancers -->
<div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-25">
					<h3><?php echo $text_freelancers; ?></h3>
					<a href="<?php echo $freelancers_all; ?>" class="headline-link"><?php echo $text_all_freelancers; ?></a>
				</div>
			</div>

			<div class="col-xl-12">
				<div class="default-slick-carousel freelancers-container freelancers-grid-layout">
					<?php foreach ($freelancers as $freelancer) { ?>
					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
							<div class="freelancer-overview-inner">
								
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<div class="verified-badge"></div>
									<a href="<?php echo $freelancer['href']; ?>"><img src="<?php echo $freelancer['image']; ?>" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="<?php echo $freelancer['href']; ?>"><?php echo $freelancer['name']; ?> </a></h4>
									<span><?php echo $freelancer['tag_line']; ?></span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
								<div class="rating">
									<ul>
										<?php for ($i=1; $i <= 5; $i++) { ?>
											<?php if ($freelancer['rating'] < $i) { ?>
												<li><span class="fa-stack"><i class="far fa-star fa-stack-1x"></i></span></li>
											<?php } else { ?>
												<li><span class="fa-stack">
													<i class="fas fa-star fa-stack-1x"></i></span></li>
												<?php } ?>
											<?php } ?>
										</ul>
								</div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<!-- <li>Location <strong><i class="icon-material-outline-location-on"></i> London</strong></li> -->
									<li>Rate <strong><?php echo $freelancer['rate']; ?> / hr</strong></li>
									<li>Job Success <strong>95%</strong></li>
								</ul>
							</div>
							<a href="<?php echo $freelancer['href']; ?>" class="button button-sliding-icon ripple-effect"><?php echo $text_view_profile;?> <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->
				<?php } ?>

	


				</div>
			</div>

		</div>
	</div>
</div>
<!-- Highest Rated Freelancers / End-->
<!-- Photo Section -->
<div class="photo-section" data-background-image="images/section-background.jpg">

	<!-- Infobox -->
	<div class="text-content white-font">
		<div class="container">

			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12">
					<h2>Hire experts or be hired. <br> For any job, any time.</h2>
					<p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation is on the runway towards.</p>
					<a href="<?php echo $register; ?>" class="button button-sliding-icon ripple-effect big margin-top-20">Get Started <i class="icon-material-outline-arrow-right-alt"></i></a>
				</div>
			</div>

		</div>
	</div>

	<!-- Infobox / End -->

</div>
<!-- Photo Section / End -->
<?php echo $footer; ?>