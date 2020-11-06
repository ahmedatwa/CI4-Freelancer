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
					<a href="#" id="streetView">Street View</a>
				</div>
			</div>
		</div>
		<div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">
			<section class="margin-bottom-60">
				<h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us!</h3>

				<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="form-group row">
						<div class="input-group input-group-lg">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-account-circle"></i></span>
							</div>
							<input class="form-control" name="name" type="text" placeholder="Name" required="required" />
						</div>
					</div>
					<div class="form-group row">
						<div class="input-group input-group-lg">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-email"></i></span>
							</div>
							<input class="form-control" name="email" type="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />

						</div>
					</div>
					<div class="form-group row">
						<div class="input-group input-group-lg">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-assignment"></i></span>
							</div>
							<input class="form-control" name="subject" type="text" placeholder="Subject" required="required" />

						</div>
					</div>
					<div class="form-group row">
						<div class="input-group input-group-lg">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-account-circle"></i></span>
							</div>
							<textarea class="form-control" name="inquiry" cols="40" rows="7" placeholder="Message" spellcheck="true" required="required"></textarea>
						</div>
					</div>
					<input type="submit" class="submit button margin-top-15" id="submit" value="Submit Message" />

				</form>
			</section>
		</div>
	</div>
</div>
<?php echo $footer;?>
