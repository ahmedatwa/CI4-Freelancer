<div class="container-fluid mb-3"> <!-- Search ./ -->
  <div class="card">
      <div class="card-body row">
        <div class="col-6">
            <div class="form-group">
                <label for="input-name"><?php echo $entry_rated_by; ?></label>
                <input type="text" class="form-control" name="filter_name" placeholder="<?php echo $entry_rated_by; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" class="form-control">
                    <option value=""><?php echo $text_select; ?></option>
                    <option value="Enabled"><?php echo $text_enabled; ?></option>
                    <option value="Disabled"><?php echo $text_disabled; ?></option>
                </select>
            </div>
        </div>
    </div>
</div>
</div> <!-- Search END./ -->
<div class="table-responsive">
    <table id="table-review" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo $column_project; ?></th>
                <th><?php echo $column_employer; ?></th>
                <th><?php echo $column_freelancer; ?></th>
                <th><?php echo $column_rating; ?></th>
                <th><?php echo $column_rated_by; ?></th>
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
                    <td><?php echo $review['freelancer']; ?></td>
                    <td><?php echo $review['rating']; ?></td>
                    <td><?php echo $review['submitted_by']; ?></td>
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
var table = $('#table-review').DataTable({
    "order": [[ 1, "asc" ]],
    "lengthMenu": [[15, 20, 25, 30], [15, 20, 25, 30]],
}); 
// Search
$('input[name=\'filter_name\']').on('keyup', function () {
    table.columns(4).search( this.value ).draw();
});

var filter_status = $('select[name=\'filter_status\']').val();
if (filter_status !== '*') {
$('select[name=\'filter_status\']').on('change', function () {
    table.column(5).search( $(this).val()).draw();
});
}
</script>