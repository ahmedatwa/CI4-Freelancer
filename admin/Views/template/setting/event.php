<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
        <div class="float-right">
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
</div>
<div class="container-fluid">
    <div class="alert alert-info" role="alert"><i class="fas fa-info-circle"></i> <?php echo $help_list; ?></div>
    <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <div class="card">
       <div class="card-header"><i class="fas fa-list"></i> <?php echo $text_list; ?></div>
       <div class="card-body">
         <form class="form-horizontal" enctype="multipart/form-data" id="form-location"> 
             <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="table-responsive">
                <table id="table-location" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="no-sort"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                        <th><?php echo $column_code; ?></th>
                        <th><?php echo $column_trigger; ?></th>
                        <th><?php echo $column_status; ?></th>
                        <th><?php echo $column_priority; ?></th>
                        <th><?php echo $column_action; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($events) { ?>
                        <?php foreach ($events as $event) { ?>
                            <tr>
                                <th> <?php if (in_array($event['event_id'], $selected)) { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $event['event_id']; ?>" checked="checked"/>
                                <?php } else { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $event['event_id']; ?>"/>
                                    <?php } ?></th>
                                    <td><?php echo $event['code']; ?></td>
                                    <td><span class="text-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $event['description']; ?>">
                                          <i class="fas fa-info-circle"></i>
                                      </span><?php echo $event['action']; ?></td>
                                    <td><?php echo $event['status']; ?></td>
                                    <td><?php echo $event['priority']; ?></td>
                                    <td class="text-center"> 
                                      <?php if ($event['enabled']) { ?> 
                                        <a href="<?php echo $event['disable']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_disable; ?>" ><i class="fas fa-minus-circle"></i></a>
                                    <?php } else { ?>
                                        <a href="<?php echo $event['enable']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_enable; ?>" ><i class="fas fa-plus-circle"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
var table = $('#table-location').DataTable({
    "dom": 'lrtp',
    "order":[[ 1, "asc" ]],
    "lengthMenu": [20, 25, 30]
});
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
                    data: $("input[name^=\'selected\']:checked").serialize(),
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
<?php echo $footer; ?>
