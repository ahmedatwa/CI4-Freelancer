<?php echo $header;?>
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $heading_title; ?></h2>
			</div>
		</div>
	</div>
</div>
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-xl-12">
			<div class="contact-location-info margin-bottom-50">
				<div class="contact-address">
					<ul>
						<li class="contact-address-headline">Our Office</li>
						<li><?php echo $address; ?></li>
						<li><?php echo $telephone; ?></li>
					</ul>
				</div>
				<div id="single-job-map-container">
					<div id="singleListingMap" data-latitude="37.777842" data-longitude="-122.391805" data-map-icon="im im-icon-Hamburger"></div>
				</div>
			</div>
		</div>
		<div class="col">
			<section class="margin-bottom-60">
				<h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us!</h3>
				<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-account-circle"></i></span>
								</div>
								<input class="form-control" name="name" type="text" required="required" />
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Email Address</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-email"></i></span>
								</div>
								<input class="form-control" name="email" type="email" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />

							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Subject</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-assignment"></i></span>
								</div>
								<input class="form-control" name="subject" type="text" required="required" />
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="formGroupExampleInput" class="col-sm-2 col-form-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="inquiry" cols="40" rows="7" spellcheck="true" required="required"></textarea>
						</div>
					</div>
					<div class="mx-auto text-right">
					<input type="submit" class="submit button margin-top-15" id="submit" value="Submit Message" />
				</div>
				</form>
			</section>
		</div>
	</div>
</div>
<!-- Google API & Maps -->
<!-- Geting an API Key: https://developers.google.com/maps/documentation/javascript/get-api-key -->
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"></script>
<script src="catalog/default/javascript/infobox.min.js"></script>
<script src="catalog/default/javascript/markerclusterer.js"></script>
<script src="catalog/default/javascript/maps.js"></script>

<?php echo $footer;?>
