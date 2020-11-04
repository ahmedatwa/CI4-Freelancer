	<div class="row">
	<?php if ($bids) { ?>	
		<?php foreach ($bids as $bid) { ?>
			<div class="col-6">
				<h3 class="job-listing-title"><a href="<?php echo $bid['href']; ?>"><?php echo $bid['name']; ?> <span class="badge badge-success"><?php echo $bid['status']; ?></span></a></h3>
			</div>
			<div class="col-4 text-center">
			<ul class="list-unstyled">	
				<li><i class="fas fa-long-arrow-alt-right"></i> <strong><?php echo $bid['quote']; ?></strong><span> Hourly Rate</span></li>
				<li><i class="fas fa-long-arrow-alt-right"></i> <strong><?php echo $bid['delivery']; ?> Days</strong><span> Delivery Time</span></li>
			</ul>
			</div>
			<div class="col-2 text-right">
				<?php if (! $bid['accepted']) { ?>
			<button type="button" class="btn btn-success btn-sm ripple-effect" id="button-offer-accept" data-toggle="tooltip" onclick="confirm('Are You Sure') ? acceptOffer(<?php echo $bid['project_id']; ?>) : false;" title="Accept Offer" data-placement="top"><i class="fas fa-check"></i></button>
		       <?php } else { ?>
			<button type="button" class="btn btn-success btn-sm disabled" data-toggle="tooltip" title="Accepted" data-placement="top"><i class="fas fa-check"></i></button>
		     <?php } ?>
			</div>	
		<?php } ?>
		<?php } else { ?>
			<p class="text-center w-100"> No Records! </p>
		<?php } ?>
	</div>
