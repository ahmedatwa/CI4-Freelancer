<?php echo $header; ?>
<div class="container my-4 overflow-hidden">
    <div class="d-flex align-items-center justify-content-center">
        <div class="card w-75 shadow-sm bg-white rounded" style="margin-top:70px;">
            <div class="card-header">
                <i class="fas fa-undo"></i> <?php echo $heading_title; ?>
            </div>
            <div class="card-body p-auto my-4">
                <div class="row no-gutters h-100">
                    <div class="col">
                     <div class="login100-pic js-tilt" data-tilt>
                        <img src="assets/images/forgot.png" alt="IMG" style="width: 60%">
                    </div>
                </div>
                <div class="col">
                    <form class="login100-form" id="form-forgot">
                      <div class="form-group">
                        <label for="input-email" class="font-weight-bold"><?php echo $text_email; ?></label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-email"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>" aria-label="email" aria-describedby="basic-email">
                    </div>
                </div>
                <div class="float-right">
                <button type="button" class="btn btn-success text-center" id="button-forgot"><i class="fas fa-sign-in-alt mr-1"></i> <?php echo $button_reset; ?></button>
                <a role="button" href="<?php echo $cancel; ?>" class="btn btn-light"><i class="fas fa-reply"></i></a>
            </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$('#button-forgot').on('click', function() {
    var node = this;
    $.ajax({
        url: 'index.php/common/forgotten/resetPassword',
        headers: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token-admin"]').attr('content'),
           "X-Requested-With": "XMLHttpRequest"
        },
        method: 'POST',
        dataType: 'json',
        data: $('#form-forgot').serialize(),
        beforeSend: function() {
            $('#form-forgot').removeClass('is-invalid');
            $('.alert, .text-danger, .invalid-feedback').remove();
            $(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        },
        complete: function() {
            $(node).html('<i class="fas fa-sign-in-alt"></i> <?php echo $button_reset; ?>');
        },
        success: function(json) {
            if (json['error']) {
                $('#input-email').addClass('is-invalid');
                $('#input-email').after('<div class="invalid-feedback">' + json['error'] + '</div>');
            }

            if (json['error_record']) {
                $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error_record'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
            }

            if (json['throttler']) {
                $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['throttler'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') 
            }

            if (json['success']) {
                location = json['redirect'];
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> Action ' + thrownError + ': <a class="text-primary" href="<?php echo $forgot; ?>"> Reload</a> for new access token to be generated! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }

    });
});
</script>
<script type="text/javascript">
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<?php echo $footer; ?>