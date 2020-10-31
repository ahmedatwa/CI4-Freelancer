<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow p-3 mb-5 bg-white rounded">
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
								<a class="nav-link active" id="openprojects-tab" data-toggle="tab" href="#open-projects" data-status-id= "8,6" role="tab" aria-controls="openprojects" aria-selected="true">Open Projects</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="workinprogress-tab" data-toggle="tab" href="#in-progress" role="tab" data-status-id= "4" aria-controls="workinprogress" aria-selected="false">Work in progress</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="pastprojects-tab" data-toggle="tab" href="#past-projects" role="tab" data-status-id= "7" aria-controls="pastprojects" aria-selected="false">Past projects</a>
							</li>
 						</ul>
						<div class="tab-content" id="employerTabContent">
							<div class="tab-pane fade show active" id="open-projects" role="tabpanel" aria-labelledby="openprojects-tab">
							<table class="table table-striped table-bordered w-100" id="table-openprojects-tab">
							  <thead>
							    <tr>
							    	<th><?php echo $column_name; ?></th>
							    	<th><?php echo $column_budget; ?></th>
							    	<th><?php echo $column_type; ?></th>
							    	<th><?php echo $column_bids; ?></th>
							    	<th><?php echo $column_avg_bids; ?></th>
							    	<th><?php echo $column_expiry; ?></th>
							    	<th><?php echo $column_status; ?></th>
							    	<th><?php echo $column_action; ?></th></tr></thead>
							    </tr>
							  </thead>
							  </table>
				            </div> <!-- openprojects-tab -->
							<div class="tab-pane fade" id="in-progress" role="tabpanel" aria-labelledby="workinprogress-tab">
							<table class="table table-striped table-bordered w-100" id="table-workinprogress-tab">
							  <thead>
							    <tr>
							    	<th><?php echo $column_name; ?></th>
							    	<th><?php echo $column_budget; ?></th>
							    	<th><?php echo $column_type; ?></th>
							    	<th><?php echo $column_bids; ?></th>
							    	<th><?php echo $column_avg_bids; ?></th>
							    	<th><?php echo $column_expiry; ?></th>
							    	<th><?php echo $column_status; ?></th>
							    	<th><?php echo $column_action; ?></th>
							    </tr>
							  </thead>
							  </table>
							</div> <!-- workinprogress-tab --> 
							<div class="tab-pane fade" id="past-projects" role="tabpanel" aria-labelledby="pastprojects-tab">
							<table class="table table-striped table-bordered w-100" id="table-pastprojects-tab">
							  <thead>
							    <tr>
							    	<th><?php echo $column_name; ?></th>
							    	<th><?php echo $column_budget; ?></th>
							    	<th><?php echo $column_type; ?></th>
							    	<th><?php echo $column_bids; ?></th>
							    	<th><?php echo $column_avg_bids; ?></th>
							    	<th><?php echo $column_expiry; ?></th>
							    	<th><?php echo $column_status; ?></th>
							    	<th><?php echo $column_action; ?></th></tr></thead>
							    </tr>
							  </thead>
							  </table>
							</div> <!-- pastprojects-tab -->
						</div>
				</div> 
				<!-- 
				====================== =============
				========== tab-employer END ================
				===================== ==============
				-->
				<div class="tab-pane fade" id="freelancer" role="tabpanel" aria-labelledby="freelancer-tab">
				<ul class="nav nav-tabs mb-4" id="freelancerTab" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link active" id="freelancer-bids-tab" data-toggle="tab" href="#freelancer-bids" role="tab" aria-controls="freelancer-bids" aria-selected="false">Active Bids</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="freelancer-in-progress-tab" data-toggle="tab" href="#freelancer-in-progress" role="tab" data-status-id= "8" aria-controls="freelancer-in-progress" aria-selected="false">Work in progress</a>
							</li>
 						</ul>
 						<div class="tab-content" id="freelancerTabContent">
 						<div class="tab-pane fade show active" id="freelancer-bids" role="tabpanel" aria-labelledby="freelancer-bids-tab">
 							<div id="active-bids-list"></div>
 						</div>

						<div class="tab-pane fade" id="freelancer-in-progress" role="tabpanel" aria-labelledby="freelancer-in-progress-tab">
							<table class="table table-striped table-bordered w-100" id="table-freelancer-in-progress-tab">
							  <thead>
							    <tr>
							    	<th><?php echo $column_name; ?></th>
							    	<th><?php echo $column_budget; ?></th>
							    	<th><?php echo $column_type; ?></th>
							    	<th><?php echo $column_status; ?></th>
							    	<th><?php echo $column_action; ?></th></tr>
							    </tr>
							   </thead>

							</table>
						</div> <!-- workinprogress-tab --> 
                       </div>

				</div> <!-- tab-freelancer -->
				</div> <!-- tab-content -->
				</div>
			</div>
			<!-- Row / End -->
		</div>
	</div>
