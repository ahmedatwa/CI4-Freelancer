<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container">
	<section class="gray">
	<div class="dashboard-content-inner">
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
		</div>
		<div class="row">
			<!-- Dashboard Box -->
			<div class="col-sm-12 col-md-6">
				<div class="dashboard-box">
					<div class="headline">
						<h3><i class="icon-material-baseline-notifications-none"></i> <?php echo $text_news_feed; ?></h3>
					</div>
					<div class="content">
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