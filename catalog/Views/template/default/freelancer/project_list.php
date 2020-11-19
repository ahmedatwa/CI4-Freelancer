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
							  	<span data-toggle="tooltip" data-placement="top" title="Open Dispute">
							  	<button type="button" id="button-dispute" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#open-dispute" data-emploerid="<?php echo $work['employer_id']; ?>" data-freelancerid="<?php echo $work['freelancer_id']; ?>" data-projectid="<?php echo $work['project_id']; ?>"><i class="fas fa-exclamation-circle"></i></button>
							  </span>
							  	<?php if ($customer_id != $work['employer_id']) { ?>
							    <button type="button" onclick="confirm('Are You Sure') ? markComeplete(<?php echo $work['project_id']; ?>) : false;" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Mark As Complete" id="button-complete-status"><i class="fas fa-check"></i></a>
							    <?php } ?>
								</td>
							  </tr>
							 <?php } ?>
							 <?php } else { ?>
								<tr>
									<td colspan="5" class="text-center">No Current under development Porjects</td>
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
							    	<th><?php echo $column_amount; ?></th>
							    	<th><?php echo $column_paid; ?></th>
							    	<th><?php echo $column_action; ?></th>
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
							  	<td><?php echo number_format($past['amount'], 2); ?></td>
							  	<td><?php echo $past['paid']; ?></td>
							  	
							  	<td width="10%"><?php if (($past['amount'] > 0)) { ?>
							  	<span data-toggle="tooltip" data-placement="top" title="Pay">
							  	<button type="button" id="button-pay" class="btn btn-success btn-sm" data-toggle="modal" data-target="#pay-freelancer" data-emploerid="<?php echo $past['employer_id']; ?>" data-freelancerid="<?php echo $past['freelancer_id']; ?>" data-projectid="<?php echo $past['project_id']; ?>" data-amount="<?php echo number_format($past['amount'], 2); ?>" data-employerid="<?php echo $past['employer_id']; ?>"><i class="far fa-money-bill-alt"></i></button>
							  	</span>
							  	<span data-toggle="tooltip" data-placement="top" title="Open Dispute">
							  	<button type="button" id="button-dispute" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#open-dispute" data-emploerid="<?php echo $past['employer_id']; ?>" data-freelancerid="<?php echo $past['freelancer_id']; ?>" data-projectid="<?php echo $past['project_id']; ?>"><i class="fas fa-exclamation-circle"></i></button>
							  </span>
							  	<?php } else { ?>
								<button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Pay" disabled><i class="fas fa-wallet"></i></button>
								<?php } ?>
							  	</td>
							  </tr>
							 <?php } ?>
							 <?php } else { ?>
								<tr>
									<td colspan="9" class="text-center">No Past Porjects</td>
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
							  	<td><a href="<?php echo $work['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a>
							    <button type="button" onclick="bootbox.confirm('Are You Sure?', function(result){ if (result) {markComeplete(<?php echo $work['project_id']; ?>)}});" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Mark As Complete" id="button-complete-status"><i class="fas fa-check"></i></a>
							    </td>
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

<!--payment Modal   -->
<div class="modal fade" id="pay-freelancer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="alert alert-info" role="alert"><i class="fas fa-exclamation"></i> Your Currenct Balance is: <?php echo $balance; ?></div>
        <form>
          <div class="form-group">
            <label for="amount" class="col-form-label">Amount:</label>
            <input type="number" class="form-control" name="amount" id="amount"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="button-transfer">Transfer</button>
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

  	var comment = $('#open-dispute #comment').val();
    var dispute_reason_id = $('#open-dispute #dispute_reason_id').val();

  $.ajax({
		url: 'freelancer/freelancer/openDispute',
		dataType: 'json',
		method:'post',
		data: {employer_id : employer_id, freelancer_id: freelancer_id, project_id: project_id, comment: comment, dispute_status_id: '1', dispute_reason_id: dispute_reason_id, '<?= csrf_token() ?>': '<?= csrf_hash() ?>'},
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
    });
  });
</script>	


<!-- Tranfer amount -->
<script type="text/javascript">
$('#pay-freelancer').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var amount = button.data('amount') 
  var modal = $(this)
  modal.find('.modal-title').text('Pay Freelancer | ' + amount)
  modal.find('.modal-body input[type="number"]').val(amount)
  var project_id = button.data('projectid');
  var freelancer_id = button.data('freelancerid');
  var employer_id = button.data('employerid');

$('#button-transfer').on('click', function() {

  var amount = $('#pay-freelancer #amount').val();

  $.ajax({
		url: 'freelancer/freelancer/transferFunds',
		dataType: 'json',
		method:'post',
		data: {employer_id: employer_id, freelancer_id: freelancer_id, project_id: project_id, amount: amount, '<?= csrf_token() ?>': '<?= csrf_hash() ?>'},
		beforeSend: function() {
		    $('#button-transfer').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
		},
		complete: function() {
		    $('#button-transfer').html('Transfer');
		},
		success: function(json) {

			if (json['error']) {
				  modal.find('.modal-body').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['error']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
			}
		   	
		   	if (json['success']) {
		   		$('#pay-freelancer').modal('hide');

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
    });
  });

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

// Freelancer to accept offer
function acceptOffer(project_id, bid_id, employer_id) {
	bootbox.confirm({
    message: "Are you sure?",
    className: 'animate__animated animate__fadeInDown',
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel',
            className: 'btn-dark'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm',
            className: 'btn-success'
        }
    },
    callback: function (result) {
   if (result) {
	$.ajax({
		url: 'freelancer/freelancer/acceptOffer?freelancer_id=<?php echo $customer_id; ?>&project_id=' + project_id + '&bid_id=' + bid_id + '&employer_id=' + employer_id,
		dataType: 'json',
		beforeSend: function() {
           $('#button-offer-accept').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
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
	        // Reload the Bids Tab
	        $('#active-bids-list').load('freelancer/freelancer/getFreelancerBids?customer_id=<?php echo $customer_id; ?>');
	        }

	    },
	    error: function(xhr, ajaxOptions, thrownError) {
	        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	    }
         });
      } // if end
    } // callback end
   });  // bootbox end
}
</script>
<!-- Freelancer to complete project  -->
<script type="text/javascript">
function markComeplete(project_id) {
	$.ajax({
	url: 'freelancer/project/completeProject?project_id=' + project_id,
	dataType: 'json',
	beforeSend: function() {
       $('#button-complete-status').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    },
    complete: function() {
       $('#button-complete-status').html('<i class="fas fa-check"></i>');
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
        location.reload();	
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

<script type="text/javascript">
var url = document.URL;
var hash = url.substring(url.indexOf('#'));

$(".nav-tabs").find("li a").each(function(key, val) {
    if (hash == $(val).attr('href')) {
        $(val).click();
    }
    
    $(val).click(function(ky, vl) {
        location.hash = $(this).attr('href');
    });
});

// Main tabs
$(".nav-pills").find("li a").each(function(key, val) {
    if (hash == $(val).attr('href')) {
        $(val).click();
    }
    
    $(val).click(function(ky, vl) {
        location.hash = $(this).attr('href');
    });
});
</script>
<?php echo $footer; ?>