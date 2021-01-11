<!-- Footer -->
<div id="footer">
	<!-- Footer Top Section -->
	<div class="footer-top-section">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<!-- Footer Rows Container -->
					<div class="footer-rows-container">
						<!-- Left Side -->
						<div class="footer-rows-left">
							<div class="footer-row">
								<div class="footer-row-inner footer-logo">
									<img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>">
								</div>
							</div>
						</div>
						<!-- Right Side -->
						<div class="footer-rows-right">
							<!-- Social Icons -->
							<div class="footer-row">
								<div class="footer-row-inner">
									<ul class="footer-social-links">
										<li>
											<a href="<?php echo $facebook; ?>" target="_blank" data-toggle="tooltip" title="Facebook" data-placement="bottom">
												<i class="icon-brand-facebook-f"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo $twitter; ?>" target="_blank" data-toggle="tooltip" title="Twitter" data-placement="bottom">
												<i class="icon-brand-twitter"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo $instagram; ?>" target="_blank" data-toggle="tooltip" title="Instagram" data-placement="bottom">
												<i class="icon-brand-instagram"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo $linkedin; ?>" target="_blank" data-toggle="tooltip" title="LinkedIn" data-placement="bottom">
												<i class="icon-brand-linkedin-in"></i>
											</a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>							
							<?php echo $language; ?>
							<?php echo $currency; ?>
						</div>
					</div>
					<!-- Footer Rows Container / End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Top Section / End -->
	<!-- Footer Middle Section -->
	<div class="footer-middle-section">
		<div class="container">
			<div class="row">
				<!-- Links -->
				<div class="col">
					<div class="footer-links">
						<h3><?php echo $text_freelancer; ?></h3>
						<ul>
							<li><a href="<?php echo $category; ?>"><span><?php echo $text_categories; ?></span></a></li>
							<li><a href="<?php echo $projects; ?>"><span><?php echo $text_projects; ?></span></a></li>
							<li><a href="<?php echo $freelancers; ?>"><span><?php echo $text_freelancers; ?></span></a></li>
							
						</ul>
					</div>
				</div>
				<!-- Links -->
				<div class="col">
					<div class="footer-links">
						<h3><?php echo $text_terms; ?></h3>
						<ul>
							<?php foreach ($informations as $information) { ?>
								<li><a href="<?php echo $information['href']; ?>"><span><?php echo $information['title']; ?></span></a></li>
							<?php } ?>	
							<li><a href="<?php echo $contact; ?>"><span><?php echo $text_contact; ?></span></a></li>
						</ul>
					</div>
				</div>
			   <div class="col">
					<div class="footer-links">
						<h3><?php echo $text_account; ?></h3>
						<ul>
							<li><a href="<?php echo $register; ?>"><span><?php echo $text_register; ?></span></a></li>
							<li><a href="<?php echo $login; ?>"><span><?php echo $text_login; ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Middle Section / End -->
	<!-- Footer Copyrights -->
	<div class="footer-bottom-section">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<?php echo $text_footer; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Copyrights / End -->
</div>
</div>
<!-- loader overlay -->
<div id="overlay">
	<div class="spinner"></div> Loading...
</div>
<!-- Gmail Sign in  -->
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
<script>
function onLoad() {
      gapi.load('auth2', function() {
        gapi.auth2.init();
      });
 }

function gSignOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut();
  }

</script>
<!-- singout button -->
<script type="text/javascript">
	$(document).on('click', '#button-logout', function(){
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}
				var auth2 = gapi.auth2.getAuthInstance();
				console.log(auth2)
    			
			}
		});
	});
</script>
<!-- New Project Global Alert -->

<script type="text/javascript">
var PUSHER_KEY = <?php echo PUSHER_KEY; ?>;
var PUSHER_CLUSTER = <?php echo PUSHER_CLUSTER; ?>;

var pusher = new Pusher(PUSHER_KEY, {
  cluster: PUSHER_CLUSTER
});

var channel = pusher.subscribe('global-channel');

channel.bind('new-project-event', function(data) {
if (<?php echo $customer_id; ?> != data.employer_id) {
$.notify({
   // options
	icon: 'fas fa-desktop',
	title: data.name,
	message: data.budget,
	url: data.href,
	target: '_blank'
    },{
	// settings
	newest_on_top: true,
	placement: {
		from: "bottom",
		align: "left"
	},
	offset: 20,
	spacing: 10,
	z_index: 1031,
	delay: 8000,
	timer: 1000,
	animate: {
		enter: 'animate__animated animate__fadeInUpBig',
		exit: 'animate__animated animate__fadeOutDownBig'
	},
  });
 }
});	
</script>
</body>
</html>