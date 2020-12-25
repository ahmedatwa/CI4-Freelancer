<?php echo $header; ?>
<div class="container">
  <div class="row align-items-center justify-content-center h-100">
    <div id="login" class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-lock"></i> <?php echo $heading_title; ?></div>
            <div class="card-body p-3">
            <form class="form-horizontal" action="" method="" encrypt="multipart/form-data" accept-charset="utf-8" id="form-forgot">
                <div class="form-group auth-form-group-custom mb-4">
                    <i class="ri-mail-line auti-custom-input-icon"></i>
                    <label for="useremail"><?php echo $entry_email; ?></label>
                    <input type="email" class="form-control" id="input-email" name="email">
                </div>
                <div class="mt-4 text-center">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="button" id="button-forgot"><i class="fas fa-sign-in-alt"></i> <?php echo $button_reset; ?></button>
                    <a class="btn btn-light" href="<?php echo $cancel; ?>">
                        <i class="fas fa-reply"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
$('#button-forgot').on('click', function() {
    $.ajax({
        url: 'index.php/common/forgotten/resetPassword',
        headers: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token-admin"]').attr('content'),
           "X-Requested-With": "XMLHttpRequest"
        },
        method: 'post',
        dataType: 'json',
        data: $('#form-forgot').serialize(),
        beforeSend: function() {
            $('#form-forgot').removeClass('is-invalid');
            $('.alert, .text-danger, .invalid-feedback').remove();
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        },
        complete: function() {
            $(this).html('<i class="fas fa-sign-in-alt"></i> <?php echo $button_reset; ?>');
        },
        success: function(json) {
            if (json['error']) {
                $('#input-email').addClass('is-invalid');
                $('#input-email').after('<div class="invalid-feedback">' + json['error'] + '</div>');
            }

            if (json['error_record']) {
                $('#form-forgot').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error_record'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
            }

            if (json['throttler']) {
                $('#form-forgot').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['throttler'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') 
            }


            if (json['success']) {
                console.log(json['redirect'])
                $('#form-forgot').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                setTimeout(function() { 
                    location.reload(json['redirect']);
                }, 2000);
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }

    });
});
</script>