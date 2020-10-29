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
						   <div class="table-responsive">		
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
							    	<th><?php echo $column_action; ?></th>
							    </tr>
							</thead>
							 <tbody>
							 	<?php if ($open_projects) { ?>
							 	<?php foreach ($open_projects as $open) { ?>
							  <tr>
							  	<td><?php echo $open['name']; ?></td>
							  	<td><?php echo $open['budget']; ?></td>
							  	<td><?php echo $open['type']; ?></td>
							  	<td><?php if ($open['total_bids'] > 0) { ?>
							  		<span class="badge badge-success"><?php echo $open['total_bids']; ?></span>
							  	<?php } else { ?>
							  		<span class="badge badge-danger"><?php echo $open['total_bids']; ?></span>
							  	<?php } ?></td>
							  	<td><?php echo $open['avgBids']; ?></td>
							  	<td><?php echo $open['expiry']; ?></td>
							  	<td><?php echo $open['status']; ?></td>
							  	<td>
							  	<a href="<?php echo $open['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a>
							  	<a href="<?php echo $open['view']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Pay"><i class="fas fa-wallet"></i></a>
							    <a href="<?php echo $open['view']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Mark As Complete"><i class="fas fa-check"></i></a>
						      </td>
							  </tr>
							 <?php } ?>
							<?php } else { ?>
								<tr>
									<td colspan="8" class="text-center">No Open Porjects</td>
								</tr>
							<?php } ?>	
							 </tbody> 
							  </table>
							 </div>  <!-- table-responsive ./div --->
				            </div> <!-- openprojects-tab -->
							<div class="tab-pane fade" id="in-progress" role="tabpanel" aria-labelledby="workinprogress-tab">
						    <div class="table-responsive">
							<table class="table table-striped table-bordered w-100" id="table-workinprogress-tab">
							  <thead>
							    <tr>
							    	<th><?php echo $column_name; ?></th>
							    	<th><?php echo $column_budget; ?></th>
							    	<th><?php echo $column_type; ?></th>
							    	<th><?php echo $column_status; ?></th>
							    	<th><?php echo $column_action; ?></th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php if ($work_projects) { ?>
							 <?php foreach ($work_projects as $work) { ?>
							  <tr>
							  	<td><?php echo $work['name']; ?></td>
							  	<td><?php echo $work['budget']; ?></td>
							  	<td><?php echo $work['type']; ?></td>
							  	<td><?php echo $work['status']; ?></td>
							  	<td>
							  	<a href="<?php echo $work['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a>
							  	<a href="<?php echo $work['view']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Pay"><i class="fas fa-wallet"></i></a>
							  	<button type="button" id="button-dispute" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#open-dispute" data-emploerid="<?php echo $work['employer_id']; ?>" data-freelancerid="<?php echo $work['freelancer_id']; ?>" data-projectid="<?php echo $work['project_id']; ?>"><i class="fas fa-exclamation-circle"></i></button>
							  	<?php if ($customer_id != $work['employer_id']) { ?>
							    <a href="<?php echo $work['view']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Mark As Complete"><i class="fas fa-check"></i></a>
							    <?php } ?>
								</td>
							  </tr>
							 <?php } ?>
							 <?php } else { ?>
								<tr>
									<td colspan="5" class="text-center">No Current in progress Porjects</td>
								</tr>
							<?php } ?>	
							 </tbody> 
							  </table>
							   </div>  <!-- table-responsive ./div --->
							</div> <!-- workinprogress-tab --> 
							<div class="tab-pane fade" id="past-projects" role="tabpanel" aria-labelledby="pastprojects-tab">
						    <div class="table-responsive">
							<table class="table table-striped table-bordered w-100" id="table-pastprojects-tab">
							  <thead>
							    <tr>
							    	<th><?php echo $column_name; ?></th>
							    	<th><?php echo $column_budget; ?></th>
							    	<th><?php echo $column_type; ?></th>
							    	<th><?php echo $column_bids; ?></th>
							    	<th><?php echo $column_avg_bids; ?></th>
							    	<th><?php echo $column_status; ?></th>
							    </tr>
							</thead>
							  </thead>
							  <tbody>
							  	<?php if ($past_projects) { ?>
							 	<?php foreach ($past_projects as $past) { ?>
							  <tr>
							  	<td><?php echo $past['name']; ?></td>
							  	<td><?php echo $past['budget']; ?></td>
							  	<td><?php echo $past['type']; ?></td>
							  	<td><?php if ($past['total_bids'] > 0) { ?>
							  		<span class="badge badge-success"><?php echo $past['total_bids']; ?></span>
							  	<?php } else { ?>
							  		<span class="badge badge-danger"><?php echo $past['total_bids']; ?></span>
							  	<?php } ?></td>
							  	<td><?php echo $past['avgBids']; ?></td>
							  	<td><?php echo $past['status']; ?></td>
							  </tr>
							 <?php } ?>
							 <?php } else { ?>
								<tr>
									<td colspan="6" class="text-center">No Open Porjects</td>
								</tr>
							<?php } ?>	
							 </tbody> 
							  </table>
							   </div>  <!-- table-responsive ./div --->
							</div> <!-- pastprojects-tab -->
						</div>
				</div> 
				<!--==================================
			       ========== tab-employer END =======
			     ===================================-->
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
								<tbody>
							  	<?php if ($freelancer_progress_projects) { ?>
							 	<?php foreach ($freelancer_progress_projects as $work) { ?>
							  <tr>
							  	<td><?php echo $work['name']; ?></td>
							  	<td><?php echo $work['budget']; ?></td>
							  	<td><?php echo $work['type']; ?></td>
							  	<td><?php echo $work['status']; ?></td>
							  	<td><a href="<?php echo $work['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a></td>
							  </tr>
							 <?php } ?>
							 <?php } else { ?>
								<tr>
									<td colspan="6" class="text-center">No Open Porjects</td>
								</tr>
							<?php } ?>	
							 </tbody> 
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

