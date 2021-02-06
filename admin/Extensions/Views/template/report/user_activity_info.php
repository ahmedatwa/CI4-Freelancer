<div class="row">
  <div class="col">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $report_heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-location">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_comment; ?></td>
                <td class="text-left"><?php echo $column_ip; ?></td>
                <td class="text-center" width="20%"><?php echo $column_date_added; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($activities as $activity) { ?>
            <tr>
              <td class="text-left"><?php echo $activity['comment']; ?></td>
              <td class="text-left"><?php echo $activity['ip']; ?></td>
              <td class="text-left"><?php echo $activity['date_added']; ?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>
<!-- // DataTables -->
<script type="text/javascript">
var table = $('#table-location').DataTable({
    "dom": 'lrtp',
    "order":[[ 0, "asc" ]],
    "lengthMenu": [20, 25, 30]
});
</script>