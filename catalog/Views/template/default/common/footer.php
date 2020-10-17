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
<?php if ($new_project_alert) { ?>
<script type="text/javascript">
$(document).ready(function() {
$.notify({
	// options
	icon: 'glyphicon glyphicon-warning-sign',
	title: 'Bootstrap notify',
	message: 'test',
	url: 'https://github.com/mouse0270/bootstrap-notify',
	target: '_blank'
},{
	// settings
	element: 'body',
	position: null,
	type: "info",
	allow_dismiss: true,
	newest_on_top: false,
	showProgressbar: false,
	placement: {
		from: "top",
		align: "right"
	},
	offset: 20,
	spacing: 10,
	z_index: 1031,
	delay: 5000,
	timer: 1000,
	url_target: '_blank',
	mouse_over: null,
	animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	},
	onShow: null,
	onShown: null,
	onClose: null,
	onClosed: null,
	icon_type: 'class',
	template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
		'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
		'<span data-notify="icon"></span> ' +
		'<span data-notify="title">{1}</span> ' +
		'<span data-notify="message">{2}</span>' +
		'<div class="progress" data-notify="progressbar">' +
			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
		'</div>' +
		'<a href="{3}" target="{4}" data-notify="url"></a>' +
	'</div>' 
});
});
</script>
<?php } ?>
</body>
</html>