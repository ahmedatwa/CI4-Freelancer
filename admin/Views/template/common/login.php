<?php echo $header; ?>
<div class="container my-4 overflow-hidden">
    <div class="d-flex align-items-center justify-content-center">
        <div class="card w-75 shadow-sm bg-white rounded" style="margin-top:70px;">
            <div class="card-header mb-1">
                <i class="fas fa-lock"></i> <?php echo $text_title; ?>
            </div>
            <div class="card-body p-auto my-4">
                <div class="row no-gutters h-100">
                    <div class="col">
                       <div class="login100-pic js-tilt" data-tilt>
                        <img src="assets/images/img-01.png" alt="IMG">
                    </div>
                </div>
                <div class="col">
                    <form id="form-login">
                        <div class="form-group">
                            <label for="input-email" class="font-weight-bold"><?php echo $text_email; ?></label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-email"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>" aria-label="email" aria-describedby="basic-email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-password" class="font-weight-bold"><?php echo $text_password; ?></label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-password"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>" aria-label="password" aria-describedby="basic-password">
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-block text-center" id="button-login"><i class="fas fa-sign-in-alt mr-1"></i> <?php echo $button_login; ?></button>
                <p class="text-center mt-3"><i class="fas fa-key"></i> <?php echo $forgot; ?></p>
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
            </form>
        </div>
    </div>
   </div>
  </div>
 </div>
</div>
<script type="text/javascript">
$('#button-login').on('click', function() {
    var node = this;
    $.ajax({
        url: 'index.php/common/login/authLogin',
        headers: {
           "X-CSRF-TOKEN": $('meta[name="<?= csrf_token() ?>"]').attr('content'),
           "X-Requested-With": "XMLHttpRequest",
           'Content-Type': 'application/x-www-form-urlencoded',
        },
        method: 'post',
        dataType: 'json',
        data: $('#form-login').serialize(),
        beforeSend: function() {
            $('#form-login').removeClass('is-invalid');
            $('.alert, .text-danger, .invalid-feedback').remove();
            $(node).prop('disabled', true);
            $(node).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');     
        },
        complete: function() {
            $(node).prop('disabled', false); 
            $(node).html('<i class="fas fa-sign-in-alt"></i> <?php echo $button_login; ?>'); 
        },
        success: function(json) {
            if (json['validator']) {
                for (i in json['validator']) {
                    var element = $('#input-' + i);
                    element.addClass('is-invalid');
                    element.after('<div class="invalid-feedback d-block">' + json['validator'][i] + '</div>');
                }
                $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
            }

            if (json['throttler']) {
                $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['throttler'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') 
            }

            if (json['warning']) {
               $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
            }

            if (json['redirect']) {
                location = json['redirect'];
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $('.card-header').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> Action ' + thrownError + ': <a class="text-primary" href="<?php echo $login; ?>">Reload</a> for new access token to be generated! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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