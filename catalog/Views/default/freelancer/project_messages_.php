<div class="alert alert-info alert-dismissible fade show" role="alert">
  <i class="fas fa-info-circle"></i> <?php echo $help_messages; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php if ($project_messages) { ?>
	<div class="header-notifications-content">
		<div class="header-notifications-scroll">
			<span class="ml-4 float-right">
                <button type="button" class="btn btn-dark btn-sm" onclick="sendMessage(<?php echo $customer_id; ?>, <?php echo $sender_id; ?>);" data-toggle="tooltip" data-placement="top" title="Send Message"><i class="icon-feather-mail"> Send Message</i></button></span>
			<ul class="list-unstyled">
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
<!-- Send message -->
<script type="text/javascript">
function sendMessage(sender_id, receiver_id) {
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
            url: 'account/message/sendMessage?pid=' + <?php echo $project_id; ?>,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            method: 'post',
            data: {'sender_id': sender_id, 'receiver_id': receiver_id, 'message': $('.bootbox-input-textarea').val(), 'project_id': <?php echo $project_id; ?>},
            beforeSend: function() {
                $('.text-danger, .alert').remove();
            },
            complete: function() {

            },
            success: function(json) {
                if (json['success']) {
                    console.log('ok')
                  $('.header-notifications-content').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                  $('#messages #messages-list').load('account/message/getProjectMessages?pid=' +<?php echo $project_id; ?>+ '&customer_id=<?php echo $customer_id; ?>');
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