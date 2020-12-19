<div class="table-responsive">		
<table class="table table-striped table-bordered w-100" id="table-disputes-freelancer">
	<thead>
		<tr>
			<th><?php echo $column_project_id; ?></th>
			<th><?php echo $column_employer_id; ?></th>
			<th><?php echo $column_comment; ?></th>
			<th><?php echo $column_date_added; ?></th>
			<th><?php echo $column_status; ?></th>
			<th><?php echo $column_action; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($disputes) { ?>
			<?php foreach ($disputes as $dispute) { ?>
				<tr>
					<td><?php echo $dispute['project_id']; ?></td>
					<td><?php echo $dispute['employer']; ?></td>
					<td><?php echo $dispute['comment']; ?></td>
					<td><?php echo $dispute['date_added']; ?></td>
					<td><?php echo $dispute['status']; ?></td>
					<td><?php echo $dispute['action']; ?></td>

					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="6" class="text-center">No Disputes</td>
				</tr>
			<?php } ?>	
		</tbody> 
	</table>
</div>  <!-- table-responsive ./div --->
<div class="clearfix">
	<div class="float-right"><?php echo $pagination; ?></div>
</div>