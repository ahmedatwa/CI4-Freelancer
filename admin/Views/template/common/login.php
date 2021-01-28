<?php echo $header; ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" id="login-in-container">
              <div id="error" class="col-12"></div>
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="assets/images/img-01.png" alt="IMG">
                </div>
                <form class="login100-form" id="form-login">
                    <span class="login100-form-title" id="form-title">
                        Member Login
                    </span>
                    <div class="wrap-input100 ">
                        <input class="form-control input100" type="text" name="email" id="input-email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <input class="form-control input100" type="password" name="password" id="input-password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="button-login" type="button">
                            Login
                        </button>
                    </div>
                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" href="<?php echo $forgot; ?>">
                            Username / Password?
                        </a>
                    </div>
                    <div class="text-center p-t-136">
                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
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
<script type="text/javascript">
$('#button-login').on('click', function() {
    var node = this;
    $.ajax({
        url: 'index.php/common/login/authLogin',
        headers: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token-admin"]').attr('content'),
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
        },
        complete: function() {
            $(node).prop('disabled', false);  
        },
        success: function(json) {
            if (json['validator']) {
                for (i in json['validator']) {
                    var element = $('#input-' + i);
                    element.addClass('is-invalid');
                    element.after('<div class="invalid-feedback d-block">' + json['validator'][i] + '</div>');
                }
                $('#error').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
            }

            if (json['throttler']) {
                $('#form-title').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['throttler'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') 
            }

            if (json['warning']) {
               $('#form-title').before('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> ' + json['warning'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
            }

            if (json['redirect']) {
                $('#form-login input').prop('disabled', true);
                $('#button-login').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Loading...');
                setTimeout(function() { 
                    location = json['redirect'];
                }, 1500);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $('#error').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> Action ' + thrownError + ': Reload for new access token to be generated! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    });
});
</script>
<?php echo $footer; ?>