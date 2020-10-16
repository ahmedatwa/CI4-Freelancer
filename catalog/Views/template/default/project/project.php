<?php echo $header; ?> 
<!-- Titlebar -->
<div class="single-page-header" data-background-image="catalog/default/images/single-task.jpg">
<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
				<div class="left-side">
						<div class="header-details">
						<h3 class=""><?php echo $name; ?></h3>
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
		<!-- Page Content-->
			<div class="row justify-content-md-center">
				<!-- Content -->
				<div class="col-sm-12 col-md-9 mb-4 p-4 shadow rounded bg-white">
					<!-- Description -->
					<div class="single-page-section">
						<h3><?php echo $text_description; ?></h3>
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
									<input type="number" class="form-control" id="input-quote" name="quote" min="5">
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4"><?php echo $text_delivery; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><?php echo $config_currency; ?></span>
										</div>
										<input class="form-control" type="text" id="input-delivery-time" name="delivery_time" value=""/>
									</div>
								</div>
							</div>
						</form> 
						<!-- Button -->
						<button id="snackbar-place-bid" class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place a Bid</span></button>
					</div>
				</div>
				<!-- Sidebar -->
				<div class="col-3">
					<div class="sidebar-container shadow-sm p-3 mb-5 bg-white rounded">
						<?php if ($runtime) { ?>
						<div class="countdown green mb-4"><?php echo $days_left; ?></div>
					    <?php } ?>
						<div class="sidebar-widget">
							<div class="bidding-widget text-white text-center">
							 <a href="<?php echo $add_project; ?>" class="button full-width ripple-effect button-sliding-icon">Post a project like this <i class="fas fa-long-arrow-alt-right"></i></a>
							</div>
						</div>
						<div class="sidebar-widget">
							<h3>Viewed: <span class="badge badge-success"><?php echo $viewed; ?></span></h3>
						</div>	
						<!-- Sidebar Widget -->
						<div class="sidebar-widget">
							<h3>Share</h3>
							<!-- Share Buttons -->
							<div class="share-buttons margin-top-25">
								<div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
								<div class="share-buttons-content">
									<span>Interesting? <strong>Share It!</strong></span>
									<ul class="share-buttons-icons">
										<li><a href="#" data-toggle="tooltip" title="<?php echo $text_facebook; ?>" data-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
										<li><a href="#" data-toggle="tooltip" title="<?php echo $text_twitter; ?>" data-placement="top"><i class="icon-brand-twitter"></i></a></li>
										<li><a href="#" data-toggle="tooltip" title="<?php echo $text_gplus; ?>" data-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Freelancers Bidding -->
					<div class="col-9 shadow rounded bg-white margin-bottom-60 " id="bid-container"></div>
			</div>
			</div>
	</div> <!---- content-wrapper ---->
<script type="text/javascript">
$("#snackbar-place-bid").on('click', function () {
	$.ajax({
		url: 'extension/bid/bid/placeBid',
		method:'post',
		data: $('#bidding-form').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#snackbar-place-bid').prop('disabled');
			$('.text-danger, .alert-danger').remove();
		},
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
                for (i in json['error']) {
                 var element = $('#input-' + i.replace('_', '-'));

                 if (element.parent().hasClass('input-group')) {
                   $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                 } else {
                  $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                }
              }
            }

			if (json['no_allawed']) {
				$('#bidding-form').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> ' + json['no_allawed'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}

			if(json['success']) {
				$('#bidding-form').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				$('#bid-container').load("extension/bid/bid?pid=<?php echo $project_id; ?>");
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});
</script>
<script type='text/javascript'>
<?php if (service('registry')->get('bidding_extension_status')) { ?>
$('#bid-container').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#bid-container').fadeOut('slow');

	$('#bid-container').load(this.href);

	$('#bid-container').fadeIn('slow');
});

$('#bid-container').load("extension/bid/bid?pid=<?php echo $project_id; ?>");
<?php } ?>
</script>
<?php echo $footer; ?>
