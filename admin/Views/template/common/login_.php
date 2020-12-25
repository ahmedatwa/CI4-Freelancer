<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>">
    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- Main css -->
    <link rel="stylesheet" href="assets/stylesheet/login.css" type="text/css">
</head>
<body>
    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="my-auto text-center">
                    <h2 class="form-title mt-3"> <?php echo $heading_title; ?></h2>
                </div>
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="assets/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="<?php echo $forgot; ?>" class="text-dark"><i class="fas fa-unlock-alt"></i> <?php echo $text_forget_password; ?></a>
                    </div>
                    <div class="signin-form">
                        <?php if ($success) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $success; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if ($warning) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $warning; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <form action="<?php echo $action; ?>" method="post" encrypt="multipart/form-data" accept-charset="utf-8">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>" value="<?php echo $email; ?>">
                                <?php echo form_error('email');?>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>" value="<?php echo $password; ?>">
                                <?php echo form_error('password');?>
                            </div>
                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>