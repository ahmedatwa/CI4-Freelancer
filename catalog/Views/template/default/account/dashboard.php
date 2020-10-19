<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container">
	<section class="gray">
	<div class="dashboard-content-inner">
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
		</div>
		<!-- Fun Facts Container -->
		<div class="row">
			<div class="col fun-fact">
				<div class="fun-fact-text">
					<span>Task Bids Won</span>
					<h4>22</h4>
				</div>
				<div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
			</div>
			<div class="col fun-fact">
				<div class="fun-fact-text">
					<span>Reviews</span>
					<h4>28</h4>
				</div>
				<div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
			</div>
			<div class="col fun-fact" data-fun-fact-color="#2a41e6">
				<div class="fun-fact-text">
					<span>This Month Views</span>
					<h4><?php echo $profile_views; ?></h4>
				</div>
				<div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
			</div>
		</div>
		<!-- Row -->
		<div class="row">

			<!-- Dashboard Box -->
			<div class="col-sm-12 col-md-6">
				<div class="dashboard-box">
					<div class="headline">
						<h3><i class="icon-material-baseline-notifications-none"></i> Notifications</h3>
					</div>
					<div class="content">
						<ul class="dashboard-box-list">
							<li>
								<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
								<span class="notification-text">
									<strong>Michael Shannah</strong> applied for a job <a href="#">Full Stack Software Engineer</a>
								</span>
								<!-- Buttons -->
								<div class="buttons-to-right">
									<a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
								</div>
							</li>

						</ul>
					</div>
				</div>
			</div>

		</div>
	</div>
	</section>
</div>
<?php echo $footer; ?>