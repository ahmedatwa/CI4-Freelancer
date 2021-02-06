<div class="alert alert-info alert-dismissible fade show" role="alert">
  <i class="fas fa-info-circle"></i> <?php echo $help_milestone; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="table-responsive" id="milestone-table">
    <?php if ($project_id) { ?>
	<button class="btn btn-primary my-4" id="milestone-button-add" onclick="addMilestone();">Create Milestone </button>
    <?php } else { ?>
    <button class="btn btn-primary my-4" id="milestone-button-add" disabled>Create Milestone </button>
    <?php } ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Date Added</th>
				<th>Amount</th>
				<th>Description</th>
				<th>Deadline Date</th>
				<th>Status</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($project_milestones) { ?>
				<?php foreach ($project_milestones as $milestone) { ?> 
					<tr>
						<td><?php echo $milestone['date_added']; ?></td>
						<td><?php echo $milestone['amount']; ?></td>
						<td><?php echo $milestone['description']; ?></td>
						<td><?php echo $milestone['deadline']; ?></td>
						<td><?php echo $milestone['status']; ?></td>
						<td width="15%" class="text-center">
							<?php if (($milestone['created_by'] != $customer_id) && ($milestone['status'] == 'Pending')) { ?>
							<button type="button" onclick="approveMilestone(<?php echo $milestone['milestone_id']; ?>);" class="btn btn-success btn-sm" data-toggle="tooltip" title="Approve" data-placement="top"><i class="fas fa-check-circle"></i></button>
						   <?php } ?>
                           <?php if (!in_array($milestone['status'], ['Paid', 'Canceled'])) { ?>
							<button type="button" onclick="cancelMilestone(<?php echo $milestone['milestone_id']; ?>);" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancel" data-placement="top"><i class="fas fa-window-close"></i></button>
                        <?php } else { ?>
                            -
                        <?php } ?>    
							<?php if (($employer_id == $customer_id) && (!in_array($milestone['status'], ['Canceled', 'Pending', 'Paid']))) { ?>
							<button type="button" onclick="payMilestone(<?php echo $milestone['milestone_id']; ?>, <?php echo $milestone['amount']; ?>, <?php echo $employer_id; ?>, <?php echo $freelancer_id; ?>);" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Pay"><i class="fas fa-money-bill-alt"></i></button>
						  <?php } ?>	
						</td>
					</tr>
				<?php } ?>	
			<?php } else { ?>
				<tr>
					<td colspan="6" class="text-center">No Milestones for this project! </td>
				</tr>
			<?php } ?>
		</tbody>
	</table>  
</div>	

<script type="text/javascript">
function addMilestone() {
   var dialog = bootbox.confirm({
    title: 'Create Milestone',
    message: '<form id="milestone-modal-form"><input type="hidden" name="project_id" value="<?php echo $project_id; ?>" /><input type="hidden" name="created_by" value="<?php echo $customer_id; ?>" /><input type="hidden" name="created_for" value="<?php echo $created_for; ?>" /><div class="form-group"><label for="input-amount">Amount</label><input type="number" min="1" class="form-control" name="amount" id="input-amount"></div><div class="form-group"><label for="input-description">Description</label><textarea type="text" cols="3" row="4" class="form-control" name="description" id="input-description"></textarea></div><div class="form-group"><label for="input-deadline">Completed in</label><input type="number" min="1" max="30" class="form-control" name="deadline" id="input-deadline"></div></form>',
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
                url: 'freelancer/milestone/addMilestone?project_id=<?php echo $project_id; ?>',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
                  'X-Requested-With': 'XMLHttpRequest',
                },
                dataType: 'json',
                method: 'post',
                data: $('#milestone-modal-form').serialize(),
                beforeSend: function() {
                  $('.text-danger, .alert, .invalid-feedback').remove();
                  $('#comment').removeClass('is-invalid');
                },
                success: function(json) {
                    if (json['error']) {
                            for (i in json['error']) {
                            var el = $('#input-' + i);
                            el.addClass('is-invalid');
                            el.after('<div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i>' + json['error'][i] + '</div>'); 
                        }
                    }

                    if (json['success']) {
                        dialog.modal('hide');
                        
                        $('#project-info #milestones-tab').trigger('click');   

                        $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }                        
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
          });
      }
      return false; 
    } 
   });  
}	
// Cancel MileStone
function cancelMilestone(milestone_id) {
    bootbox.confirm({
    message: 'Are You Sure',
    className: 'animate__animated animate__fadeInDown',
    size:'small',
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
        url: 'freelancer/milestone/cancelMilestone?milestone_id=' + milestone_id,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
          'X-Requested-With': 'XMLHttpRequest',
        },
        dataType: 'json',
        method: 'post',
        beforeSend: function() {
            $('.text-danger, .alert').remove();
        },
        success: function(json) {
            if (json['success']) {
            
             $('#project-info #milestones-tab').trigger('click');   

             $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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

// Approve MileStone
function approveMilestone(milestone_id) {
    bootbox.confirm({
    message: 'Are You Sure',
    className: 'animate__animated animate__fadeInDown',
    size:'small',
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
        url: 'freelancer/milestone/approveMilestone?milestone_id=' + milestone_id,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
          'X-Requested-With': 'XMLHttpRequest',
        },
        dataType: 'json',
        method: 'post',
        beforeSend: function() {
            $('.text-danger, .alert').remove();
        },
        success: function(json) {
            if (json['success']) {
            
             $('#project-info #milestones-tab').trigger('click');   

             $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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

// Pay MileStone
function payMilestone(milestone_id, amount, employer_id, freelancer_id) {
    bootbox.confirm({
    title: 'Are You Sure',
    message: 'Are You Sure',
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
    onShown: function(e) {
        $(this).find('.modal-body').text(amount + '.00 EGP will be deducted from your Balance');
    },
    callback: function (result) {
    if (result === false) {
        dialog.modal('hide');
    } else { 
    $.ajax({
        url: 'freelancer/milestone/payMilestone',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
          'X-Requested-With': 'XMLHttpRequest',
        },
        dataType: 'json',
        method: 'post',
        data: {'milestone_id': milestone_id, 'amount': amount, 'employer_id': employer_id, 'freelancer_id': freelancer_id},
        beforeSend: function() {
            $('.text-danger, .alert').remove();
        },
        success: function(json) {
            if (json['error']) {
                $('#milestones-list').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['error']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }

            if (json['success']) {
             dialog.modal('hide');
             $('#project-info #milestones-tab').trigger('click');   

             $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }                        
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
  });
  } 
  return false; 
 } 
}); 
}	
</script>