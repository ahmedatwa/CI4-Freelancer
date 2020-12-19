<?php echo $header; ?><?php echo $dashboard_menu ;?>
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded border">
	<div class="dashboard-content-inner">
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
			<ul class="nav nav-pills float-right" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="employer-tab" data-toggle="tab" href="#employer" role="tab" aria-controls="employer" aria-selected="true">Employer</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="freelancer-tab" data-toggle="tab" href="#freelancer" role="tab" aria-controls="freelancer" aria-selected="false">Freelancer</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<div class="tab-content mt-4" id="myTabContent">
					<div class="tab-pane fade show active" id="employer" role="tabpanel" aria-labelledby="employer-tab">
						<div id="employer-dispute-list"></div>
					</div> 
					<div class="tab-pane fade" id="freelancer" role="tabpanel" aria-labelledby="freelancer-tab">
						<div id="freelancer-dispute-list"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- // Employer  -->
<script type="text/javascript">
$('#myTab #employer-tab').on('click', function (e) {
	$.ajax({
		url: 'employer/employer/getDisputes?employer_id=<?php echo $customer_id; ?>',
		dataType: 'html',
		beforeSend: function() {
			$('#employer-dispute-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#employer-dispute-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#employer-dispute-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#employer-dispute-list').fadeOut('slow');
	$('#employer-dispute-list').load(this.href);
	$('#employer-dispute-list').fadeIn('slow');
});

$('#myTab #freelancer-tab').on('click', function (e) {
	$.ajax({
		url: 'freelancer/freelancer/getDisputes?freelancer_id=<?php echo $customer_id; ?>',
		dataType: 'html',
		beforeSend: function() {
			$('#freelancer-dispute-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#freelancer-dispute-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#freelancer-dispute-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#freelancer-dispute-list').fadeOut('slow');
	$('#freelancer-dispute-list').load(this.href);
	$('#freelancer-dispute-list').fadeIn('slow');
});

// Select first tab
$('#myTab li:first-child a').tab('show');
$('#myTab li:first-child a').trigger('click');

</script>
<?php echo $footer; ?>