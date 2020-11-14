<!-- Features Jobs -->
<div class="section gray padding-top-20 padding-bottom-75">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-35">
					<h3><?php echo $heading_title; ?></h3>
					<a href="<?php echo $projects_all; ?>" class="headline-link"><?php echo $text_browse; ?></a>
				</div>
				<!-- Jobs Container -->
				<div class="listings-container compact-list-layout margin-top-35">
					<?php foreach ($featured as $f) { ?>
					<!-- Job Listing -->
					<a href="<?php echo $f['href']; ?>" class="job-listing with-apply-button">
						<!-- Job Listing Details -->
						<div class="job-listing-details">
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