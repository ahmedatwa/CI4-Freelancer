<!doctype html>
<html lang="<?php echo $lang; ?>" direction="<?php echo $direction; ?>">
<head>
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="catalog/default/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="catalog/default/stylesheet/style.css">
    <link rel="stylesheet" href="catalog/default/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="catalog/default/javascript/jquery-ui/jquery-ui.css">
    <!-- Animate -->
    <link href="catalog/default/vendor/animate/animate.min.css" rel="stylesheet" type="text/css">
    <!-- Select2 -->
    <link href="catalog/default/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="catalog/default/vendor/select2/css/select2-bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="catalog/default/stylesheet/colors/red.css">
    <?php foreach ($styles as $style) { ?>
        <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>

    <!-- Scripts -->
    <script src="catalog/default/javascript/jquery-3.5.1.min.js"></script>
    <script src="catalog/default/javascript/jquery-ui/jquery-ui.js"></script>
    <script src="catalog/default/javascript/moment.js"></script>
    <script src="catalog/default/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="catalog/default/vendor/bootstrap-slider/dist/bootstrap-slider.min.js"></script> 

    <script src="catalog/default/vendor/mmenu-js/mmenu.js"></script>
    <script src="catalog/default/javascript/simplebar.min.js"></script>
    <script src="catalog/default/vendor/slick/slick.min.js"></script>
    <script src="catalog/default/javascript/magnific-popup.min.js"></script>
    <!-- Notify JS -->
    <script src="catalog/default/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="catalog/default/javascript/jquery.counterup.min.js"></script>
    <script src="catalog/default/vendor/select2/js/select2.min.js"></script> 

    <script src="catalog/default/javascript/custom.js"></script>

    <?php foreach ($scripts as $script) { ?>
        <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>
</head>
<body class="grey">
    <div id="wrapper">
        <!-- Header Container-->
        <header id="header-container" class="fullwidth transparent">
            <!-- Header -->
            <nav class="navbar navbar-expand-lg navbar-light shadow-sm bg-white">
                <a class="navbar-brand" href="<?php echo $home; ?>">
                    <img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>" class="d-inline-block align-top" loading="lazy"></a>
                     <ul class="navbar-nav d-block d-sm-none">
                        <li class="nav-item"><a class="nav-link" href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
                    </ul>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <?php foreach ($informations as $information) { ?>
                               <li class="nav-item"><a class="nav-link" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                           <?php }  ?>
                           <li class="nav-item"><a class="nav-link" href="<?php echo $projects; ?>"> <?php echo $text_projects; ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo $blog; ?>"> <?php echo $text_blog; ?></a></li>
                       </ul>
                       <?php if (! $logged) { ?>
                       <ul class="navbar-nav">
                           <li class="nav-item d-none d-md-block"><a class="nav-link" href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
                           <li class="nav-item d-none d-md-block"><a class="nav-link" href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
                       </ul>
                       <?php } else { ?>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="headerLoginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $image; ?>" alt="<?php echo $username; ?>" class="rounded-circle" loading="lazy"> <?php echo $username; ?>   
                          </a>
                          <div class="dropdown-menu" aria-labelledby="headerLoginDropdown">
                              <a class="dropdown-item" href="<?php echo $dashboard; ?>"><i class="fas fa-tachometer-alt"></i> <?php echo $text_dashboard; ?></a>
                              <a class="dropdown-item" href="<?php echo $setting; ?>"><i class="fas fa-toolbox"></i> <?php echo $text_setting; ?></a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo $text_logout; ?>"><i class="fas fa-sign-out-alt"></i> <?php echo $text_logout; ?></a>
                          </div>
                      </li>
                     <?php } ?>
                      <div class="header-widget d-none d-sm-block">
                        <a href="<?php echo $add_project; ?>" class="add-project button ripple-effect rounded"><?php echo $text_add_project; ?></a>
                    </div> 
                </div>

            </nav>
        </header>
                
<!-- Header Container / End -->