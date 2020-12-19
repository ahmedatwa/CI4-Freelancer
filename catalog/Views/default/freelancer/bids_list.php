<div class="row">
<?php if ($bids) { ?>	
	<?php foreach ($bids as $bid) { ?>
		<div class="col-6">
			<h3 class="job-listing-title"><a href="<?php echo $bid['href']; ?>"><?php echo $bid['name']; ?> 
			<?php if ($bid['status']) { ?>
			  <?php if($bid['status']) { ?><span class="badge badge-success"><?php echo $bid['status']; ?></span>
			<?php } ?>
		   <?php } ?>
		</a></h3>
		</div>
		<div class="col-4 text-center">
		<ul class="list-unstyled">	
			<li><i class="fas fa-long-arrow-alt-right"></i> <strong><?php echo $bid['quote']; ?></strong><span> Hourly Rate</span></li>
			<li><i class="fas fa-long-arrow-alt-right"></i> <strong><?php echo $bid['delivery']; ?> Days</strong><span> Delivery Time</span></li>
		</ul>
		</div>
		<div class="col-2 text-right">
		<?php if ($bid['selected'] && !$bid['accepted']) { ?>
		<button type="button" class="btn btn-danger btn-sm ripple-effect" id="button-offer-accept" data-toggle="tooltip" onclick="acceptOffer(<?php echo $bid['project_id']; ?>, <?php echo $bid['bid_id']; ?>, <?php echo $bid['employer_id']; ?>);" title="Accept Offer" data-placement="top"><i class="fas fa-check"></i></button>
	       <?php } elseif ($bid['accepted']) { ?>
		  <button type="button" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" title="Accepted" data-placement="top"><i class="fas fa-check"></i></button>
	     <?php } else {  ?>
	      <button type="button" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" title="Accepted" data-placement="top"><i class="fas fa-check"></i></button>
	     <?php } ?>
	     <button type="button" class="btn btn-dark btn-sm" data-toggle="tooltip" title="Send A Message" data-placement="top" onclick="sendMessage(<?php echo $customer_id; ?>, <?php echo $bid['employer_id']; ?>, <?php echo $bid['project_id']; ?>);"><i class="icon-feather-mail"></i></button>
		</div>	
	<?php } ?>
	<?php } else { ?>
		<p class="text-center w-100"> No Current Active Bids! </p>
	<?php } ?>
</div>

<script type="text/javascript">
// Freelancer to accept project offer
function acceptOffer(project_id, bid_id, employer_id) {
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
		url: 'freelancer/freelancer/acceptOffer?freelancer_id=<?php echo $customer_id; ?>&project_id=' + project_id + '&bid_id=' + bid_id + '&employer_id=' + employer_id,
		dataType: 'json',
		beforeSend: function() {
           $('#button-offer-accept').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
	    },
	    complete: function() {
	       $('#button-offer-accept').html('<i class="fas fa-check"></i>');
	    },
	    success: function(json) {
	        if (json['success']) {
	        // Reload the Bids Tab
	        $('#freelancer-bids-list').load('freelancer/project/getFreelancerBids?customer_id=<?php echo $customer_id; ?>');
	        $('#freelancer-bids-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
            url: 'account/message/sendMessage',
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