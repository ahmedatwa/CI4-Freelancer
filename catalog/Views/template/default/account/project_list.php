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
								<a class="nav-link active" id="openprojects-tab" data-toggle="tab" href="#open-projects" data-status-id= "8" role="tab" aria-controls="openprojects" aria-selected="true">Open Projects</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="workinprogress-tab" data-toggle="tab" href="#in-progress" role="tab" data-status-id= "4" aria-controls="workinprogress" aria-selected="false">Work in progress</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="pastprojects-tab" data-toggle="tab" href="#past-projects" role="tab" data-status-id= "7" aria-controls="pastprojects" aria-selected="false">Past projects</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="pendingprizes-tab" data-toggle="tab" href="#pending-prizes" role="tab" data-status-id= "9" aria-controls="pendingprizes" aria-selected="false">Pending Prizes</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" id="releasedprizes-tab" data-toggle="tab" href="#released-prizes" role="tab" data-status-id= "10" aria-controls="releasedprizes" aria-selected="false">Released prizes</a>
							</li>
						</ul>
						<div class="tab-content" id="employerTabContent">
							<div class="tab-pane fade show active" id="open-projects" role="tabpanel" aria-labelledby="openprojects-tab">
							<table class="table table-striped table-bordered" id="table-openprojects-tab" style="width:100%">
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
							<table class="table table-striped table-bordered" id="table-workinprogress-tab" style="width:100%">
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
							</div> <!-- workinprogress-tab --> 
							<div class="tab-pane fade" id="past-projects" role="tabpanel" aria-labelledby="pastprojects-tab">
							<table class="table table-striped table-bordered" id="table-pastprojects-tab" style="width:100%">
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
							<div class="tab-pane fade" id="pending-prizes" role="tabpanel" aria-labelledby="pendingprizes-tab">
							<table class="table table-striped table-bordered" id="table-pendingprizes-tab" style="width:100%">
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
							</div> <!-- pendingprizes-tab -->
							<div class="tab-pane fade" id="released-prizes" role="tabpanel" aria-labelledby="releasedprizes-tab">
							<table class="table table-striped table-bordered" id="table-releasedprizes-tab" style="width:100%">
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
							</div> <!-- releasedprizes-tab -->
						</div>
				</div> <!-- tab-employer -->
				<div class="tab-pane fade" id="freelancer" role="tabpanel" aria-labelledby="freelancer-tab">...</div> <!-- tab-freelancer -->
				</div> <!-- tab-content -->
				</div>
			</div>
			<!-- Row / End -->
		</div>
	</div>
<link href="catalog/default/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript">
$('a[data-toggle="tab"]').on('click', function (e) {
var status_id = $(this).attr('data-status-id');

var table = $('#table-' + $(this).attr('id')).DataTable();
table.destroy();

$('#table-' + $(this).attr('id')).DataTable({
'ajax': {
	'url': "account/project/getProjects?cid=<?php echo $customer_id; ?>&status_id=" + encodeURIComponent(status_id),
	'dataSrc': '',
    },
	"columns": [
            { "data": "name" },
            { "data": "budget" },
            { "data": "type" },
            { "data": "total_bids" },
            { "data": "avgBids" },
            { "data": "expiry" },
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
	'responsive' : true,
	"bDestroy": true
  });
 
});
</script>	
<?php echo $footer; ?>