<!--Dispute Modal   -->
<div class="modal fade" id="open-dispute" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Claim Dispute</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Comment:</label>
            <textarea type="text" class="form-control" name="comment" id="comment"></textarea>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Reason:</label>
            <select class="custom-select" name="dispute_reason_id" id="dispute_reason_id">
            	<?php foreach ($dispute_reasons as $reason) { ?>
            	<option value="<?php echo $reason['dispute_reason_id']; ?>"><?php echo $reason['name']; ?></option>
               <?php } ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="button-claim">Claim</button>
      </div>
    </div>
  </div>
</div>

<link href="catalog/default/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript">
var table = $('#table-pastprojects-tab').DataTable({
    "dom": 'lrtp',
    "order":[[ 1, "asc" ]],
    "lengthMenu": [15, 20, 25, 30]
});
</script>
<!-- // Freelancer  -->
<script type="text/javascript">
$('#open-dispute').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var project_id = button.data('projectid');
  var freelancer_id = button.data('freelancerid');
  var employer_id = button.data('employerid');

  $('#open-dispute #button-claim').on('click', function() {

  	var comment = $('.modal-body #comment').val();
    var dispute_reason_id = $('.modal-body #dispute_reason_id').val();

  $.ajax({
		url: 'freelancer/freelancer/openDispute',
		dataType: 'json',
		method:'post',
		data: {employer_id : employer_id, freelancer_id : freelancer_id, project_id: project_id, comment: comment, dispute_reason_id: dispute_reason_id, '<?= csrf_token() ?>' : '<?= csrf_hash() ?>'},
		beforeSend: function() {
		    $('#button-dispute').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
		},
		complete: function() {
		    $('#button-dispute').html('<i class="fas fa-exclamation-circle"></i>');
		},
		success: function(json) {
		   	
		   	if (json['success']) {
		   		$('#open-dispute').modal('hide');

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
    })
  })
</script>	


<script type="text/javascript">
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

<script type="text/javascript">
$('#employer li:first-child a').trigger('click') // Select first tab
$('#freelancer li:first-child a').trigger('click') // Select first tab
</script>	

<?php echo $footer; ?>