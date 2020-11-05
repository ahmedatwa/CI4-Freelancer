<?php echo $header; ?><?php echo $dashboard_menu; ?>
	<!-- Dashboard Content -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			<div class="dashboard-headline">
				<h3>Messages</h3>
			</div>
			<div class="container">
				<div class="messages-container margin-top-0">
					<div class="messages-container-inner">
						<!-- Messages -->
						<div class="messages-inbox">
							<!-- Customer Online -->
							
 							<div class="nav flex-column nav-pills" id="online-list" role="tablist" aria-orientation="vertical">
							<?php foreach ($members as $member) { ?>
							<?php if ($customer_id != $member['receiver_id']) { ?>
  							<a class="nav-link text-dark" id="v-pills-<?php echo $member['receiver_id']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $member['receiver_id']; ?>" role="tab" aria-controls="v-pills-<?php echo $member['receiver_id']; ?>" aria-selected="true" onClick="openChat(<?php echo $member['receiver_id']; ?>, <?php echo $member['sender_id']; ?>);"> 
  								<div class="message-avatar">
  									<?php if ($member['online']) { ?>
  									<i class="fas fa-circle green"></i>
  								<?php } else { ?>
  									<i class="fas fa-circle"></i>
  								<?php } ?>
  								<img src="<?php echo $member['image']; ?>"> 
  									<?php echo $member['receiver']; ?>
  								</div>	
  								
  								</a>
							<?php } ?>
						<?php } ?>
							</div>
						</div>
						<!-- Messages / End -->

						<!-- Message Content -->
						<div class="message-content">
							<div class="messages-headline">
							</div>
							<!-- Message Content Inner -->
							<div class="message-content-inner " id="message-content">
								<div class="col-12 m-4">
								<div class="tab-content" id="v-pills-tabContent" style="overflow: scroll;height: 350px"></div>
								</div>	
							</div>	
							<form enctype="multipart/form-data" method="post" action="" id="form-message" accept-charset="utf-8" > 
								<div class="message-reply">
									<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
									<input type="hidden" name="receiver_id" value="" id="input-receiver-id" />
									<input type="hidden" name="sender_id" value="" id="input-sender-id" />
									<textarea cols="1" rows="1" placeholder="Your Message" name="message" id="input-message" class="form-control"></textarea>
									<button class="button ripple-effect" type="button" id="button-send">Send</button>
								</div> <!-- message-reply -->
							</form> 
						</div>
						<!-- Message Content -->
					</div>
			</div>
			<!-- Messages Container / End -->
			</div>
		</div>
	</div>

<!-- Scripts -->
<script type="text/javascript">
// Enable pusher logging - don't include this in production
$(document).ready(function(){

	var pusher = new Pusher('b4093000fa8e8cab989a', {
      cluster: 'eu'
    });

	var channel = pusher.subscribe('chat-channel');

	channel.bind('my-event', function(data) {
		sendMessage(data);
	});

	function sendMessage(data) {

		if(data.sender_id == data.sender_id) {
			html = '<div class="message-time-sign">';
			html += '<span> ' + data.date_added + ' </span>'; 
			html += '</div>';
			html += ' <div class="message-bubble me">'; 
			html += '<div class="message-bubble-inner">'; 
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p> ' + data.message + ' </p></div>';
			html += '</div>';
			html += '<div class="clearfix"></div>';
			html += '</div>';
			$('#v-pills-tabContent #v-pills-' + data.receiver_id).append(html);
			$('#input-message').val("");
		} 
		 if(data.sender_id == data.sender_id) {
			html = '<div class="message-bubble">';
			html += '<div class="message-bubble-inner">';
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p>' + data.message + '</p></div>';
			html += '</div>'; 
			html += '<div class="clearfix"></div>'; 
			html += '</div>'; 
			$('#v-pills-tabContent #v-pills-' + data.sender_id).append(html);
		}
	}
	// trigger enter keydown
	$('.message-reply #input-message').on('keydown', function(e) {
		if ($(this).val() !== '') {
		if (e.keyCode == 13) {
		    $('#button-send').trigger('click');
		}
	}
    });

	// Send Message Form
	$('#button-send').on('click', function(){
	if ($('#input-message').val() !== '') {
	    $.ajax({
	      url: 'account/message/sendMessage',
	      type: 'post',
	      data:$("#form-message").serialize(),
	      success:function() { 
	      }    
	  	});
	    }
     });
	
});
</script>	

 <!-- Open the Chat Tab window -->
<script type="text/javascript">
 function openChat (receiver_id, sender_id) {

    $(".messages-headline").html('<h4></h4>');

    tab_content = '<div class="tab-pane fade show active" id="v-pills-'+receiver_id+'" role="tabpanel" aria-labelledby="v-pills-'+receiver_id+'-tab">';
	fetchChatHistory(sender_id, receiver_id);
	tab_content += '</div>';
    $("#v-pills-tabContent").html(tab_content);

    $("#form-message #input-receiver-id").val(receiver_id);
    $("#form-message #input-sender-id-id").val(sender_id);

}

$('#online-list a:first-child').trigger('click');


// get the chat history from DB
function fetchChatHistory (sender_id, receiver_id) {
    $.ajax({
      url: 'account/message/getChatHistory?receiver_id=' + receiver_id + '&sender_id=' + sender_id,
      dataType:'json',
      beforeSend: function() {
      	$('#v-pills-tabContent').html('<i class="fas fa-spinner fa-spin"></i>');	
      },
      complete: function() {
      	$('.fas').remove();
      },
      success:function(json) { 

      	var html = '';

        $.map(json, function(val, i) {
      		     	
      	if (json[i].sender_id == <?php echo $customer_id; ?>) {
      		html = '<div class="message-time-sign">';
			html += '<span> ' + json[i].date_added + ' </span>'; 
			html += '</div>';
          	html += '<div class="message-bubble me">';							
			html += '<div class="message-bubble-inner">';							
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';	
			html += '<div class="message-text"><p>'+json[i].message+'</p></div>';	
			html += '</div>'
			html += '<div class="clearfix"></div>';
			html += '</div>';		
	    } 
	    if (json[i].sender_id != <?php echo $customer_id; ?>) {
			html += '<div class="message-bubble">';
			html += '<div class="message-bubble-inner">';
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p>'+json[i].message+'</p></div>';
			html += '</div>';
			html += '<div class="clearfix"></div>';
			html += '</div>';
	    }  // else 
          $('#v-pills-' + receiver_id).append(html);
         markRead(json[i].message_id);
	});
   } // success  
 });
}


function markRead(message_id) {
  $.ajax({
      url: 'account/message/markRead?message_id=' + message_id,
      dataType: 'json',
      success: function(json) {
      	console.log('ok');
      }
  });
}

</script>

<?php echo $footer; ?>
