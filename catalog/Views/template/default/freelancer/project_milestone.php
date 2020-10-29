	<button class="button my-4" id="milestone-button-add">Create Milestone </button>
	<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Description</th>
				<th>Deadline Date</th>
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
				<td>
				<a href="<?php echo $milestone['pay']; ?>" role="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Pay"><i class="fas fa-money-bill-alt"></i></a>
				<a href="<?php echo $milestone['cancel']; ?>" role="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancel" data-placement="top"><i class="fas fa-window-close"></i></a>
				</td>
			</tr>
		<?php } ?>	
		<?php } else { ?>
			<tr>
				<td colspan="5" class="text-center">No Records! </td>
			</tr>
		<?php } ?>
		</tbody>
	</table>  
 </div>	
