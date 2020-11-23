<div class="table-responsive">
<table class="table table-striped table-bordered w-100" id="table-workinprogress-tab">
	<thead>
		<tr>
            <th><?php echo $column_project_id; ?></th>
			<th><?php echo $column_name; ?></th>
			<th><?php echo $column_budget; ?></th>
			<th><?php echo $column_type; ?></th>
			<th><?php echo $column_status; ?></th>
			<th><?php echo $column_action; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($work_projects) { ?>
			<?php foreach ($work_projects as $project) { ?>
				<tr>
                    <td><?php echo $project['project_id']; ?></td>
					<td><?php echo $project['name']; ?></td>
					<td><?php echo $project['budget']; ?></td>
					<td><?php echo $project['type']; ?></td>
					<td><?php echo $project['status']; ?></td>
					<td><a href="<?php echo $project['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a></td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="7" class="text-center">No Current under development Projects</td>
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