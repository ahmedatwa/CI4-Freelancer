<div class="table-responsive">
    <table id="table-location" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo $column_customer; ?></th>
                <th><?php echo $column_total; ?></th>
                <th><?php echo $column_status; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($wallets) { ?>
                <?php foreach ($wallets as $wallet) { ?>
                    <tr>
                    <td><?php echo $wallet['customer']; ?></td>
                    <td><?php echo $wallet['total']; ?></td>
                    <td><?php echo $wallet['status']; ?></td>
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
    "lengthMenu": [15, 20, 25, 30],
}); 
</script>