<div class="table-responsive">
    <table id="table-location" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo $column_income; ?></th>
                <th><?php echo $column_withdrawn; ?></th>
                <th><?php echo $column_used; ?></th>
                <th><?php echo $column_available; ?></th>
                <th><?php echo $column_date_added; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($wallets) { ?>
                <?php foreach ($wallets as $wallet) { ?>
                    <tr>
                    <td><?php echo $wallet['income']; ?></td>
                    <td><?php echo $wallet['withdrawn']; ?></td>
                    <td><?php echo $wallet['used']; ?></td>
                    <td><?php echo $wallet['available']; ?></td>
                    <td><?php echo $wallet['date_added']; ?></td>
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
    "order": [[ 3, "asc" ]],
    "lengthMenu": [15, 20, 25, 30],
}); 
</script>