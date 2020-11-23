<?php if ($bidders) { ?>
<div class="col-xl-12" id="bidders-wrapper">
	<div class="dashboard-box margin-top-0">
		<div class="content">
			<ul class="dashboard-box-list">
				<?php foreach ($bidders as $bidder) { ?>
					<li>
						<div class="freelancer-overview manage-candidates">
							<div class="freelancer-overview-inner">
								<div class="freelancer-avatar">
									<div class="verified-badge"></div>
									<a href="#"><img src="<?php echo $bidder['image']; ?>" alt=""></a>
								</div>
								<div class="freelancer-name">
									<h4><a href="<?php echo $bidder['profile']; ?>"><?php echo $bidder['freelancer']; ?> <img class="flag" src="images/flags/de.svg" alt="" title="Germany" data-placement="top" data-toggle="tooltip"></a></h4>
									<span class="freelancer-detail-item"><a href="#"><i class="icon-feather-mail"></i> <?php echo $bidder['email']; ?></a></span>
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
										<ul class="dashboard-task-info bid-info">
											<li><strong><?php echo $bidder['price']; ?></strong><span><?php echo $bidder['type']; ?></span></li>
											<li><strong><?php echo $bidder['delivery']; ?></strong><span>Delivery Time</span></li>
										</ul>
										<div class="buttons-to-right always-visible margin-top-25 margin-bottom-0" id="bidders-button-wrapper">
											<?php if ($bidder['isSelected']) { ?>
												<button type="button" id="award-freelancer-button" class="btn btn-success btn-sm" disabled><i class="icon-material-outline-check"></i>Awarded</button>
											<?php } else { ?>
												<button type="button" id="award-freelancer-button" class="btn btn-danger btn-sm" onclick="awardFreelancer(<?php echo $bidder['freelancer_id']; ?>, <?php echo $bidder['bid_id']; ?>);" ><i class="icon-material-outline-check"></i>Award Freelancer</button>
											<?php } ?>
											<button type="button" class="btn btn-dark btn-sm" onclick="sendMessage(<?php echo $customer_id; ?>, <?php echo $bidder['freelancer_id']; ?>);"><i class="icon-feather-mail"></i> Send Message</button>
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
<?php } else { ?>
<div class="d-flex justify-content-center">
    <p class="text-center">No Bids for this project!</p>
</div>
<?php } ?> 
<!-- // Award the Freelancer  -->
<script type="text/javascript">
function awardFreelancer(freelancer_id, bid_id) {
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
    callback: function (result) {
    if (result) {
         $.ajax({
            url: 'employer/project/awardWinner?pid=<?php echo $project_id; ?>',
            dataType: 'json',
            method: 'post',
            data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'freelancer_id': freelancer_id, 'bid_id': bid_id, 'project_id' :  <?php echo $project_id; ?>},
            beforeSend: function() {
                $('.text-danger, .alert').remove();
            },
            success: function(json) {
               if (json['success']) {
                    $('#bids').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    // Reload the Bids Tab
                    $('#bids-list').load('employer/project/bids?pid=<?php echo $project_id; ?>');                     
                }  
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
         });
      } 
    } 
   });
}
</script>
<!-- Send message -->
<script type="text/javascript">
function sendMessage(sender_id, receiver_id, project_id) {
   bootbox.prompt({
    title: 'Send A Message',
    message: "",
    className: 'animate__animated animate__fadeInDown',
    inputType: 'textarea',
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
    callback: function (result) {
      $('.bootbox-input-textarea').removeClass('is-invalid')
      $('.is-invalid, .invalid-feedback').remove();
    if (result === '') {
		$(this).find('.modal-body .bootbox-input-textarea').addClass('is-invalid');
        $(this).find('.modal-body .bootbox-input-textarea').after('<div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> The comment field is required.</div>'); 
        return false;
	} else {
         $.ajax({
            url: 'account/message/sendMessage?pid=' + project_id,
            dataType: 'json',
            method: 'post',
            data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'sender_id': sender_id, 'receiver_id': receiver_id, 'message': $('.bootbox-input-textarea').val(), 'project_id': project_id},
            beforeSend: function() {
                $('.text-danger, .alert, .is-invalid, .invalid-feedback').remove();
            },
            complete: function() {

            },
            success: function(json) {
                if (json['error']) {
                    $('textarea[name=\'message\']').after('<p class="text-danger">' + json['error'] + '</p>')
                }

                if (json['success']) {
                  $('#bids').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                  $('#messages').load('account/message/getProjectMessages?pid=' +project_id+ '&customer_id=<?php echo $customer_id; ?>');
                  $('#send-message-modal-form').trigger('reset');
                }                        
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
      } 
    } 
   });
}
</script>