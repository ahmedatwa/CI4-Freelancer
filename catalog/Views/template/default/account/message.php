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
							<?php foreach ($active_members as $member) { ?>	

  							<a class="nav-link text-dark" id="v-pills-<?php echo $member['customer_id']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $member['customer_id']; ?>" role="tab" aria-controls="v-pills-<?php echo $member['customer_id']; ?>" aria-selected="true" onClick="openChat(<?php echo $member['customer_id']; ?>, '<?php echo $member['username']; ?>');"><?php echo $member['username']; ?></a>
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
									<input type="hidden" name="to_id" value="" id="input-to-id" />
									<input type="hidden" name="to_name" value="" id="input-member-name" />
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
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript">
// Enable pusher logging - don't include this in production
$(document).ready(function(){
	Pusher.log = function(message) {
		if (window.console && window.console.log) {
			window.console.log(message);
		}
	};

	var pusher = new Pusher('b4093000fa8e8cab989a', {
      cluster: 'eu'
    });

	var channel = pusher.subscribe('chat-channel');

	channel.bind('my-event', function(data) {
		sendMessage(data);
	});
	// People Online
	channel.bind('online-event', function(data) {
		peopleOnline(data);
	});

function peopleOnline(data){
	var message  = data.message;				
		html = '<li class="active-message">';
		html += '<a class="nav-link active" id="v-pills-' + data.customer_id + '-tab" data-toggle="pill" href="#v-pills-' + data.customer_id + '" role="tab" aria-controls="v-pills-profile" aria-selected="false">';
		html += ' <div class="message-avatar"><i class="status-icon status-offline"></i><img src="images/catalog/avatar.jpg" alt="" /></div>';
		html += ' <div class="message-by">';
		html += ' <div class="message-by-headline">';
		html += ' <h5>' + data.from_username + '<span class="badge badge-pill badge-primary">'+ message.length +'</span></h5>';
		html += ' <span> ' + data.date_added + ' </span>';
		html += ' </div>';
		html += '<p>' + data.message + '</p>';
		html += '</div></a></li>';

		$('#online-list').append(html);
	}

	function sendMessage(data) {

		if(data.from_id == <?php echo $customer_id;?>) {
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
			$('#v-pills-tabContent #v-pills-' + data.to_id).append(html);
			$('#input-message').val("");
		} else {
			html = '<div class="message-bubble">';
			html += '<div class="message-bubble-inner">';
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p>' + data.message + '</p></div>';
			html += '</div>'; 
			html += '<div class="clearfix"></div>'; 
			html += '</div>'; 
			$('#v-pills-tabContent #v-pills-' + data.from_id).append(html);
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
 function openChat (to_id, to_username) {
 	var from_id = <?php echo $customer_id; ?>;
    $(".messages-headline").html('<h4 >' + to_username + '</h4>');

    tab_content = '<div class="tab-pane fade show active" id="v-pills-'+to_id+'" role="tabpanel" aria-labelledby="v-pills-'+to_id+'-tab">';
	fetchChatHistory(from_id, to_id);
	tab_content += '</div>';
    $("#v-pills-tabContent").html(tab_content);

    $("#form-message #input-to-id").val(to_id);
    $("#form-message #input-member-name").val(to_username);
}


$('#online-list a:first-child').trigger('click');


// get the chat history from DB
function fetchChatHistory (from_id, to_id) {
    $.ajax({
      url: 'account/message/getChatHistory?to_id=' + to_id + '&from_id=' + from_id,
      dataType:'json',
      beforeSend: function() {
      	$('#v-pills-tabContent').html('<i class="fas fa-spinner fa-spin"></i>');	
      },
      success:function(json) { 

      	for(var i = 0; json.length > i; i ++) {
      		     	
      	if (json[i].from_id == <?php echo $customer_id; ?>) {
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
	    if (json[i].to_id !== <?php echo $customer_id; ?>) {
			html += '<div class="message-bubble">';
			html += '<div class="message-bubble-inner">';
			html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
			html += '<div class="message-text"><p>'+json[i].message+'</p></div>';
			html += '</div>';
			html += '<div class="clearfix"></div>';
			html += '</div>';
	    }  // else 

		 $('#v-pills-' + json[i].to_id).append(html);
	   
		} // for loop 
      } // success  
  	});
}
</script>

<?php echo $footer; ?>
