<div class="table-responsive">
<table class="table table-striped table-bordered w-100" id="table-freelancer-in-progress-tab">
	<thead>
		<tr>
			<th><?php echo $column_project_id; ?></th>
			<th><?php echo $column_name; ?></th>
			<th><?php echo $column_budget; ?></th>
			<th><?php echo $column_type; ?></th>
			<th><?php echo $column_status; ?></th>
			<th><?php echo $column_action; ?></th></tr>
		</tr>
	</thead>
	<tbody>
		<?php if ($progress_projects) { ?>
			<?php foreach ($progress_projects as $project) { ?>
				<tr>
					<td><?php echo $project['project_id']; ?></td>
					<td><?php echo $project['name']; ?></td>
					<td><?php echo $project['budget']; ?></td>
					<td><?php echo $project['type']; ?></td>
					<td><?php echo $project['status']; ?></td>
					<td><a href="<?php echo $project['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a>
					<?php if ($project['status_id'] != $config_project_completed_status) { ?>
						<button type="button" onclick="markComeplete(<?php echo $project['project_id']; ?>, <?php echo $project['freelancer_id']; ?>, <?php echo $project['employer_id']; ?>);" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Mark As Complete" id="button-complete-status"><i class="fas fa-check"></i></button>
					<?php } else { ?>
						<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Mark As Complete" id="button-complete-status" disabled><i class="fas fa-check"></i></button>
					<?php } ?>	
						</td>
					
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="6" class="text-center">No Current Open Projects</td>
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

<!-- Freelancer to complete project  -->
<script type="text/javascript">
function markComeplete(project_id, freelancer_id, employer_id) {
	bootbox.confirm({
	message: "Are you sure?",
	size: 'small',
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
		url: 'freelancer/project/completeProject?project_id=' + project_id,
		dataType: 'json',
		method: 'post',
		data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'freelancer_id': freelancer_id, 'employer_id': employer_id},
		beforeSend: function() {
	       $('#button-complete-status').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
	       $('.alert').remove();
	    },
	    complete: function() {
	       $('#button-complete-status').html('<i class="fas fa-check"></i>');
	    },
	    success: function(json) {

	        if (json['success']) {
	        	
	        	$('#freelancer-in-progress').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	        	
	        	$('#freelancer-progress-list').load('freelancer/Project/getInProgressProjects');   
	        }
	    },
	    error: function(xhr, ajaxOptions, thrownError) {
	        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	    }
         });
      } 
    } 
   });  
}
</script>