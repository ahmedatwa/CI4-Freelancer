<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40">
<div class="dashboard-content-inner" >
	<!-- Dashboard Headline -->
	<div class="dashboard-headline">
		<h3><?php echo $heading_title; ?></h3>
		<!-- Breadcrumbs -->
		<nav id="breadcrumbs" class="dark">
			<ul>
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</nav>
	</div>
	<!-- Row -->
	<div class="row">
		<!-- Dashboard Box -->
		<div class="col-xl-12">
			<div class="dashboard-box margin-top-0">
				<!-- Headline -->
				<div class="headline">
					<h3><i class="icon-material-outline-assignment"></i> <?php echo $text_projects; ?></h3>
				</div>
				<div class="content">
					<ul class="dashboard-box-list">
						<?php foreach ($projects as $project) { ?>
							<li>
								<!-- Job Listing -->
								<div class="job-listing width-adjustment">
									<!-- Job Listing Details -->
									<div class="job-listing-details">
										<!-- Details -->
										<div class="job-listing-description">
											<h3 class="job-listing-title"><a href="<?php echo $project['edit']; ?>"><?php echo $project['name']; ?></a> 
												<!-- <span class="dashboard-status-button yellow">Expiring</span></h3> -->
												<!-- Job Listing Footer -->
												<div class="job-listing-footer">
													<ul>
														<li><i class="icon-material-outline-access-time"></i> <?php echo $project['days_left']; ?></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<!-- Task Details -->
									<ul class="dashboard-task-info">
										<li><?php echo $project['total_bids']; ?></li>
										<li><?php echo $project['avgBids'];?></li>
										<li><?php echo $project['budget']; ?></li>
									</ul>
									<!-- Buttons -->
									<div class="buttons-to-right always-visible">
										<a href="dashboard-manage-bidders.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Bidders <span class="button-info">3</span></a>
										<a href="<?php echo $project['edit']; ?>" class="button gray ripple-effect ico" title="Edit" data-toggle="tooltip" data-placement="top"><i class="icon-feather-edit"></i></a>
										<?php if($project['status']) { ?>
											<a href="<?php echo $project['disable']; ?>" class="button bg-danger text-white  ripple-effect ico" title="Disable" data-toggle="tooltip" data-placement="top"><i class="icon-feather-plus-circle"></i></a>
										<?php } else { ?>
											<a href="<?php echo $project['enable']; ?>" class="button bg-primary ripple-effect ico" title="Enable" data-toggle="tooltip" data-placement="top"><i class="icon-feather-minus-circle"></i></a>
										<?php } ?>	
									</div>
								</li>
							<?php } ?>

						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Row / End -->
	</div>
</div>
<?php echo $footer; ?>