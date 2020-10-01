<?php echo $header; ?>
<!-- Dashboard Container -->
<div class="dashboard-container">
	<!-- Dashboard Sidebar-->
	<?php echo $dashboard_menu; ?>
	<!-- Dashboard Sidebar / End -->
	<!-- Dashboard Content -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<h3><?php echo $heading_title; ?></h3>
				<span class="margin-top-7">Bids for <a href="<?php echo $href; ?>"><?php echo $name; ?></a></span>
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<?php foreach($breadcrumbs as $breadcrumb) { ?>
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
							<h3><i class="icon-material-outline-supervisor-account"></i> <?php echo $text_total_bidders; ?></h3>
							<div class="sort-by">
								<select class="form-control" onchange="location = this.value;">
									<option value="#">Highest First</option>
									<option value="">Lowest First</option>
									<option value="">Fastest First</option>
								</select>
							</div>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">
								<?php foreach ($bidders as $bidder) { ?>
								<li>
									<!-- Overview -->
									<div class="freelancer-overview manage-candidates">
										<div class="freelancer-overview-inner">
											<!-- Avatar -->
											<div class="freelancer-avatar">
												<div class="verified-badge"></div>
												<a href="#"><img src="<?php echo $bidder['image']; ?>" alt=""></a>
											</div>
											<!-- Name -->
											<div class="freelancer-name">
												<h4><a href="<?php echo $bidder['profile']; ?>"><?php echo $bidder['freelancer']; ?> <img class="flag" src="images/flags/de.svg" alt="" title="Germany" data-tippy-placement="top"></a></h4>

												<!-- Details -->
												<span class="freelancer-detail-item"><a href="#"><i class="icon-feather-mail"></i> <?php echo $bidder['email']; ?></a></span>

												<!-- Rating -->
												<div class="freelancer-rating">
													<div class="star-rating" data-rating="5.0"></div>
												</div>

												<!-- Bid Details -->
												<ul class="dashboard-task-info bid-info">
													<li><strong><?php echo $bidder['price']; ?></strong><span><?php echo $bidder['type']; ?></span></li>
													<li><strong><?php echo $bidder['delivery']; ?></strong><span>Delivery Time</span></li>
												</ul>

												<!-- Buttons -->
												<div class="buttons-to-right always-visible margin-top-25 margin-bottom-0">
													<button type="button" data-toggle="modal" data-target="#accept-offer" class="button ripple-effect"><i class="icon-material-outline-check"></i> Accept Offer</button>
													<button type="button" data-toggle="modal" data-target="#send-message" class="button dark ripple-effect"><i class="icon-feather-mail"></i> Send Message</button>
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
			<!-- Row / End -->
			<!-- Footer -->
			<div class="dashboard-footer-spacer"></div>
			<div class="small-footer margin-top-15">
				<div class="small-footer-copyrights">
					© 2018 <strong>Hireo</strong>. All Rights Reserved.
				</div>
				<ul class="footer-social-links">
					<li>
						<a href="#" title="Facebook" data-tippy-placement="top">
							<i class="icon-brand-facebook-f"></i>
						</a>
					</li>
					<li>
						<a href="#" title="Twitter" data-tippy-placement="top">
							<i class="icon-brand-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#" title="Google Plus" data-tippy-placement="top">
							<i class="icon-brand-google-plus-g"></i>
						</a>
					</li>
					<li>
						<a href="#" title="LinkedIn" data-tippy-placement="top">
							<i class="icon-brand-linkedin-in"></i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<!-- Footer / End -->

		</div>
	</div>
	<!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->


<!-- accept offer-->
<div class="modal fade" id="accept-offer" tabindex="-1" aria-labelledby="accept-offer" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accept-offer">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- send message-->
<div class="modal fade" id="send-message" tabindex="-1" aria-labelledby="send-messager" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="send-message">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>