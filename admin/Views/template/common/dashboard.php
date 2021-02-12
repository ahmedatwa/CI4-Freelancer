<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
             <h1><?php echo $heading_dashboard; ?> </h1>
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
  <div class="container-fluid dashboard-tiles">
    <?php if ($error_install) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error_install; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

        <div id="dashboard-tiles">                            
        <div class="row">
        <?php foreach($dashboards as $dashboard) { ?>
                <div class="col-<?php echo $dashboard['width']; ?>">
                    <?php echo $dashboard['output']; ?>
                </div>
            
        <?php } ?> 
        </div>
       </div> 
    </div><!-- container-fluid -->
</div>
<?php echo $footer; ?>
<script type="text/javascript">
$(document).on('click', '#delete-install-button', function(e) {
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
        url: 'common/dashboard/removeInstall?user_token=<?php echo $user_token; ?>',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token_admin"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'post',
        dataType: 'json',
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