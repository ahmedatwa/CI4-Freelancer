<?php echo $header; ?>

<!-- Dashboard Content
	================================================== -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			
			<!-- Dashboard Headline -->
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
                        <a class="nav-link" id="v-pills-<?php echo $member['receiver_id']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $member['receiver_id']; ?>" role="tab" aria-controls="v-pills-<?php echo $member['receiver_id']; ?>" aria-selected="true" onClick="openChat(<?php echo $member['receiver_id']; ?>, '<?php echo $member['receiver']; ?>');"><img src="<?php echo $member['image']; ?>"> <?php echo $member['receiver']; ?></a>
                   <?php } ?>     
                  </div>
                </div>
               
						<!-- Messages / End -->

						<!-- Message Content -->

				  <!-- Message Content -->
            <div class="message-content">
              <div class="messages-headline"></div>
              <!-- Message Content Inner -->
              <div class="message-content-inner" id="message-content">
                <div class="col-12 m-4">
                <div class="tab-content" id="v-pills-tabContent" style="overflow: scroll;height: 350px"></div>
                </div>  
              </div>  
              <form enctype="multipart/form-data" method="post" action="" id="form-message" accept-charset="utf-8" > 
                <div class="message-reply">
                  <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                  <input type="hidden" name="receiver_id" value="" id="input-receiver-id" />
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
        
    function scrollMsgBottom(){
      var d = $('.message-bubble');
                d.scrollTop(d.prop("scrollHeight"));
    }

        var conn = new WebSocket('ws://localhost:8080');
        
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        $('#button-send').on('click', function() {
          var message = $('#input-message').val();
          var receiver_id = $('');
            
            if (message.length == 0) {
            return;
            }

            var data = {
              sender_id: <?php echo $customer_id; ?>,
              message: message, 
            };

            conn.send(JSON.stringify(data));
            sendMessage(message);
            $('#input-message').val('')
        })

          // trigger enter keydown
        $('.message-reply #input-message').on('keydown', function(e) {
          if ($(this).val() !== '') {
            if (e.keyCode == 13) {
                $('#button-send').trigger('click');
            }
          }
        });

    conn.onmessage = function(e) {
        receiveMessage(e);
        //var data = JSON.parse(e.data);
        console.log(e.data);
              
              // if ('users' in data){
              //   updateUsers(data.users);
              // }
              // } else if('message' in data){
              //   newMessage(data)
              // }
    };

    function receiveMessage(e){
        html = '<div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">'; 
        html += '<div class="message-bubble">';
        html += ' <div class="message-bubble-inner">';
        html += '  <div class="message-avatar"><img src="images/user-avatar-small-02.jpg" alt="" /></div>';
        html += '   <div class="message-text"><p>'+ e.data +'</p></div>';
        html += '  </div>';
        html += ' <div class="clearfix"></div>';
        html += '</div>';
        html += '</div>';

        $('#messages').append(html);
          scrollMsgBottom();
    
    }

    function sendMessage(message){
        html = '<div class="message-bubble me">';
        html += ' <div class="message-bubble-inner">';
        html += '  <div class="message-avatar"><img src="images/user-avatar-small-01.jpg" alt="" /></div>';
        html += '   <div class="message-text"><p>' + message +'</p></div>';
        html += '  </div>';
        html += ' <div class="clearfix"></div>';
        html += '</div>';
                  
        $('#messages').append(html);

        scrollMsgBottom();
    }

// get Chat History
function openChat (receiver_id, receiver) {
  var sender_id = <?php echo $customer_id; ?>;
    $(".messages-headline").html('<h4 > '+ receiver +' </h4>');

    tab_content = '<div class="tab-pane fade show active" id="v-pills-' + receiver_id + '" role="tabpanel" aria-labelledby="v-pills-' + receiver_id + '-tab">';

    fetchChatHistory(sender_id, receiver_id);
    tab_content += '</div>';

    $("#v-pills-tabContent").html(tab_content);

    $("#form-message #input-receiver-id").val(receiver_id);
    //$("#form-message #input-receiver").val(receiver);
}


$('#online-list a:first-child').trigger('click');

// get the chat history from DB

function fetchChatHistory (sender_id, receiver_id) {
    $.ajax({
      url: 'account/inbox/getChatHistory?receiver_id=' + receiver_id + '&sender_id=' + sender_id,
      dataType:'json',
      beforeSend: function() {
        $('#v-pills-tabContent').html('<i class="fas fa-spinner fa-spin"></i>');  
      },
      complete: function() {
        $('.fa-spinner').remove();
      },
      success:function(json) { 
         html = "";
//console.log(json);
        //for(var i = 0; json.length > i; i ++) {
          $.map( json, function( val, i ) {
            console.log(json[i].sender_id);

          
          if (json[i].sender_id == sender_id ) {

              html = '<div class="message-time-sign">';
              html += '<span> ' + val.date_added + ' </span>'; 
              html += '</div>';
              html += '<div class="message-bubble me">';              
              html += '<div class="message-bubble-inner">';             
              html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>'; 
              html += '<div class="message-text"><p>'+ json[i].message +'</p></div>'; 
              html += '</div>'
              html += '<div class="clearfix"></div>';
              html += '</div>';   
          } else {
              html += '<div class="message-bubble">';
              html += '<div class="message-bubble-inner">';
              html += '<div class="message-avatar"><img src="images/catalog/avatar.jpg" alt="" /></div>';
              html += '<div class="message-text"><p>'+json[i].message+'</p></div>';
              html += '</div>';
              html += '<div class="clearfix"></div>';
              html += '</div>';

          }  // end if 

           
     
       //} // for loop 
       });
          $('#v-pills-' + receiver_id).append(html);

       
      } // success  
    });
}

</script>

<?php echo $footer; ?>
