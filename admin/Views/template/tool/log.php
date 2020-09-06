<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
        <div class="float-right">
            <button type="button" class="btn btn-danger" id="button-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $text_delete; ?>" form="log-form"><i class="far fa-trash-alt"></i></button></div>
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
            <textarea wrap="off" rows="20" readonly class="form-control"><?php echo $log; ?></textarea>
          </form>
        </div><!-- Card Body -->
    </div><!-- Card -->
</div><!-- container-fluid -->
</div>
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
                    data: $("input[type=\'hidden\']"),
                    success: function(json) {
                        if (json["error_warning"]) {
                            swal("Warning!", json['error_warning'], "error")
                        }
                        if (json['success']) {
                            setTimeout(function () {
                                swal("Success!",  json['success'], "success");
                                location = json['redirect'];
                            }, 1000);
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
