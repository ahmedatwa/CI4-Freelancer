<div class="table-responsive">
    	<table class="table table-striped table-bordered w-100" id="table-pastprojects-tab">
    		<thead>
    			<tr>
                    <th><?php echo $column_project_id; ?></th>
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
    			<?php foreach ($past_projects as $project) { ?>
    				<tr>
                        <td><?php echo $project['project_id']; ?></td>
    					<td><?php echo $project['name']; ?></td>
    					<td><?php echo $project['budget']; ?></td>
    					<td><?php echo $project['type']; ?></td>
    					<td><?php if ($project['total_bids'] > 0) { ?>
    						<span class="badge badge-success"><?php echo $project['total_bids']; ?></span>
    					<?php } else { ?>
    						<span class="badge badge-danger"><?php echo $project['total_bids']; ?></span>
    						<?php } ?></td>
    						<td><?php echo $project['avgBids']; ?></td>
    						<td><?php echo $project['status']; ?></td>
    						<td><?php echo number_format($project['amount'], 2); ?></td>
    						<td><?php echo $project['paid']; ?></td>

    						<td width="10%"><?php if (($project['amount'] > 0) && $project['paid'] != 'Paid') { ?>
    							<span data-toggle="tooltip" data-placement="top" title="Pay">
    								<button type="button" onclick="payFreelancer(<?php echo $project['employer_id']; ?>, <?php echo $project['freelancer_id']; ?>, <?php echo $project['project_id']; ?>, <?php echo $project['amount']; ?>, <?php echo $project['employer_id']; ?>);" class="btn btn-success btn-sm">
                                        <i class="far fa-money-bill-alt"></i></button>
    							</span>
                                <?php if (! $project['inDispute']) { ?>
                                <span data-toggle="tooltip" data-placement="top" title="Open Dispute">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="openDispute(<?php echo $project['employer_id']; ?>, <?php echo $project['freelancer_id']; ?>, <?php echo $project['project_id']; ?>);"><i class="fas fa-exclamation-circle"></i></button>
                                </span>
                            <?php } ?>
    						<?php } else { ?>
    							<button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Pay" disabled><i class="fas fa-wallet"></i></button>
                                <?php if (! $project['inDispute']) { ?>
                                <span data-toggle="tooltip" data-placement="top" title="Open Dispute">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="openDispute(<?php echo $project['employer_id']; ?>, <?php echo $project['freelancer_id']; ?>, <?php echo $project['project_id']; ?>);"><i class="fas fa-exclamation-circle"></i></button>
                                </span>
                            <?php } ?>
    						<?php } ?>
    					</td>
    				</tr>
    			<?php } ?>
    		<?php } else { ?>
    			<tr>
    				<td colspan="10" class="text-center">No Past Projects</td>
    			</tr>
    		<?php } ?>	
    	</tbody> 
    </table>
</div>  <!-- table-responsive ./div --->
<div class="clearfix">
    <div class="float-right">
    <?php echo $pagination; ?>
    </div>
</div>

<!-- Tranfer amount -->
<script type="text/javascript">
function payFreelancer(employer_id, freelancer_id, project_id, amount) {
  bootbox.confirm({
    title: '<i class="fas fa-exclamation"></i> Your Currenct Balance is: <?php echo $balance; ?>',
    message: '<form id="payFreelancer-form"><input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /><input type="hidden" name="freelancer_id" value="'+freelancer_id+'" /><input type="hidden" name="project_id" value="'+project_id+'" /><div class="form-group"><label for="input-amount">Amount</label><input type="number" class="form-control" name="amount" value="' + amount + '"></div></form>',
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
            url: 'employer/employer/transferFunds',
            dataType: 'json',
            method:'post',
            data: {'employer_id': employer_id, 'freelancer_id': freelancer_id, 'project_id': project_id, 'amount': amount, '<?= csrf_token() ?>': '<?= csrf_hash() ?>'},
            beforeSend: function() {
                $('#freelancer-past-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
            },
            complete: function() {
                $('#spinner').remove();
            },
            success: function(json) {

                if (json['error']) {
                      modal.find('.modal-body').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['error']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
                }
                
                if (json['success']) {
                    $('#employer-past-list').load('employer/Project/getPastProjects');

                    $('#past-projects').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
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

// open Dispute
function openDispute(employer_id, freelancer_id, project_id) {
  var dialog = bootbox.confirm({
    title: 'Claim Dispute',
    message: '<form id="open-dispute-form"><input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /><input type="hidden" name="freelancer_id" value="'+freelancer_id +'" /><input type="hidden" name="project_id" value="' + project_id + '" /><input type="hidden" name="employer_id" value="' + employer_id + '" /><div class="form-group"><label for="input-comment">Comment</label><textarea type="text" class="form-control" id="comment" name="comment"></textarea></div><div class="form-group"><label for="message-text" class="col-form-label">Reason:</label><select class="custom-select" name="dispute_reason_id" id="dispute_reason_id"><?php foreach ($dispute_reasons as $reason) { ?><option value="<?php echo $reason['dispute_reason_id']; ?>"><?php echo $reason['name']; ?></option><?php } ?></select></div></form>',
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
    if (result === false) {
        dialog.modal('hide');
    } else {
      $.ajax({
            url: 'employer/employer/openDispute',
            dataType: 'json',
            method:'post',
            data: $('#open-dispute-form').serialize(),
            beforeSend: function() {
                $('#freelancer-past-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
                $('.alert, .invalid-feedback').remove();
                $('#comment').removeClass('is-invalid');
            },
            complete: function() {
                $('#spinner').remove();
            },
            success: function(json) {  

                 if (json['error']) {
                    for (i in json['error']) {
                        $('#comment').addClass('is-invalid');
                        $('#comment').after('<div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i>' + json['error']['comment'] + '</div>'); 
                    }
                }
                  
                if (json['success']) {
                  dialog.modal('hide');

                  $('#employer-past-list').load('employer/Project/getPastProjects');

                  $('#employer-past-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
                } 
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        }); 
      } 
      return false;
    } // Callback
   });
}
</script>