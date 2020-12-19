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
			<?php foreach ($open_projects as $project) { ?>
				<tr>
					<td><?php echo $project['name']; ?></td>
					<td><?php echo $project['budget']; ?></td>
					<td><?php echo $project['type']; ?></td>
					<td><?php if ($project['total_bids'] > 0) { ?>
						<span class="badge badge-success"><?php echo $project['total_bids']; ?></span>
					<?php } else { ?>
						<span class="badge badge-danger"><?php echo $project['total_bids']; ?></span>
						<?php } ?></td>
						<td><?php echo $project['avgBids']; ?></td>
						<td><?php echo $project['expiry']; ?></td>
						<td><?php echo $project['status']; ?></td>
						<td><a href="<?php echo $project['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a></td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="8" class="text-center">No Open Projects</td>
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