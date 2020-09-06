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
</div>
<!-- Page Heaedr End -->
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
                        <th width="1%" class="no-sort"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                        <th width="80%"><?php echo $column_name ?></th>
                        <th><?php echo $column_action; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($layouts) { ?>
                        <?php foreach ($layouts as $layout) { ?>
                            <tr>
                                <th> <?php if (in_array($layout['layout_id'], $selected)) { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $layout['layout_id']; ?>" checked="checked"/>
                                <?php } else { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $layout['layout_id']; ?>"/>
                                    <?php } ?> </div></th>
                                    <td><?php echo $layout['name']; ?></td>
                                    <td class="text-center">  
                                        <a href="<?php echo $layout['edit']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>" ><i class="far fa-edit"></i></a></td>
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
    "lengthMenu": [15, 20, 25, 30]
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
            swal("Error!", thrownError , "error");
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
