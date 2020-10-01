<!doctype html>
<html lang="<?php echo $lang; ?>" direction="<?php echo $direction; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="catalog/default/stylesheet/style.css">
<link rel="stylesheet" href="catalog/default/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="catalog/default/vendor/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="catalog/default/javascript/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="catalog/default/stylesheet/colors/blue.css">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<!-- Scripts -->
<script src="catalog/default/javascript/jquery-3.5.1.min.js"></script>
<script src="catalog/default/javascript/jquery-ui/jquery-ui.min.js"></script>
<script src="catalog/default/javascript/moment.js"></script>
<script src="catalog/default/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="catalog/default/javascript/mmenu.min.js"></script>
<script src="catalog/default/javascript/simplebar.min.js"></script>
<script src="catalog/default/javascript/snackbar.js"></script>
<script src="catalog/default/javascript/counterup.min.js"></script>
<script src="catalog/default/javascript/magnific-popup.min.js"></script>
<script src="catalog/default/javascript/slick.min.js"></script>
<script src="catalog/default/javascript/custom.js"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
</head>
<body>
<div id="wrapper">
<!-- Header Container-->
<header id="header-container" class="fullwidth transparent">
    <!-- Header -->
    <div id="header">
        <div class="container-fluid">
            <!-- Left Side Content -->
            <div class="left-side">
                <!-- Logo -->
                <div id="logo">
                    <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>"></a>
                </div>
                <!-- Main Navigation -->
                <nav id="navigation" class="">
                    <ul id="responsive">
                        <li><a href="<?php echo $how_it_works; ?>"><?php echo $text_how_it_works; ?></a></li>
                        <li><a href="<?php echo $projects; ?>"> <?php echo $text_projects; ?></a></li>
                        <li><a href="<?php echo $blog; ?>"> <?php echo $text_blog; ?></a></li>
                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->
            </div>
            <!-- Left Side Content / End -->
            <!-- Right Side Content / End -->
            <div class="right-side">
                
                <?php if ($logged) { ?>
                    <div class="header-notifications user-menu">
                        <div class="header-notifications-trigger">
                            <a href="#"><div class="user-avatar status-online"><img src="<?php echo $image; ?>" alt=""></div></a>
                        </div>
                        <div class="header-notifications-dropdown">
                            <div class="user-status">
                                <div class="user-details">
                                    <div class="user-avatar status-online"><img src="<?php echo $image; ?>" alt=""></div>
                                    <div class="user-name">
                                        <?php echo $username; ?>
                                    </div>
                                </div>
<!--                                 <div class="status-switch" id="snackbar-user-status">
                                    <label class="user-online current-status">Online</label>
                                    <label class="user-invisible">Invisible</label>
                                    <span class="status-indicator" aria-hidden="true"></span>
                                </div>   -->
                        </div>
                        
                        <ul class="user-menu-small-nav">
                            <li><a href="<?php echo $dashboard; ?>"><i class="icon-material-outline-dashboard"></i> <?php echo $text_dashboard; ?></a></li>
                            <li><a href="<?php echo $setting; ?>"><i class="icon-material-outline-settings"></i> <?php echo $text_setting; ?></a></li>
                            <li><a href="<?php echo $logout; ?>"><i class="icon-material-outline-power-settings-new"></i> <?php echo $text_logout; ?></a></li>
                        </ul>

                        </div>
                    </div>
                   
                 <?php } else { ?>   
                <div class="header-widget">
                    <a href="<?php echo $login; ?>" class="btn btn-link log-in-button margin-left-100"><?php echo $text_login; ?></a>
                    <a href="<?php echo $register; ?>" class="btn btn-link log-in-button"><?php echo $text_register; ?></a>
                </div> 
                <?php } ?>
                 <div class="header-widget d-none d-sm-block">
                    <a href="<?php echo $add_project; ?>" class="add-project btn btn-primary ripple-effect rounded"><?php echo $text_add_project; ?></a>
                </div> 
                <!-- Mobile Navigation Button -->
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button" id="button-search">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>
            </div>
            <!-- Right Side Content / End -->
        </div>
    </div>
    <!-- Header / End -->
</header>
<div class="clearfix"></div>
<!-- Header Container / End -->