<link href="catalog/default/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript">
$('#employer a[data-toggle="tab"]').on('click', function (e) {
var status_id = $(this).attr('data-status-id');
var table = $('#table-' + $(this).attr('id')).DataTable();
table.destroy();

$('#table-' + $(this).attr('id')).DataTable({
'ajax': {
	'url': "freelancer/project/getProjects?cid=<?php echo $customer_id; ?>&status_id=" + status_id,
	'dataSrc': '',
    },
	"columns": [
            { "data": "name" },
            { "data": "budget" },
            { "data": "type" },
            { "data": "total_bids",
            "render": function(data, type, row, meta){
			   if(type === 'display'){
			          data = '<span class="badge badge-success">'+data+'</span>';
			      }
			      return data;
			    }
           },
            { "data": "avgBids" },
            { "data": "expiry" },
            { "data": "status"},
            { "data": "view",
            "render": function(data, type, row, meta){
			      if(type === 'display'){
			          data = '<a class="btn btn-primary btn-sm" data-toggle="tooltip" title="view" href="' + data + '"><i class="far fa-eye"></i></a>';
			          data = '<a class="btn btn-seondary btn-sm" data-toggle="tooltip" title="Pay" href=""><i class="far fa-money-bill-alt"></i></a>';
			      }
			      return data;
			    }
           },
        ],
	'order': [[1, 'asc']],
	'processing': true,
	"bDestroy": true
  });
});

$('#employer li:first-child a').trigger('click') // Select first tab
</script>	

<!-- // Freelancer  -->
<script type="text/javascript">
	$('#freelancer a[data-toggle="tab"]').on('click', function (e) {
	 var status_id = $(this).attr('data-status-id');
	 var table = $('#table-' + $(this).attr('id')).DataTable();

	$('#table-' + $(this).attr('id')).DataTable({
	'ajax': {
		'url': "freelancer/project/getFreelancerProjects?cid=<?php echo $customer_id; ?>",
		'dataSrc': '',
	    },
		"columns": [
	            { "data": "name" },
	            { "data": "budget" },
	            { "data": "type" },
	            { "data": "status"},
	            { "data": "view",
	            "render": function(data, type, row, meta){
				      if(type === 'display'){
				          data = '<a class="btn btn-primary btn-sm" data-toggle="tooltip" title="view" href="' + data + '"><i class="far fa-eye"></i></a>';
				      }
				      return data;
				    }
	           },
	        ],
		'order': [[1, 'asc']],
		'processing': true,
		"bDestroy": true
	  });
	});


$('#freelancer li:first-child a').trigger('click') // Select first tab


$('#freelancer a[href="#freelancer-bids"]').on('click', function () {
 $.ajax({
    url: 'freelancer/freelancer/getFreelancerBids?customer_id=<?php echo $customer_id; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('#active-bids-list').html('<p id="loader-div" class="text-center"><i class="fas fa-spinner fa-spin fa-lg"></i> Retrieving Data...</p>');
    },
    complete: function() {
        $('#loader-div').remove();
    },
    success: function(html) {
        $('#active-bids-list').html(html);

    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
});

$('#freelancer a[href="#freelancer-bids').trigger('click') // Select first tab


function acceptOffer(project_id) {
	$.ajax({
		url: 'freelancer/freelancer/acceptOffer?freelancer_id=<?php echo $customer_id; ?>&project_id=' + project_id,
		dataType: 'json',
		beforeSend: function() {
           $('#button-offer-accept').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
	    },
	    complete: function() {
	       $('#button-offer-accept').html('<i class="fas fa-check"></i>');
	    },
	    success: function(json) {

	        if (json['success']) {
	        	$.notify({
                icon: 'fas fa-check-circle',
                title: 'Success',
                message: json['success']
	            },{
	             animate: {
	                enter: 'animate__animated animate__lightSpeedInRight',
	                exit: 'animate__animated animate__lightSpeedOutRight'
	            },
               type: 'success'
             });
	        }

	    },
	    error: function(xhr, ajaxOptions, thrownError) {
	        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	    }

		});
    }


</script>	
<?php echo $footer; ?>