<?php foreach ($messages as $message) { ?>
       <ul class="list-unstyled"><li class="notifications-not-read my-2">
              <span class="notification-text">
                     <?php if ($message['sender_id']) { ?>
                      <strong><i class="icon-material-outline-group"></i> <strong><?php echo $message['sender']; ?></strong>: </strong> <?php echo $message['message']; ?> <span class="color ml-2"><?php echo $message['date_added']; ?></span>
               <?php } else { ?>
                     <p> <i class="icon-material-outline-group"></i> <strong><?php echo $message['receiver']; ?></strong>: <strong><?php echo $message['message']; ?></strong> <span class="color ml-2"><?php echo $message['date_added']; ?></span></p>
              <?php } ?>
       </span>
       </li>
    </ul>

<?php } ?>
<form id="form-project-message">
       <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
       <input type="hidden" name="sender_id" value="<?php echo $customer_id; ?>">
       <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
       <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
       <div class="input-group">
              <textarea class="form-control" name="message" style="resize: none;"></textarea>
              <div class="input-group-append">
                     <button class="button ripple-effect" type="button" id="button-form-message-add">Send</button>
              </div>
       </div>
</form>
<!-- Send message -->
<script type="text/javascript">
  $('#button-form-message-add').on('click', function() {
       var node = this;
       $.ajax({
          url: 'account/message/sendMessage',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
            "X-Requested-With": "XMLHttpRequest"
          },
          dataType: 'json',
          method: 'post',
          data: $('#form-project-message').serialize(),
          beforeSend: function() {
              $(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
          },
          complete: function() {
              $(node).html('Send');
          },
          success: function(json) {
              if (json['error']) {
                 $.notify({icon: 'fas fa-exclamation-circle', message: json['error']},{type: 'danger'});
              }

              if (json['success']) {
                $('#project-info').after('<div class="alert alert-success alert-dismissible fade show mt-2" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                $('#v-pills-tabContent-projectMessages').load('account/message/getThreadMessages?thread_id=<?php echo $thread_id; ?>');
              }                        
          },
          error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
   });
});
</script>