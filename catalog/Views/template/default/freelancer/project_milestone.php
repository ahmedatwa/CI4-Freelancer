<div class="table-responsive" id="milestone-table">
	<button class="button my-4" id="milestone-button-add" onclick="addMilestone();">Create Milestone </button>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Date Added</th>
				<th>Amount</th>
				<th>Description</th>
				<th>Deadline Date</th>
				<th>Status</th>
				<th>Action</th>
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
						<td width="15%">
							<?php if (($milestone['created_by'] != $customer_id) && ($milestone['status'] == 'Pending')) { ?>
							<button type="button" onclick="approveMilestone(<?php echo $milestone['milestone_id']; ?>);" class="btn btn-success btn-sm" data-toggle="tooltip" title="Approve" data-placement="top"><i class="fas fa-check-circle"></i></button>
						   <?php } ?>
							<button type="button" onclick="cancelMilestone(<?php echo $milestone['milestone_id']; ?>);" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancel" data-placement="top"><i class="fas fa-window-close"></i></button>
							<?php if (($employer_id == $customer_id) && (!in_array($milestone['status'], ['Canceled', 'Pending', 'Paid']))) { ?>
							<button type="button" onclick="payMilestone(<?php echo $milestone['milestone_id']; ?>, <?php echo $milestone['amount']; ?>, <?php echo $employer_id; ?>, <?php echo $freelancer_id; ?>);" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Pay"><i class="fas fa-money-bill-alt"></i></button>
						  <?php } ?>	
						</td>
					</tr>
				<?php } ?>	
			<?php } else { ?>
				<tr>
					<td colspan="6" class="text-center">No Records! </td>
				</tr>
			<?php } ?>
		</tbody>
	</table>  
</div>	