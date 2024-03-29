<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
        <div class="float-right">
            <a href="<?php echo $add; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_add; ?>"><i class="fas fa-plus"></i></a>
            <button type="button" id="button-delete" data-toggle="tooltip" data-placement="top" class="btn btn-danger" title="<?php echo $button_delete;?>" disabled><i class="fa fa-trash"></i></button>
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
            <div class="form-group">
                <label for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" class="form-control" name="filter_email" placeholder="<?php echo $entry_email; ?>">
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
            <div class="form-customer-group">
                <label for="input-customer-group"><?php echo $entry_customer_group; ?></label>
                <select name="filter_customer_group" class="form-control">
                    <option value=""><?php echo $text_select; ?></option>
                    <option value="Employer"><?php echo $text_employer; ?></option>
                    <option value="Freelancer"><?php echo $text_freelancer; ?></option>
                </select>
            </div>
        </div>
    </div>
</div>
</div> <!-- Search END./ -->
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><i class="fas fa-list"></i> <?php echo $text_list; ?></div>
        <div class="card-body">
           <form class="form-horizontal" enctype="multipart/form-data" id="form-location"> 
               <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="table-responsive">
               <table id="table-location" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%" class="no-sort"><input id="selectAll" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                        <th><?php echo $column_name; ?></th>
                        <th><?php echo $column_email; ?></th>
                        <th><?php echo $column_customer_group; ?></th>
                        <th><?php echo $column_status; ?></th>
                        <th><?php echo $column_ip; ?></th>
                        <th><?php echo $column_date_added; ?></th>
                        <th><?php echo $column_action; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($customers) { ?>
                        <?php foreach ($customers as $customer) { ?>
                            <tr>
                                <th scope="row"> <?php if (in_array($customer['customer_id'], $selected)) { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked"/>
                                <?php } else { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>"/>
                                    <?php } ?> </div></th>
                                    <td><?php echo $customer['name']; ?></td>
                                    <td><?php echo $customer['email']; ?></td>
                                    <td><?php echo $customer['customer_group']; ?></td>
                                    <td><?php echo $customer['status']; ?></td>
                                    <td><?php echo $customer['ip']; ?></td>
                                    <td><?php echo $customer['date_added']; ?></td>
                                    <td class="text-center">  
                                        <a href="<?php echo $customer['edit']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>" ><i class="far fa-edit"></i></a></td>
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
$('input[name=\'filter_email\']').on('keyup', function () {
    table.columns(2).search(this.value).draw();
});
var filter_status = $('select[name=\'filter_status\']').val();
if (filter_status !== '*') {
$('select[name=\'filter_status\']').on('change', function () {
    table.column(4).search( $(this).val()).draw();
});
}
var filter_customer_group = $('select[name=\'filter_customer_group\']').val();
if (filter_customer_group !== '*') {
$('select[name=\'filter_customer_group\']').on('change', function () {
    table.columns(3).search(this.value).draw();
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
                    method:'post',
                    dataType: 'json',
                    data: $("input[type=\'hidden\'], input[name^=\'selected\']:checked").serialize(),
                    success: function(json) {
                        if (json['error_warning']) {        
                          swal("Error!", json['error_warning'] , "error");
                      }
                      if (json['success']) {
                        setTimeout(function () {
                            swal("Success!",  json['success'], "success");
                            location = json['redirect'];
                        }, 800);
                    }
            }, // success
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText , "error");
            }
        });
    } // Confirm        
});    
    });
</script>
<?php if($success) { ?>
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
