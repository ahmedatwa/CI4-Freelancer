<?php if ($bids) { ?>
<div class="boxed-list">
<div class="boxed-list-headline">
	<h3><i class="icon-material-outline-group"></i> <?php echo $heading_title; ?></h3>
</div>
<ul class="boxed-list-ul">
<?php foreach ($bids as $bid) { ?>	
	<li id="bid-<?php echo $bid['bid_id']; ?>">
		<div class="bid">
			<!-- Avatar -->
			<div class="bids-avatar">
				<div class="freelancer-avatar">
					<a href="<?php echo $bid['profile']; ?>"><img src="<?php echo $bid['image']; ?>" alt=""></a>
				</div>
			</div>
			<!-- Content -->
			<div class="bids-content">
				<!-- Name -->
				<div class="freelancer-name">
					<h4><a href="<?php echo $bid['profile']; ?>"><?php echo $bid['freelancer']; ?></a></h4>
					<div class="rating">
						<ul>
							<?php for ($i=1; $i <= 5; $i++) { ?>
								<?php if ($bid['rating'] < $i) { ?>
									<li><span class="fa-stack"><i class="far fa-star fa-stack-1x"></i></span></li>
								<?php } else { ?>
									<li><span class="fa-stack">
										<i class="fas fa-star fa-stack-1x"></i></span></li>
									<?php } ?>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<!-- Bid -->
				<div class="bids-bid">
					<div class="bid-rate">
						<div class="rate"><?php echo $bid['quote']; ?></div>
						<span><?php echo $bid['delivery']; ?></span>
					</div>
				</div>
			</div>
		</li><!--./Bid End  -->
	<?php } ?>	
</ul>
<?php echo $pagination; ?>
</div>
<?php } ?>