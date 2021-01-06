<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $text_title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="<?php echo csrf_token(); ?>" content="<?php echo csrf_hash(); ?>">
    <base href="<?php echo $base; ?>">
    <link rel="icon" type="image/png" href="assets/images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/stylesheet/util.css">
    <link rel="stylesheet" type="text/css" href="assets/stylesheet/login.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" id="container">
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
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/tilt/tilt.jquery.min.js"></script>
<script type="text/javascript">
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<script type="text/javascript">
$('#button-login').on('click', function() {
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
            $(this).prop('disabled', true);       
        },
        complete: function() {
            $(this).prop('disabled', false);  
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
                }, 2500);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + ": " + xhr.responseJSON.message + "\r\nPage will be reloaded for new access token!");
            // refresh the page for new access token
            location.reload();
        }
    });
});
</script>
</body>
</html>