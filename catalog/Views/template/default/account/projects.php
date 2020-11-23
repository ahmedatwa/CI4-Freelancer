<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded border">
	<div class="dashboard-content-inner">
		<!-- Dashboard Headline -->
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
			<!-- Dashboard Box -->
			<div class="col-xl-12">
				<div class="tab-content mt-4" id="myTabContent">
					<div class="tab-pane fade show active" id="employer" role="tabpanel" aria-labelledby="employer-tab">
						<ul class="nav nav-tabs mb-4" id="employerTab" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="openprojects-tab" data-toggle="tab" href="#open-projects" data-status-id= "8,6" role="tab" aria-controls="openprojects" aria-selected="true">Open Projects</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="workinprogress-tab" data-toggle="tab" href="#in-progress" role="tab" data-status-id= "4" aria-controls="workinprogress" aria-selected="false">Work in progress</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="pastprojects-tab" data-toggle="tab" href="#past-projects" role="tab" data-status-id= "5,7,1,2" aria-controls="pastprojects" aria-selected="false">Past projects</a>
							</li>
						</ul>
						<div class="tab-content" id="employerTabContent">
							<div class="tab-pane fade" id="open-projects" role="tabpanel" aria-labelledby="openprojects-tab">
								<div id="employer-open-list"></div>
							</div> <!-- openprojects-tab -->
							<div class="tab-pane fade" id="in-progress" role="tabpanel" aria-labelledby="workinprogress-tab">
								<div id="employer-progress-list"></div>
							</div> <!-- workinprogress-tab --> 
							<div class="tab-pane fade" id="past-projects" role="tabpanel" aria-labelledby="pastprojects-tab">
								<div id="employer-past-list"></div>
							</div>
						</div> <!-- pastprojects-tab -->
					</div> 
				<!--========== tab-employer END ==========-->
				<div class="tab-pane fade" id="freelancer" role="tabpanel" aria-labelledby="freelancer-tab">
				<ul class="nav nav-tabs mb-4" id="freelancerTab" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="freelancer-bids-tab" data-toggle="tab" href="#freelancer-bids" role="tab" aria-controls="freelancer-bids" aria-selected="false">Active Bids</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="workinprogress-tab" data-toggle="tab" href="#freelancer-in-progress" role="tab" data-status-id= "8" aria-controls="freelancer-in-progress" aria-selected="false">Work in progress</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="pastprojects-tab" data-toggle="tab" href="#freelancer-past-projects" role="tab" data-status-id= "5,7,1,2" aria-controls="pastprojects" aria-selected="false">Past projects</a>
							</li>
 						</ul>
 						<div class="tab-content" id="freelancerTabContent">
 						<div class="tab-pane fade" id="freelancer-bids" role="tabpanel" aria-labelledby="freelancer-bids-tab">
 							<div id="freelancer-bids-list"></div>
 						</div>
						<div class="tab-pane fade" id="freelancer-in-progress" role="tabpanel" aria-labelledby="freelancer-in-progress-tab">
							<div id="freelancer-progress-list"></div>
						</div>
						<div class="tab-pane fade" id="freelancer-past-projects" role="tabpanel" aria-labelledby="freelancer-past-projects-tab">
							<div id="freelancer-past-list"></div>
						</div>
                       </div>

				</div> <!-- tab-freelancer -->
				</div> <!-- tab-content -->
				</div>
			</div>
			<!-- Row / End -->
		</div>
	</div>

<!-- // Employer  -->
<script type="text/javascript">
$('#employerTab #openprojects-tab').on('click', function (e) {
	$.ajax({
		url: 'employer/Project/getOpenProjects',
		dataType: 'html',
		beforeSend: function() {
			$('#employer-open-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#employer-open-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#employer-open-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#employer-open-list').fadeOut('slow');
	$('#employer-open-list').load(this.href);
	$('#employer-open-list').fadeIn('slow');
});

// Employer In-progress List
$('#employerTab #workinprogress-tab').on('click', function (e) {
	$.ajax({
		url: 'employer/Project/getInProgressProjects',
		dataType: 'html',
		beforeSend: function() {
			$('#employer-progress-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#employer-progress-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#employer-progress-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#employer-progress-list').fadeOut('slow');
	$('#employer-progress-list').load(this.href);
	$('#employer-progress-list').fadeIn('slow');
 });

// Employer Past List
$('#employerTab #pastprojects-tab').on('click', function (e) {
	$.ajax({
		url: 'employer/Project/getPastProjects',
		dataType: 'html',
		beforeSend: function() {
			$('#employer-past-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#employer-past-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#employer-past-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#employer-past-list').fadeOut('slow');
	$('#employer-past-list').load(this.href);
	$('#employer-past-list').fadeIn('slow');
});

// Select first tab
$('#employerTab li:first-child a').tab('show');
$('#employerTab li:first-child a').trigger('click');
</script>

<!-- Freelancer Part Start -->
<script type="text/javascript">
$('#freelancerTab #freelancer-bids-tab').on('click', function () {
 $.ajax({
    url: 'freelancer/project/getFreelancerBids?customer_id=<?php echo $customer_id; ?>',
    dataType: 'html',
    beforeSend: function() {
    	$('#freelancer-bids-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
    },
    complete: function() {
         $('#spinner').remove();
    },
    success: function(html) {
        $('#freelancer-bids-list').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
});

// Employer In-progress List
$('#freelancerTab #workinprogress-tab').on('click', function (e) {
	$.ajax({
		url: 'freelancer/Project/getInProgressProjects',
		dataType: 'html',
		beforeSend: function() {
			$('#freelancer-progress-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#freelancer-progress-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#freelancer-progress-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#freelancer-progress-list').fadeOut('slow');
	$('#freelancer-progress-list').load(this.href);
	$('#freelancer-progress-list').fadeIn('slow');
 });

// Freelancer Past Projects
$('#freelancerTab #pastprojects-tab').on('click', function (e) {
	$.ajax({
		url: 'freelancer/Project/getPastProjects',
		dataType: 'html',
		beforeSend: function() {
			$('#freelancer-past-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#freelancer-past-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

$('#freelancer-past-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#freelancer-past-list').fadeOut('slow');
	$('#freelancer-past-list').load(this.href);
	$('#freelancer-past-list').fadeIn('slow');
});

// Select first tab
$('#freelancerTab li:first-child a').tab('show');
$('#freelancerTab li:first-child a').trigger('click');
</script>
<?php echo $footer; ?>