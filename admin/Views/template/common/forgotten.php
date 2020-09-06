<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <base href="<?php echo base(); ?>">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body class="auth-body-bg">
        <div class="home-btn d-none d-sm-block">
            <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
        </div>
        <div>
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-4">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div>
                                            <div class="text-center">
                                                <div>
                                                    <a href="index.html" class="logo"><img src="assets/images/logo-dark.png" height="20" alt="logo"></a>
                                                </div>
                                                
                                                <h4 class="font-size-18 mt-4"><?php echo $textHeadingTitle; ?></h4>
                                            </div>
                                            <?php if($error) { ?>
                                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                              <?php echo $error; ?>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <?php } ?>
                                            <div class="p-2 mt-5">
                                                <form class="form-horizontal" action="<?php echo $action; ?>" method="post" encrypt="multipart/form-data" accept-charset="utf-8">
                                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                                    <div class="form-group auth-form-group-custom mb-4">
                                                        <i class="ri-mail-line auti-custom-input-icon"></i>
                                                        <label for="useremail"><?php echo $entryEmail; ?></label>
                                                        <input type="email" class="form-control" id="useremail" value="<?php echo $email; ?>" name="email">
                                                    </div>
                                                    <div class="mt-4 text-center">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit"><?php echo $buttonReset; ?></button>
                                                        <a class="btn btn-light" href="<?php echo $cancel; ?>">
                                                        <i class="fas fa-reply"></i></a>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="mt-5 text-center">
                                                <p><?php echo $textCopyright; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="authentication-bg">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>