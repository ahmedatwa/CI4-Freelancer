<?php echo $header; ?><?php echo $menu; ?>
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
								<?php if ($status != 'Expired') { ?>
								<li><div class="verified-badge-with-title"><?php echo $status; ?></div></li>
							    <?php } ?>
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
			<div class="row align-items-start">
				<div class="col-sm-12 col-md-9 mb-4 p-4 shadow-sm rounded border bg-white">
					<div class="single-page-section">
						<h3><?php echo $text_description; ?></h3>
						<p><?php echo $description; ?></p>
					</div>
					<h4 class="mb-4">Viewed: <span class="badge badge-success"><?php echo $viewed; ?></span></h4>
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
					<!-- Atachments -->
					<?php if ($attachment) { ?>
					<div class="single-page-section">
						<h3>Attachments</h3>
						<div class="attachments-container">
							<a href="<?php echo $download; ?>" class="attachment-box ripple-effect"><span><?php echo $attachment; ?></span><i><?php echo $attachment_ext; ?></i></a>
						</div>
					</div>
					<hr />
				    <?php } ?>
				<?php if ($freelancer_id != $employer_id) { ?>
				<?php if ($days_left > 0 && $isLogged) { ?>
				<div class="single-page-section">
						<div class="bidding-headline"><h3><?php echo $text_bid; ?></h3>
							<p class="mb-4"><?php echo $text_bid_detail; ?></p></div>
						<form action="" enctype="multipart/form-data" id="bidding-form" accept-charset="UTF-8"> 
							<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
							<input type="hidden" name="freelancer_id" value="<?php echo $freelancer_id; ?>" />
							<input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>" />
							<input type="hidden" name="fee" value="" />
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4"><?php echo $text_rate; ?></label>
									<div class="input-group">
									<input class="form-control" type="text" id="input-quote" name="quote" value=""/>
									<div class="input-group-append">
								    <span class="input-group-text" id="basic-addon2"><?php echo $config_currency; ?></span>
								  </div>
								</div>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4"><?php echo $text_delivery; ?></label>
									<div class="input-group">
										<input type="number" class="form-control" id="input-delivery" name="delivery" min="1">
										<div class="input-group-prepend">
											<span class="input-group-text">Days</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleFormControlTextarea1"><?php echo $text_describe; ?></label>
								<textarea class="form-control" id="input-description" name="description" rows="7" cols="10"></textarea>
							</div>
						</form> 
							<div class="margin-top-30">	  
								<span>Optional Upgrades</span>	  
								<table class="table table-hover" id="upgrade-options-table">
									<thead>
									</thead>
									<tbody>
										<tr>
											<td width="20%">
												<div class="form-check">
													<input class="form-check-input" name="checkbox" type="checkbox" value="<?php echo number_format($config_upgrade_sponser, 2); ?>" id="sponsor">
													<label class="form-check-label" for="input-sponser">
														<?php echo number_format($config_upgrade_sponser, 2) . ' EGP'; ?>
													</label>
												</div>
											</td>
											<td><span class="badge badge-warning">Sponsored</span></td>
											<td>Bids that are sponsored are 80% more likely to be awarded. Stand out from the rest of the freelancers, by being pinned to the top of the employer's bid list. There is only one sponsored bid per project.</td>
										</tr>
										<tr>
											<td width="20%">
												<div class="form-check">
													<input class="form-check-input" name="checkbox" type="checkbox" value="<?php echo number_format($config_upgrade_highlight, 2); ?>" id="upgrade-fee">
													<label class="form-check-label" for="input-highlight">
														<?php echo number_format($config_upgrade_highlight, 2) . ' EGP'; ?>
													</label>
												</div>
											</td>
											<td><span class="badge badge-info">Highlight</span></td>
											<td>Make your bid highlighted in yellow for greater visibility to the employer and a higher chance of being awarded the project.</td>
										</tr>
									</tbody>
								</table> 
						<!-- Button -->
					<button id="button-place-bid" onclick="" class="button ripple-effect move-on-hover btn btn-lg margin-top-30 float-right"><?php echo $button_bid; ?></button>
					</div>
				</div>
				<?php } else { ?>
					<div class="text-center">
						<div class="single-page-section">
							<p class="lead mb-3">Not logged yet, please login to place bids</p>
							<a href="<?php echo $login; ?>" class="btn btn-dark"><i class="fas fa-sign-in-alt"></i> Login</a>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			<div class="clearfix"></div>
			<div id="bid-container" class="my-4"></div>	
			</div>
				<!-- Sidebar -->
				<div class="col-sm-12 col-md-3">
					<div class="sidebar-container p-3 mb-5 bg-white">
						<?php if ($days_left <= 0) { ?>
							<div class="alert alert-danger text-center" role="alert">
							  <?php echo $text_expired; ?>
							</div>
					    <?php } else { ?>
					    	<div class="alert alert-info text-center" role="alert">
							  <?php echo $days_left; ?>
							</div>
						<?php } ?>
						<div class="sidebar-widget">
							<div class="bidding-widget text-white text-center">
							 <a href="<?php echo $add_project; ?>" class="button ripple-effect button-sliding-icon"><?php echo $button_post_project; ?> <i class="fas fa-long-arrow-alt-right"></i></a>
							</div>
						</div>
					<div class="dropdown-divider"></div>
					<div class="sidebar-widget">
						<h4><i class="fas fa-info-circle"></i> How to write a winning bid</h4>
						<p>Your best chance of winning this project is writing a great bid proposal here!</p>
						<p>Great bids are ones that:</p>
						<ul>
						<li>Are engaging and well written without spelling or grammatical errors</li>	
						<li>Show a clear understanding of what is required for this specific project - personalize your response!</li>
						<li>Explain how your skills & experience relate to the project and your approach to working on it</li>
						<li>Ask questions to clarify any unclear details</li>
						</ul>
						<p>Most of all - don't spam or post cut-and-paste bids. You will be penalized or banned if you do so.</p>
					</div>
					<!-- Sidebar Widget -->
					<?php if ($other_projects) { ?>
						<div class="dropdown-divider"></div>
						<div class="sidebar-widget">
							<h3><?php echo $text_similar; ?></h3>
							<ul class="list-group list-group-flush">
								<?php foreach ($other_projects as $other) { ?>
							    <li class="list-group-item"><a class="text-primary" href="<?php echo $other['href']; ?>"><?php echo $other['name']; ?></a></li>
							  <?php } ?>
							</ul>
						</div>
					<?php } ?>
					</div>
				</div>

			</div>
	</div> <!---- content-wrapper ---->
<script type="text/javascript">
$('#button-place-bid').on('click', function() {
bootbox.confirm({
	message: "Are you sure?",
	size: 'small',
    className: 'animate__animated animate__fadeInDown',
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel',
            className: 'btn-dark'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm',
            className: 'btn-success'
        }
    },
    onShow: function(e) {
		var fee = $('input[name=\'fee\']').val();
		if (fee !== '') {
			$(this).find('.modal-body').before('<div class="modal-header"><h5 class="modal-title">Are you sure?</h5><button type="button" class="bootbox-close-button close" aria-hidden="true">×</button></div>')
			$(this).find('.modal-body').text(fee + '.00 EGP will be deducted from your balance' )
		}
    },
    callback: function (result) {
    if (result) {
		$.ajax({
			url: 'extension/bid/bid/placeBid',
			method:'post',
			data: $('#bidding-form').serialize(),
			dataType: 'json',
			beforeSend: function() {
				$('.bootbox-accept').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
				$('.alert, .text-danger').remove();
			},
			complete: function() {
	  		    $('.bootbox-accept').html('<?php echo $button_bid; ?>');
			},
			success: function(json) {
				
				if (json['error']) {
	                for (i in json['error']) {
	                 var element = $('#input-' + i.replace('_', '-'));

	                 if (element.parent().hasClass('input-group')) {
	                   $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
	                 } else {
	                  $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
	                }
	              }
	              $('html, body').animate({
                         scrollTop: $('.bidding-headline').offset().top
                   }, 1000, 'linear');
	            }

				if (json['no_allawed']) {
					$('#bidding-form').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> ' + json['no_allawed'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('html, body').animate({
                         scrollTop: $('.bidding-headline').offset().top
                    }, 1000, 'linear');
				}

				if (json['fee']) {
					$('#bidding-form').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> ' + json['fee'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('html, body').animate({
                         scrollTop: $('.bidding-headline').offset().top
                    }, 1000, 'linear');
				}

				if(json['success']) {
					$('#bidding-form').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#bid-container').load("extension/bid/bid?pid=<?php echo $project_id; ?>");
					// Reset the Form 
					$('#bidding-form').trigger('reset');
					$('html, body').animate({
                         scrollTop: $('.bidding-headline').offset().top
                    }, 1000, 'linear');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError);
			}
		});
	   } // if end
    } // callback end
   });  // bootbox end
});	

