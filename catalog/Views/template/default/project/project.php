<?php echo $header; ?> 
<!-- Titlebar -->
<section class="hero-area single-page-header">
	<div class="dashboard_menu_area">
		<div class="container-fluid">
			<div class="row justify-content-center single-page-header-inner">
				<div class="col-md-5 text-left">
					<div class="header-details">
						<h3 class="text-white"><?php echo $name; ?></h3>
						<ul>
							<li><i class="icon-material-outline-business"></i> <?php echo $employer; ?></li>
							<li>
								<div class="rating">
									<ul>
										<?php for ($i=1; $i <= 5; $i++) { ?>
											<?php if ($rating < $i) { ?>
												<li><span class="fa-stack"><i class="far fa-star fa-stack-2x"></i></span></li>
											<?php } else { ?>
												<li><span class="fa-stack">
													<i class="fas fa-star fa-stack-2x"></i></span></li>
												<?php } ?>
											<?php } ?>
										</ul>
									</div>
								</li>
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
	</section>
	<div class="content-wrapper">	
		<section>
			<div class="breadcrumb">
				<ul>
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
						<li>
							<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>	
		<!-- Page Content-->
		<div class="container-fluid">
			<div class="row">
				<!-- Content -->
				<div class="col-8 content-right-offset rounded">
					<!-- Description -->
					<div class="single-page-section">
						<h3 class=""><?php echo $text_description; ?></h3>
						<p><?php echo $description; ?></p>
					</div>
					<!-- Skills -->
					<div class="single-page-section">
						<h3><?php echo $text_skills; ?></h3>
						<?php if ($categories) { ?>
							<div class="task-tags">
								<?php foreach ($categories as $category) { ?>
									<span><?php echo $category['name']; ?></span>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<div class="single-page-section">
						<div class="bidding-headline"><h3><?php echo $text_bid; ?></h3></div>
						<form enctype="multipart/form-data" id="bidding-form" accept-charset="utf-8"> 
							<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
							<input type="hidden" name="freelancer_id" value="<?php echo $freelancer_id; ?>" />
							<input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>" />
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4"><?php echo $text_rate; ?></label>
									<input type="email" class="form-control" id="inputEmail4">
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4"><?php echo $text_delivery; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<button class="btn btn-info" type="button"><?php echo $config_currency; ?></button>
										</div>
										<input class="form-control" type="text" name="quote" value=""/>
									</div>
								</div>
							</div>
						</form> 
						<!-- Button -->
						<button id="snackbar-place-bid" class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place a Bid</span></button>
					</div>
				</div>
				<!-- Sidebar -->
				<div class="col-4 ">
					<div class="sidebar-container">
						<div class="countdown green"><?php echo $days_left; ?></div>
						<div class="sidebar-widget">
							<div class="bidding-widget text-white text-center">
							 <a href="<?php echo $add_project; ?>" class="button btn-info btn-lg btn-block ripple-effect button-sliding-icon">Post a project like this <i class="fas fa-long-arrow-alt-right"></i></a>
							</div>
						</div>
						<!-- Sidebar Widget -->
						<div class="sidebar-widget">
							<h3>Bookmark or Share</h3>
							<!-- Bookmark Button -->
							<button class="bookmark-button">
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
				<!-- Freelancers Bidding -->
				<div class="col-8 rounded boxed-list ">
					<div class="margin-bottom-60" id="bid-container"></div>
				</div>
			</div>
		</div>
	</div> <!---- content-wrapper ---->
	<script type='text/javascript'>
		<?php if (service('registry')->get('bidding_extension_status')) { ?>
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
				data: $('#bidding-form').serialize(),
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
