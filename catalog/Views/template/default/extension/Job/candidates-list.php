<?php echo $header; ?><?php echo $dashboard_menu; ?>
<div class="container">
	<div class="dashboard-content-container">
	<div class="row">
		<div class="dashboard-content-inner w-50">
				<div class="dashboard-headline">
				<h3>Manage Candidates</h3>
				<span class="margin-top-7">Job Applications for <a href="#"><?php echo $job_name; ?></a></span>
			</div>	
			<div class="row">
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">
						<div class="headline">
							<h3><i class="icon-material-outline-supervisor-account"></i> <?php echo $total_candidates; ?> Candidates</h3>
						</div>
						<div class="content">
							<ul class="dashboard-box-list">
							<?php foreach ($candidates as $candidate) { ?>
								<li>
									<div class="freelancer-overview manage-candidates">
										<div class="freelancer-overview-inner">
											<div class="freelancer-avatar">
												<div class="verified-badge"></div>
												<img src="images/user-avatar-big-03.jpg" alt="">
											</div>
											<div class="freelancer-name">
												<h4><?php echo $candidate['name']; ?></h4>
												<span class="freelancer-detail-item"><i class="icon-feather-mail"></i> <?php echo $candidate['email']; ?></span>
												<span class="freelancer-detail-item">Applied: <?php echo $candidate['date_added']; ?></span>
												<div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
												<a href="<?php echo $candidate['download']; ?>" class="button ripple-effect"><i class="icon-feather-file-text"></i> Download CV</a>
												<a href="<?php echo $candidate['download']; ?>" class="button ripple-effect"><i class="icon-feather-file-text"></i> Download CV</a>
												</div>
											</div>
										</div>
									</div>
								</li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
	</div>
</div>
<?php echo $footer; ?>