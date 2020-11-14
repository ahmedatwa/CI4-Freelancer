<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container">
	<section class="gray">
	<div class="dashboard-content-inner">
		<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<h3><?php echo $text_greeting; ?></h3>
			</div>
			<div class="d-flex justify-content-center mb-4">
				<div class="card mx-2">
					<div class="card-body row">
						<div class="col-9">
							<h2>Profile Views</h2>
						</div>
						<div class="col-3">
							<span class="text-right"><i class="far fa-eye fa-2x text-success"></i></span>
						</div>
						<div class="col-12"><h1 class="text-center"><?php echo $profile_views; ?></h1></div>
					</div>
				</div>
				<div class="card mx-2">
				<div class="card-body row">
						<div class="col-9">
							<h2>Total Projects</h2>
						</div>
						<div class="col-3">
							<span class="text-right"><i class="fas fa-briefcase fa-2x text-warning"></i></span>
						</div>
						<div class="col-12"><h1 class="text-center"><?php echo $projects_total; ?></h1></div>
					</div>
				</div>
				<div class="card mx-2">
					<div class="card-body row">
						<div class="col-9">
							<h2>Balance</h2>
						</div>
						<div class="col-3">
							<span class="text-right"><i class="fas fa-wallet fa-2x text-info"></i></span>
						</div>
						<div class="col-12"><h1 class="text-center"><?php echo $balance; ?></h1></div>
					</div>
				</div>
			</div>
		<div class="row">
			<!-- Dashboard Box -->
			<div class="col">
				<div class="dashboard-box mt-4">
					<div class="headline">
						<h3><i class="icon-material-baseline-notifications-none"></i> <?php echo $text_news_feed; ?></h3>
					</div>
					<div class="content shadow-sm p-4 m-2">
						<?php if ($news_feeds) { ?>
						<ul class="dashboard-box-list">
							<?php foreach ($news_feeds as $news_feed) { ?>
							<li>
								<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
								<span class="notification-text">
									<?php echo $news_feed['comment']; ?>. <small><?php echo $news_feed['date_added']; ?></small>	
								</span>
							</li>
							<?php } ?>
						</ul>
					<?php } else { ?>
					<p class="text-center">No Feeds! </p>	
				<?php } ?>
					</div>
				</div>
			</div>

		</div>
	</div>
	</section>
</div>
<?php echo $footer; ?>