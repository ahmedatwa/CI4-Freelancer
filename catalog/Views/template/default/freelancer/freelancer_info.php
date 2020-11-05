<?php echo $header; ?> 
<!-- Titlebar  -->
<div class="single-page-header freelancer-header margin-bottom-30" data-background-image="catalog/default/images/single-freelancer.jpg">
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="single-page-header-inner">
			<div class="left-side">
				<div class="header-image freelancer-avatar"><img src="<?php echo $image; ?>" alt=""></div>
				<div class="header-details">
					<h3><?php echo $name; ?> <span><?php echo $tag_line; ?></span></h3>
					<ul>
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
			</div>
		</div>
	</div>
</div>
</div>
<!-- Page Content -->
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
<div class="row">
	<!-- Content -->
	<div class="col-sm-12 col-md-9 mb-4 shadow p-3 mb-5 bg-white rounded">
		<!-- Page Content -->
		<div class="single-page-section">
			<h3 class="margin-bottom-25"><?php echo $text_about; ?></h3>
			<p><?php echo $about; ?></p>
		</div>

		<div class="single-page-section">
			<h3 class="margin-bottom-25"><?php echo $text_education; ?></h3>
			<?php foreach ($educations as $education) { ?>
				<p><?php echo strtoupper($education['title']); ?> in <?php echo $education['major']; ?> | <?php echo $education['university']; ?> | <?php echo $education['year']; ?> | <?php echo $education['country']; ?></p>	
			<?php } ?>
		</div>
		<div class="single-page-section">
			<h3 class="margin-bottom-25"><?php echo $text_cert; ?></h3>
			<?php foreach ($certificates as $cert) { ?>
				<p><?php echo $cert['name']; ?> | <?php echo $cert['year']; ?></p>	
			<?php } ?>
		</div>
		<div class="single-page-section">
			<h3><?php echo $text_skills; ?></h3>
			<div class="task-tags">
				<?php foreach ($skills as $skill) { ?>
					<span><?php echo $skill['name']; ?></span>
				<?php } ?>
			</div>
		</div>
		<div class="single-page-section">
			<h3><?php echo $text_languages; ?></h3>
			<div class="task-tags">
				<?php foreach ($languages as $language) { ?>
					<span><?php echo $language['name']; ?></span>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- Sidebar -->
	<div class="col">
		<div class="sidebar-container">
			<!-- Profile Overview -->
			<div class="profile-overview">
				<div class="overview-item"><strong><?php echo $rate; ?></strong><span>Hourly Rate</span></div>
				<div class="overview-item"><strong>53</strong><span>Jobs Done</span></div>
			</div>

			<!-- Button -->
			<?php if ($customer_id != $customer_profile_id) { ?> 
			<button type="button" data-toggle="modal" data-target="#hireme" class="button btn-block apply-now-button margin-bottom-50"><?php echo $button_offer; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
			<?php } ?>

			<!-- Freelancer Indicators -->
			<div class="sidebar-widget">
				<div class="freelancer-indicators">
					<!-- Indicator -->
					<div class="indicator">
						<strong><?php echo $recommended; ?></strong>
						<div class="indicator-bar" data-indicator-percentage="<?php echo $recommended; ?>"><span></span></div>
						<span>Recommendation</span>
					</div>
					<!-- Indicator -->
					<div class="indicator">
						<strong><?php echo $ontime; ?>%</strong>
						<div class="indicator-bar" data-indicator-percentage="<?php echo $ontime; ?>"><span></span></div>
						<span>On Time</span>
					</div>	
				</div>
			</div>

			<!-- Widget -->
			<?php if ($facebook || $github) { ?>
			<div class="sidebar-widget">
				<h3><?php echo $text_social; ?></h3>
				<div class="freelancer-socials margin-top-25">
					<ul>
						<?php if ($facebook) { ?>
						<li><a href="<?php echo $facebook; ?>" title="Facebook" data-placement="top" data-toggle="tooltip"><i class="icon-brand-facebook"></i></a></li>
						<?php } ?>
						<?php if ($twitter) { ?>	
						<li><a href="<?php echo $twitter; ?>" title="Twitter" data-placement="top" data-toggle="tooltip"><i class="icon-brand-twitter"></i></a></li>
						<?php } ?>
						<?php if ($linkedin) { ?>
						<li><a href="<?php echo $linkedin; ?>" title="LinkedIn" data-placement="top" data-toggle="tooltip"><i class="icon-brand-linkedin"></i></a></li>
						<?php } ?>
						<?php if ($github) { ?>
						<li><a href="<?php echo $github; ?>" title="GitHub" data-placement="top" data-toggle="tooltip"><i class="icon-brand-github"></i></a></li>
					    <?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="row">
	<!-- Boxed List -->
	<?php if ($reviews) { ?>
	<div class="col-sm-12 col-md-9 mb-4 shadow p-3 mb-5 bg-white rounded">
		<div class="boxed-list-headline">
			<h3><i class="icon-material-outline-thumb-up"></i> <?php echo $text_history; ?></h3>
		</div>
		<ul class="boxed-list-ul py-4">
			<?php foreach ($reviews as $review) { ?>
				<li>
					<div class="boxed-list-item">
						<!-- Content -->
						<div class="item-content">
							<h4><?php echo $review['name']; ?> <span>Rated as Freelancer</span></h4>
							<div class="item-details margin-top-10">
								<div class="detail-item"><i class="icon-material-outline-date-range"></i> <?php echo $review['date_added']; ?></div>
								<div class="star-rating rating">
									<ul>
										<?php for ($i=1; $i <= 5; $i++) { ?>
											<?php if ($rating < $i) { ?>
												<li><span class="fa-stack"><i class="far fa-star fa-stack-1x"></i></span></li>
											<?php } else { ?>
												<li><span class="fa-stack">
													<i class="fas fa-star fa-stack-1x"></i></span></li>
												<?php } ?>
											<?php } ?>
										</ul>
									</div>
								</div>
								<div class="item-description">
									<p><?php echo $review['comment']; ?></p>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
			<!-- Pagination -->
			<div class="clearfix"></div>
			<?php echo $pagination; ?>
			<div class="clearfix"></div>
			<!-- Pagination / End -->
		</div>
		<!-- Boxed List / End -->
	<?php } ?>
	</div>
</div>
<!-- Spacer -->
<div class="margin-top-15"></div>
<!-- Button trigger modal Hire Me -->
<!-- Modal -->
<div class="modal fade" id="hireme" tabindex="-1" aria-labelledby="hiremeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="hiremeModal"><?php echo $text_hire_me; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data" method="post" action="" id="form-hire" accept-charset="utf-8"> 
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<input type="hidden" name="sender_id" value="<?php echo $employer_id; ?>" />
					<input type="hidden" name="receiver_id" value="<?php echo $freelancer_id; ?>" />

					<div class="form-group">
						<label for="exampleInputEmail1"><i class="fas fa-comment"></i> <?php echo $text_message; ?></label>
						<textarea rows="3" class="form-control" name="message"><?php echo $text_canned; ?></textarea>
					</div>
					<div class="form-group row">
						<div class="col">
							<select class="form-control" name="type">
								<option><?php echo $text_fixed_price; ?></option>
								<option><?php echo $text_per_hour; ?></option>
							</select>
						</div>
						<div class="col">
							<input type="number" class="form-control" name="delivery_time" value="3" min="2" max="30">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?php echo $text_budget_min; ?></label>
						<input type="number" value="<?php echo $rate; ?>" class="form-control" name="budget_min" min="10">
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="button btn-lg btn-block" id="button-hire-me"><?php echo $button_hire; ?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$("#button-hire-me").on('click', function () {
		$.ajax({
			url: 'freelancer/freelancer/hireMe?cid=<?php echo $employer_id; ?>',
			dataType: 'json',
			method: 'post',
		    data:$("#form-hire").serialize(),
			beforeSend: function() {
				$('.fas, .alert').remove();
				$(this).prop("disabled", true);
				$(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
			},
			complete: function() {
				$(this).html('<?php echo $button_hire; ?>');
			},
			success : function (json){
				if (json['success']) {
					$('.modal-header').after('<div class="alert alert-success alert-dismissible fade show" role="alert">'+ json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
			 alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}

		});
});
</script>
<?php echo $footer; ?>
