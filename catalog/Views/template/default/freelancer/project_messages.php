<?php if ($project_messages) { ?>
<div class="header-notifications-content">
<div class="header-notifications-scroll" data-simplebar>
	<ul>
		<!-- Notification -->
		<li class="notifications-not-read">
			<?php foreach ($project_messages as $value) { ?>
			<a href="javascript:void(0)">
				<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
				<span class="notification-text">
					<?php if ($customer_id == $value['employer_id']) { ?>
					<strong>Your Message</strong> <?php echo $value['message']; ?> <span class="color"><?php echo $value['date_added']; ?></span> has been sent to
					 <strong><?php echo $value['freelancer'][0]; ?></strong>
				   <?php } else { ?> 
					<strong>Your Message</strong> <?php echo $value['message']; ?> <span class="color"><?php echo $value['date_added']; ?></span> has been sent to
					 <strong><?php echo $value['employer'][0]; ?></strong>
					<?php } ?> 
				</span>
			</a>
			<?php } ?> 
		</li>
	</ul>
</div>
</div>
<?php } else { ?>
	<div class="text-center"> No Messages for this project! </div>
<?php } ?>