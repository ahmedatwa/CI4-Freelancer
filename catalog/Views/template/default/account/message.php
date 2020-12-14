<?php echo $header; ?><?php echo $dashboard_menu; ?>
	<!-- Dashboard Content -->
	<div class="dashboard-content-container container">
		<section class="gray">
			<div class="dashboard-content-inner">
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
		</div>
		<div class="row">
				<div class="messages-container margin-top-0 w-100 border mb-4">
					<div class="messages-container-inner">
						<!-- Messages -->
						<div class="messages-inbox">
							<!-- Customer Online -->
 							<div class="nav flex-column nav-pills" id="online-list" role="tablist" aria-orientation="vertical">
							<?php foreach ($members as $member) { ?>
  							<a class="nav-link text-dark border-bottom rounded-0" id="v-pills-<?php echo $member['thread_id']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $member['thread_id']; ?>" role="tab" aria-controls="v-pills-<?php echo $member['thread_id']; ?>" aria-selected="true" onClick="openChat('<?php echo $member['thread_id']; ?>', <?php echo $member['receiver_id']; ?>, <?php echo $member['sender_id']; ?>);"> 
  							
  								<div class="message-avatar">
  									<?php if ($member['online']) { ?>
  										<span class="notification-avatar status-online"><img src="<?php echo $member['image']; ?>"></span>
  									<?php } else { ?>
  										<span class="notification-avatar status-offline"><img src="<?php echo $member['image']; ?>"></span>
  									<?php } ?>		
  								
  								<div class="notification-text">
  								<?php if ($customer_id != $member['receiver_id']) { ?>
  									<strong><?php echo $member['receiver']; ?></strong>
  								<?php } else {  ?>
  									<strong><?php echo $member['sender']; ?></strong>
  								<?php } ?> 
  								</div> 								
  								</div>	
  							
  								</a>
							
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
									<input type="hidden" name="receiver_id" id="input-receiver-id" />
									<input type="hidden" name="sender_id" id="input-sender-id" />
								    <input type="hidden" name="thread_id" id="input-thread-id" />
								    <div id="user-is-typing"></div>
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
		</section>
	</div>
<!-- Scripts -->
<script type="text/javascript">
// Enable pusher logging - don't include this in production
$(document).ready(function(){

	var pusher = new Pusher('b4093000fa8e8cab989a', {
      cluster: 'eu'
    });

	var channel = pusher.subscribe('chat-channel');

	channel.bind('chat-event', function(data) {
		sendMessage(data);
	});

	function sendMessage(data) {
		console.log(data)
		if(data.sender_id == <?php echo $customer_id; ?>) {
			html = '<div class="message-time-sign">';
			html += '<span> ' + new Date().toLocaleString(); + ' </span>'; 
			html += '</div>';
			html += ' <div class="message-bubble me">'; 
			html += '<div class="message-bubble-inner">'; 
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p> ' + data.message + ' </p></div>';
			html += '</div>';
			html += '<div class="clearfix"></div>';
			html += '</div>';
			$('#v-pills-tabContent #v-pills-' + data.thread_id).append(html);
			$('#input-message').val("");
			$(".tab-content").animate({ scrollTop: $(document).height() }, 1000);
		} 
		 if(data.sender_id != <?php echo $customer_id; ?>) {
			html = '<div class="message-bubble">';
			html += '<div class="message-bubble-inner">';
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p>' + data.message + '</p></div>';
			html += '</div>'; 
			html += '<div class="clearfix"></div>'; 
			html += '</div>'; 
			$('#v-pills-tabContent #v-pills-' + data.thread_id).append(html);
			$(".tab-content").animate({ scrollTop: $(document).height() }, 1000);
		}
	}

	//trigger enter keydown
	$('.message-reply #input-message').on('keydown', function(e) {
		if ($(this).val() !== '') {
			if (e.keyCode == 13) {
			    $('#button-send').trigger('click');
			}
	    }
    });
    
	//Send Message Form
	$('#button-send').on('click', function() {
		if ($('#input-message').val() !== '') {
		    $.ajax({
		      url: 'account/message/sendMessage',
		      type: 'post',
		      data:$("#form-message").serialize(),
		      success:function() {
		      	$('#input-message').val('');
		      }    
		  	});
		}
	});
 });    
</script>	

 <!-- Open the Chat Tab window -->
<script type="text/javascript">
 function openChat(thread_id, receiver_id, sender_id) {

    $(".messages-headline").html('<h4></h4>');

    tab_content = '<div class="tab-pane fade show active" id="v-pills-' + thread_id + '" role="tabpanel" aria-labelledby="v-pills-' + thread_id + '-tab">';

	fetchChatHistory(thread_id);

	tab_content += '</div>';

    $("#v-pills-tabContent").html(tab_content);

    $("#form-message #input-receiver-id").val(receiver_id);
    $("#form-message #input-sender-id").val(sender_id);
    $("#form-message #input-thread-id").val(thread_id);

}
</script>

<script type="text/javascript">
// get the chat history from DB
function fetchChatHistory (thread_id) {
    $.ajax({
      url: 'account/message/getChatHistory?thread_id=' + thread_id,
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
			html += '<div class="message-text"><p>'+json[i].message.text+'</p></div>';	
			html += '</div>'
			html += '<div class="clearfix"></div>';
			html += '</div>';		
	    } 
	    if (json[i].sender_id != <?php echo $customer_id; ?>) {
			html += '<div class="message-bubble">';
			html += '<div class="message-bubble-inner">';
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p>'+ json[i].message.text +'</p></div>';
			html += '</div>';
			html += '<div class="clearfix"></div>';
			html += '</div>';
	    }  // else 
          $('#v-pills-' + thread_id).append(html);
            markRead(json[i].message_id);
           	$(".tab-content").animate({ scrollTop: $(document).height() }, 1000);
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

<script type="text/javascript">
if (window.location.hash) {
	$('#online-list'+ window.location.hash.substring(1)).trigger('click');
} else {
	$('#online-list a:first-child').trigger('click');
}

var url = document.URL;
var hash = url.substring(url.indexOf('#'));


$(".nav-pills").find("a").each(function(key, val) {
    if (hash == $(val).attr('href')) {
        $(val).click();
    }
    
    $(val).click(function(ky, vl) {
        location.hash = $(this).attr('href');
    });
});
</script>
<?php echo $footer; ?>
