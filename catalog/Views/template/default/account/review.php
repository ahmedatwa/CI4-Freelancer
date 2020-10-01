<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40">
	<div class="dashboard-content-inner" >
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
			<!-- Breadcrumbs -->
			<nav id="breadcrumbs" class="dark">
				<ul>
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</nav>
		</div>
			<!-- Row -->
			<div class="row">
				<div class="col-12 mb-4">
				<table id="table-location" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo $column_name; ?></th>
                                <th><?php echo $column_employer; ?></th>
                                <th><?php echo $column_status; ?></th>
                                <th><?php echo $column_action; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($projects) { ?>
                                <?php foreach ($projects as $project) { ?>
                                    <tr>
	                                <td><?php echo $project['name']; ?></td>
	                                 <td><?php echo $project['employer']; ?></td>
	                                <td><?php echo $project['status']; ?></td>
	                                <td class="text-center">
                                    <a href="<?php echo $project['edit']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>"><i class="far fa-edit"></i></a></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


			</div>
			<!-- Row / End -->
		</div>
	</div>
<link href="catalog/default/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/DataTables/datatables.min.js"></script>
<!-- // DataTables -->
<script type="text/javascript">
var table = $('#table-location').DataTable({
    "dom": 'lrtp',
    "order":[[ 1, "asc" ]],
    "lengthMenu": [15, 20, 25, 30]
});
// Search
$('input[name=\'filter_name\']').on('keyup', function () {
    table.columns(1).search( this.value ).draw();
});
var filter_status = $('select[name=\'filter_status\']').val();
if (filter_status !== '*') {
    $('select[name=\'filter_status\']').on('change', function () {
        table.column(2).search( $(this).val()).draw();
    });
}
</script>	
<?php echo $footer; ?>