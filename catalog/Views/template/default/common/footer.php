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
											<a href="<?php echo $facebook; ?>" data-toggle="tooltip" title="Facebook" data-placement="bottom">
												<i class="icon-brand-facebook-f"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo $twitter; ?>" data-toggle="tooltip" title="Twitter" data-placement="bottom">
												<i class="icon-brand-twitter"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo $instagram; ?>" data-toggle="tooltip" title="Instagram" data-placement="bottom">
												<i class="icon-brand-instagram"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo $linkedin; ?>" data-toggle="tooltip" title="LinkedIn" data-placement="bottom">
												<i class="icon-brand-linkedin-in"></i>
											</a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							
							<div class="footer-row">
								<div class="footer-row-inner language-switcher">
									<select class="custom-select">
										<option selected>English</option>
									</select>
								</div>
							</div>
							<div class="footer-row">
							<div class="footer-row-inner language-switcher">
							<?php echo $currency; ?>
						</div>
					   </div>
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
				<div class="col-md-4">
					<div class="footer-links">
						<h3><?php echo $text_freelancer; ?></h3>
						<ul>
							<li><a href="<?php echo $categorys; ?>"><span><?php echo $text_categories; ?></span></a></li>
							<li><a href="<?php echo $projects; ?>"><span><?php echo $text_projects; ?></span></a></li>
							<li><a href="<?php echo $freelancers; ?>"><span><?php echo $text_freelancers; ?></span></a></li>
							
						</ul>
					</div>
				</div>

				<!-- Links -->
				<div class="col-md-4">
					<div class="footer-links">
						<h3><?php echo $text_terms; ?></h3>
						<ul>
							<?php foreach ($informations as $information) { ?>
								<li><a href="<?php echo $information['href']; ?>"><span><?php echo $information['title']; ?></span></a></li>
							<?php } ?>	
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
<!-- Footer / End -->

<script type="text/javascript">
$(document).ready(function() {
  var pusher = new Pusher('b4093000fa8e8cab989a', {
      cluster: 'eu'
    });

  var channel = pusher.subscribe('global-channel');

  channel.bind('new-project-event', function(data) {
    $.notify({
	// options
	icon: 'glyphicon glyphicon-warning-sign',
	title: data.name,
	message: data.budget,
	url: data.href,
	target: '_blank'
},{
	// settings
	newest_on_top: true,
	placement: {
		from: "bottom",
		align: "right"
	},
	offset: 20,
	spacing: 10,
	z_index: 1031,
	delay: 8000,
	timer: 1000,
	animate: {
		enter: 'animate__animated animate__fadeInLeftBig',
		exit: 'animate__animated animate__fadeInDownBig'
	},
	
   });
  });
});
</script>
</body>
</html>