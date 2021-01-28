<?php echo $header; ?>
<div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" id="login-in-container" style="padding-bottom: 100px; padding-top: 100px">
              <div id="error" class="col-12"></div>
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="assets/images/forgot.jpg" alt="IMG">
                </div>
                <form class="login100-form" id="form-forgot">
                    <span class="login100-form-title" id="form-title">
                        <?php echo $heading_title; ?>
                    </span>
                    <div class="wrap-input100 ">
                        <input class="form-control input100" type="text" name="email" id="input-email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="button-forgot" type="button">
                            <i class="fas fa-sign-in-alt mr-1"></i> <?php echo $button_reset; ?>
                        </button>
                    </div>
                    <div class="text-center p-t-12">
                        <a class="txt1" href="<?php echo $cancel; ?>">
                            <i class="fas fa-reply"></i> Cancel</a>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<?php echo $footer; ?>
<script type="text/javascript">
$('#button-forgot').on('click', function() {
    var node = this;
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
                $('#error').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error_record'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
            }

            if (json['throttler']) {
                $('#error').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['throttler'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') 
            }

            if (json['success']) {
                $('#form-forgot').before('<div class="d-flex justify-content-center"><div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div></div><span class="mt-3 d-flex justify-content-center">' + json['success'] + '</span>');

                setTimeout(function() { 
                    $('#form-forgot input').prop('disabled', true);
                    $(node).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Loading...');
                    location = json['redirect'];
                }, 2000);
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            $('#error').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> Action ' + thrownError + ': <a class="text-primary" href="<?php echo $forgot; ?>"> Reload</a> for new access token to be generated! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }

    });
});
</script>