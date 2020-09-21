<?php echo $header; ?> 
<!-- Titlebar -->
<div class="single-page-header" data-background-image="catalog/default/images/single-task.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-details">
							<h3><?php echo $name; ?></h3>
							<ul>
								<li><i class="icon-material-outline-business"></i> <?php echo $employer; ?></li>
								<li><div class="star-rating" data-rating="<?php echo $rating; ?>"></div></li>
								<li><div class="verified-badge-with-title">Verified</div></li>
							</ul>
						</div>
					</div>
					<div class="right-side">
						<div class="salary-box">
							<div class="salary-type"><?php echo $text_budget; ?></div>
							<div class="salary-amount"><?php echo $budget; ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Page Content-->
<div class="container">
	<div class="row">
		<!-- Content -->
		<div class="col-xl-8 col-lg-8 content-right-offset">
			<!-- Description -->
			<div class="single-page-section">
				<h3 class="margin-bottom-25"><?php echo $text_description; ?></h3>
				<p><?php echo $description; ?></p>
			</div>
			<!-- Skills -->
			<div class="single-page-section">
				<h3><?php echo $text_skills; ?></h3>

				<?php if ($skills) { ?>
				<div class="task-tags">
					<?php foreach ($skills as $skill) { ?>
					<span><?php echo $skill['text']; ?></span>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
			
			<!-- Freelancers Bidding -->
			<div class="boxed-list margin-bottom-60" id="bid-container"></div>

		</div>
		

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">
				<div class="countdown green margin-bottom-35"><?php echo $days_left; ?></div>
				<div class="sidebar-widget">
					<div class="bidding-widget">
						<div class="bidding-headline"><h3><?php echo $text_bid; ?></h3></div>
						<div class="bidding-inner" id="bidding-form">
						<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
						<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
						<input type="hidden" name="freelancer_id" value="<?php echo $freelancer_id; ?>" />
						<input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>" />
							<span class="bidding-detail"><?php echo $text_rate; ?></span>
							<div class="bidding-value"><?php echo $config_currency; ?><span id="biddingVal"></span></div>
							<input class="bidding-slider" type="text" name="quote" value="" data-slider-handle="custom" data-slider-currency="<?php echo $config_currency; ?>" data-slider-min="5" data-slider-max="300" data-slider-value="auto" data-slider-step="5" data-slider-tooltip="hide" />					
							<span class="bidding-detail margin-top-30"><?php echo $text_delivery; ?></span>
							<div class="bidding-fields">
								<div class="bidding-field">
									<!-- Quantity Buttons -->
									<div class="qtyButtons">
										<div class="qtyDec"></div>
										<input type="text" name="delivery" value="1">
										<div class="qtyInc"></div>
									</div>
								</div>
							</div>
							<!-- Button -->
							<button id="snackbar-place-bid" class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place a Bid</span></button>
						</div>
						<?php if (!$logged) { ?>
						<div class="bidding-signup">Don't have an account? <a href="<?php echo $register; ?>" class="sign-in"><?php echo $text_register; ?></a></div>
						<?php } ?>
					</div>
				</div>
				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<h3>Bookmark or Share</h3>
					<!-- Bookmark Button -->
					<button class="bookmark-button margin-bottom-25">
						<span class="bookmark-icon"></span>
						<span class="bookmark-text">Bookmark</span>
						<span class="bookmarked-text">Bookmarked</span>
					</button>
					<!-- Share Buttons -->
					<div class="share-buttons margin-top-25">
						<div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
						<div class="share-buttons-content">
							<span>Interesting? <strong>Share It!</strong></span>
							<ul class="share-buttons-icons">
								<li><a href="#" data-button-color="#3b5998" title="<?php echo $text_facebook; ?>" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
								<li><a href="#" data-button-color="#1da1f2" title="<?php echo $text_twitter; ?>" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
								<li><a href="#" data-button-color="#dd4b39" title="<?php echo $text_gplus; ?>" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</div>
<script type='text/javascript'>
<?php if (service('registry')->get('extension_project_bid_status')) { ?>
	$('#bid-container').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#bid-container').fadeOut('slow');

    $('#bid-container').load(this.href);

    $('#bid-container').fadeIn('slow');
});

$('#bid-container').load("extension/bid/bid?project_id=<?php echo $project_id; ?>");
<?php } ?>
</script>
<script type="text/javascript">
$("#snackbar-place-bid").on('click', function () {
	$.ajax({
		url: 'extension/bid/bid/placeBid',
		method:'post',
		data: $('#bidding-form input[name=\'quote\'], #bidding-form input[name=\'delivery\'], #bidding-form input[type=\'hidden\']'),
		dataType: 'json',
        beforeSend: function() {
			$('#snackbar-place-bid').prop('disabled');
		},
        success: function(json) {
			if (json['error']) {
				 $('#bidding-form').before('<div class="notification error closeable"><p><i class="fas fa-exclamation-triangle"></i> ' + json['error'] + '</p><a class="close" href="#"></a></div>');
			}
			if(json['success']) {
				 $('#bidding-form').before('<div class="notification success closeable"><p><i class="fas fa-check-circle"></i> ' + json['success'] + '</p><a class="close" href="#"></a></div>');
			    $('#bid-container').load("extension/bid/bid?project_id=<?php echo $project_id; ?>");
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			$.notify({icon: "fas fa-exclamation-triangle", title: "Warning:", message: thrownError },{type: "notification error closeable"});
		}
	});
});
</script>
<?php echo $footer; ?>
