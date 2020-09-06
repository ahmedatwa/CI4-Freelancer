<?php echo $header;?><?php echo $menu;?>
<main>
		<div class="hero_single inner_pages background-image" data-background="url(img/home_section_1.jpg)">
			<div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-9 col-lg-10 col-md-8">
							<h1><?php echo $heading_title; ?></h1>
							<p>A successful Freelancer experience</p>
						</div>
					</div>
					<!-- /row -->
				</div>
			</div>
		</div>
		<!-- /hero_single -->

		<div class="bg_gray">
		    <div class="container margin_60_40">
		        <div class="row justify-content-md-center">
		            <div class="col-lg-6">
		                <div class="box_contacts">
		                    <h2><i class="fas fa-life-ring"></i> <?php echo $text_help_center; ?></h2>
							<small><?php echo $text_help; ?></small>
		                </div>
		            </div>
		            <div class="col-lg-6">
		                <div class="box_contacts">
		                    <h2><i class="fas fa-map-marker-alt"></i> <?php echo $text_address; ?></h2>
		                    <div><?php echo $address; ?></div>
		                    <small><?php echo $open; ?></small>
		                </div>
		            </div>
		        </div>
		        <!-- /row -->
		    </div>
		    <!-- /container -->
		</div>
		<!-- /bg_gray -->

		<div class="container margin_60_40">
		    <h5 class="mb_5">Drop Us a Line</h5>
		    <div class="row">
		        <div class="col-lg-4 col-md-6 add_bottom_25">
		            <div id="message-contact"></div>
		            <form method="post" action="assets/contact.php" id="contactform" autocomplete="off">
					    <div class="form-group">
					        <input class="form-control" type="text" placeholder="Name" id="name_contact" name="name_contact">
					    </div>
					    <div class="form-group">
					        <input class="form-control" type="email" placeholder="Email" id="email_contact" name="email_contact">
					    </div>
					    <div class="form-group">
					        <textarea class="form-control" style="height: 150px;" placeholder="Message" id="message_contact" name="message_contact"></textarea>
					    </div>
					    <div class="form-group">
					        <input class="btn_1 full-width" type="submit" value="Submit" id="submit-contact">
					    </div>
					</form>
				</div>
		        <div class="col-lg-8 col-md-6 add_bottom_25">
				<div id="map"></div>
		        </div>
		    </div>
		</div>
		<!-- /container -->

	</main>
	<!-- /main -->
<?php echo $footer;?>
<script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: -25.344, lng: 131.036};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
</script>
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdVw13RlcaeCfkTtJQhQRXiN6XsXTsRi0&callback=initMap">
</script>