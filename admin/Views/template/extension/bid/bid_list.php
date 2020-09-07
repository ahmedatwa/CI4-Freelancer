<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
        <div class="float-right">
            <a href="<?php echo $cancel; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_cancel; ?>"><i class="fas fa-reply"></i></a>
        </div>
            <h1><?php echo $heading_title; ?> </h1>
            <nav aria-label="breadcrumb" id="breadcrumb">
               <ol class="breadcrumb">
                   <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                      <li class="breadcrumb-item">
                          <a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb-link"><?php echo $breadcrumb['text']; ?></a>
                      </li>
                  <?php } ?>
              </ol>
          </nav>	
      </div>
  </div>
  <!-- Page Heaedr End -->
  <div class="container-fluid">
    <div class="card">
        <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_list; ?></div>
        <div class="card-body">
            <form class="form-horizontal" enctype="multipart/form-data" id="form-location">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="table-responsive">
                <table id="table-bid" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="60%"><?php echo $column_name; ?></th>
                        <th><?php echo $column_freelancer; ?></th>
                        <th><?php echo $column_open; ?></th>
                        <th><?php echo $column_status; ?></th>
                        <th><?php echo $column_action; ?></th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($bids as $bid) { ?>
                            <tr>
                            <td><?php echo $bid['name']; ?></td>
                            <td><?php echo $bid['freelancer']; ?></td>
                            <td><?php echo $bid['open']; ?></td>
                            <td><?php echo $bid['status']; ?></td>
                            <td class="text-center">
                                <a href="<?php echo $bid['edit']; ?>" class="btn btn-primary btn-sm"
                                    data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>"><i
                                    class="far fa-edit"></i></a></td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
            </form>
        </div><!-- Card Body -->
    </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>
<!-- // DataTables -->
<script type="text/javascript">
var table = $('#table-bid').DataTable({
    "dom": 'lrtp',
    "order":[[ 1, "asc" ]],
    "lengthMenu": [15, 20, 25, 30]
}); 
</script>
<?php echo $footer; ?>