</script>
<script type='text/javascript'>
<?php if (service('registry')->get('extension_bid_status')) { ?>
$('#bid-container').on('click', '.pagination a', function(e) {
	e.preventDefault();

	$('#bid-container').fadeOut('slow');

	$('#bid-container').load(this.href);

	$('#bid-container').fadeIn('slow');
});

$('#bid-container').load("extension/bid/bid?pid=<?php echo $project_id; ?>");
<?php } ?>
</script>
<script type="text/javascript">
$("#upgrade-options-table input[type='checkbox']").on('change', function() {
	var total = 0;
	$('#upgrade-options-table input:checkbox:checked').each(function() { 
        total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
    });   

	$('#button-place-bid').html('Place bid and Pay ' + total + '.00 EGP');
	$('input[name=\'fee\']').val(total);
});
</script>
<?php if ($success) { ?>
<script type="text/javascript">
	$.notify({
	// options
	icon: 'fas fa-check-circle',
	title: 'Success:',
	message: "<?php echo $success; ?>",
},{
	// settings
	element: 'body',
	type: "success",
	allow_dismiss: false,
	placement: {
		from: "top",
		align: "center"
	},
	animate: {
		enter: 'animate__animated animate__fadeInDown',
		exit: 'animate__animated animate__fadeOutUp'
	},
});	
</script>	
<?php } ?>
<?php echo $footer; ?>
