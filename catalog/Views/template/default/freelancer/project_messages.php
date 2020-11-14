<?php if ($project_messages) { ?>
	<div class="header-notifications-content">
		<div class="header-notifications-scroll">
			<span class="ml-4 float-right"><button type="button" id="send-message-button" class="btn btn-dark btn-sm" data-senderid="<?php echo $customer_id; ?>" data-receiverid="<?php echo $sender_id; ?>" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fas fa-reply"> Reply</i></button></span>
			<ul>
				<!-- Notification -->
				<?php foreach ($project_messages as $value) { ?>
					<li class="notifications-not-read my-2">
						<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
						<span class="notification-text">
							<?php if ($customer_id == $value['sender_id']) { ?>
								<strong><?php echo $value['message']; ?></strong>: to <strong><?php echo $value['receiver'][0]; ?></strong> at <span class="color"><?php echo $value['date_added']; ?></span>
							<?php } else { ?> 
								<p class="ml-4"> <strong><?php echo $value['message']; ?></strong>: from <strong><?php echo $value['sender'][0]; ?></strong> at <span class="color"><?php echo $value['date_added']; ?></span></p>
							<?php } ?> 
						</span>
					</li>
				<?php } ?> 
			</ul>
			
		</div>
	</div>
<?php } else { ?>
	<div class="text-center"> No Messages for this project! </div>
<?php } ?>