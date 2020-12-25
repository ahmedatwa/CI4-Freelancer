<?php echo $header; ?>
<div class="container">
  <div class="row align-items-center justify-content-center h-100">
    <div id="login" class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-lock"></i> <?php echo $heading_title; ?></div>
            <div class="card-body p-3">
                <form action="" method="post" encrypt="multipart/form-data" accept-charset="utf-8" id="form-login">
                    <div class="form-group">
                    <label for=""><?php echo $entry_email; ?></label>
                        <input type="text" name="email" class="form-control" id="input-email" placeholder="<?php echo $entry_email; ?>" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                    <label for=""><?php echo $entry_password; ?></label>
                        <input type="password" name="password" class="form-control" id="input-password" placeholder="<?php echo $entry_password; ?>" value="<?php echo $password; ?>">
                    </div>
                    <div class="mt-4 text-center">
                        <button class="btn btn-primary btn-block" type="button" id="button-login"><i class="fas fa-sign-in-alt"></i> <?php echo $button_login; ?></button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="<?php echo $forgot; ?>" class="text-dark"><i class="fas fa-unlock-alt"></i> <?php echo $text_forget_password; ?></a>
                    </div>
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
$('#button-login').on('click', function() {
    $.ajax({
        url: 'index.php/common/login/authenticate',
        headers: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token-admin"]').attr('content'),
           "X-Requested-With": "XMLHttpRequest"
        },
        method: 'post',
        dataType: 'json',
        data: $('#form-login').serialize(),
        beforeSend: function() {
            $('#form-login').removeClass('is-invalid');
            $('.alert, .text-danger, .invalid-feedback').remove();
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        },
        complete: function() {
            $(this).html('<i class="fas fa-sign-in-alt"></i> <?php echo $button_login; ?>');
        },
        success: function(json) {
            if (json['validator']) {
                for (i in json['validator']) {
                    var element = $('#input-' + i);
                    element.addClass('is-invalid');
                    element.after('<div class="invalid-feedback">' + json['validator'][i] + '</div>');
                    $('#form-login').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
                }
            }

            if (json['throttler']) {
                $('#form-login').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['throttler'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') 
            }

            if (json['warning']) {
               $('#form-login').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
            }

            if (json['redirect']) {
                $('#form-login').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div><span class="mt-3 d-flex justify-content-center">Login Success: You will be redirected shortly.</span>');
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