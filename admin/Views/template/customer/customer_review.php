<div class="table-responsive">
    <table id="table-location" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo $column_project; ?></th>
                <th><?php echo $column_employer; ?></th>
                <th><?php echo $column_rating; ?></th>
                <th><?php echo $column_status; ?></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($reviews) { ?>
                <?php foreach ($reviews as $review) { ?>
                    <tr>
                    <td><?php echo $review['name']; ?></td>
                    <td><?php echo $review['employer']; ?></td>
                    <td><?php echo $review['rating']; ?></td>
                    <td><?php echo $review['status']; ?></td>
                    <td class="text-center">
                        <a href="<?php echo $review['approve']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_approve; ?>"><i class="fas fa-check-circle"></i></a>
                        <a href="<?php echo $review['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_view; ?>"><i class="fas fa-eye"></i></a></td></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>
<!-- // DataTables -->
<script type="text/javascript">
$('#table-location').DataTable({
    "order": [[ 1, "asc" ]],
    "lengthMenu": [[15, 20, 25, 30], [15, 20, 25, 30]],
}); 
</script>