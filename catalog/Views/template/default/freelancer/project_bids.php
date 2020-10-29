<div class="col-xl-12" id="bidders-wrapper">
	<div class="dashboard-box margin-top-0">
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
										<div class="rating">
											<ul>
												<?php for ($i=1; $i <= 5; $i++) { ?>
													<?php if ($bidder['rating'] < $i) { ?>
														<li><span class="fa-stack"><i class="far fa-star fa-stack"></i></span></li>
													<?php } else { ?>
														<li><span class="fa-stack">
															<i class="fas fa-star fa-stack"></i></span></li>
														<?php } ?>
													<?php } ?>
												</ul>
											</div>
										</div>
									<!-- Bid Details -->
									<ul class="dashboard-task-info bid-info">
										<li><strong><?php echo $bidder['price']; ?></strong><span><?php echo $bidder['type']; ?></span></li>
										<li><strong><?php echo $bidder['delivery']; ?></strong><span>Delivery Time</span></li>
									</ul>
									<!-- Buttons -->
									<div class="buttons-to-right always-visible margin-top-25 margin-bottom-0" id="bidders-button-wrapper">
									<?php if ($bidder['type']) { ?>
										<button type="button" id="award-freelancer-button" class="btn btn-success btn-sm" data-freelancer-id="<?php echo $bidder['freelancer_id']; ?>" data-bid-id="<?php echo $bidder['bid_id']; ?>" disabled><i class="icon-material-outline-check"></i>Awarded</button>
									<?php } else { ?>
										<button type="button" id="award-freelancer-button" class="btn btn-danger btn-sm" data-freelancer-id="<?php echo $bidder['freelancer_id']; ?>" data-bid-id="<?php echo $bidder['bid_id']; ?>" ><i class="icon-material-outline-check"></i>Award Freelancer</button>
									<?php } ?>
										<button type="button" id="send-message-button" class="btn btn-dark btn-sm" data-freelancer-id="<?php echo $bidder['freelancer_id']; ?>" ><i class="icon-feather-mail"></i> Send Message</button>
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



