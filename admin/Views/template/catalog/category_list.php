<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header"> <!-- Page Header Begin -->
      <div class="container-fluid">
        <div class="float-right">
            <a href="<?php echo $add; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_add; ?>"><i class="fas fa-plus"></i></a>
            <button type="button" id="button-delete" data-toggle="tooltip" data-placement="top" class="btn btn-danger" title="<?php echo $button_delete;?>" disabled><i class="fa fa-trash"></i></button></div>
            <h1><?php echo $heading_title; ?></h1>
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
</div> <!-- Page Heaedr End -->
<div class="container-fluid mb-3"> <!-- Search ./ -->
 <div class="alert alert-info" role="alert"><i class="fas fa-info-circle"></i> <?php echo $help_list; ?></div>
  <div class="card">
      <div class="card-body row">
        <div class="col-6">
            <div class="form-group">
                <label for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" class="form-control" name="filter_name" placeholder="<?php echo $entry_name; ?>">
            </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="input_status"><?php echo $entry_status; ?></label>
            <select name="filter_status" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <option value="Disabled"><?php echo $text_disabled; ?></option>
                <option value="Enabled"><?php echo $text_enabled; ?></option>
            </select>
        </div>
    </div>
</div>
</div>
</div> <!-- Search END./ -->
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_list; ?></div>
        <div class="card-body">
            <form class="form-horizontal" enctype="multipart/form-data" id="form-location">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="table-responsive">
                    <table id="table-location" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%" class="no-sort"><input id="selectAll" type="checkbox"
                                    onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                </th>
                                <th width="60%"><?php echo $column_name; ?></th>
                                <th><?php echo $column_status; ?></th>
                                <th><?php echo $column_sort_order; ?></th>
                                <th><?php echo $column_action; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($categories) { ?>
                                <?php foreach ($categories as $category) { ?>
                                    <tr>
                                        <th><?php if (in_array($category['category_id'], $selected)) { ?>
                                            <input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                                        <?php } else { ?>
                                            <input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" />
                                        <?php } ?>
                                    </div>
                                </th>
                                <td><?php echo $category['name']; ?></td>
                                <td><?php echo $category['status']; ?></td>
                                <td><?php echo $category['sort_order']; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo $category['edit']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>"><i class="far fa-edit"></i></a></td>
                                </tr>
                            <?php } ?>
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
var table = $('#table-location').DataTable({
    "dom": 'lrtp',
    "order":[[ 1, "asc" ]],
    "lengthMenu": [20, 25, 30]
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
<!-- // delete method -->
<script type="text/javascript">
    $('#button-delete').on('click', function(e) {
        e.preventDefault();
        swal({
            title: "<?php echo $text_confirm; ?>",
            text: "<?php echo $text_no_recover; ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "<?php echo $button_delete; ?>",
            cancelButtonText: "<?php echo $button_cancel; ?>",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '<?php echo $delete; ?>',
                    method: 'post',
                    dataType: 'json',
                    data: $("input[type=\'hidden\'], input[name^=\'selected\']:checked").serialize(),
                    success: function(json) {
                        if (json['error_warning']) {
                            swal("Error!", json['error_warning'], "error");
                        }
                        if (json['success']) {
                            setTimeout(function() {
                                swal("Success!", json['success'], "success");
                                location = json['redirect'];
                            }, 800);
                        }
                }, // success
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error!", thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText, "error");
                }
            });
        } // Confirm        
    });
});
</script>
<?php if ($success) { ?>
    <!-- Success SweetAlert -->
    <script type="text/javascript">
        swal({
            title: 'Success!',
            text: '<?php echo $success; ?>',
            type: "success",
        }); 
    </script>
<?php } ?>
<?php echo $footer; ?>
