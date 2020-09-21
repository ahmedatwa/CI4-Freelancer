<!doctype html>
<html lang="<?php echo $lang; ?>" direction="<?php echo $direction; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="catalog/default/stylesheet/style.css">
<link rel="stylesheet" href="catalog/default/stylesheet/colors/blue.css">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<!-- Scripts -->
<script src="catalog/default/javascript/jquery-3.3.1.min.js"></script>
<script src="catalog/default/javascript/jquery-migrate-3.0.0.min.js"></script>
<script src="catalog/default/javascript/mmenu.min.js"></script>
<script src="catalog/default/javascript/tippy.all.min.js"></script>
<script src="catalog/default/javascript/simplebar.min.js"></script>
<script src="catalog/default/javascript/bootstrap-slider.min.js"></script>
<script src="catalog/default/javascript/bootstrap-select.min.js"></script>
<script src="catalog/default/javascript/snackbar.js"></script>
<script src="catalog/default/javascript/clipboard.min.js"></script>
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
        <div class="container">
            <!-- Left Side Content -->
            <div class="left-side">
                <!-- Logo -->
                <div id="logo">
                    <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>"></a>
                </div>
                <!-- Main Navigation -->
                <nav id="navigation">
                    <ul id="responsive">
                        <li><a href="<?php echo $home; ?>" class="current"><?php echo $text_home; ?></a></li>
                        <li><a href="<?php echo $jobs; ?>"><?php echo $text_jobs; ?></a></li>
                        <li><a href="<?php echo $projects; ?>"> <?php echo $text_projects; ?></a></li>
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
                                <div class="status-switch" id="snackbar-user-status">
                                    <label class="user-online current-status">Online</label>
                                    <label class="user-invisible">Invisible</label>
                                    <!-- Status Indicator -->
                                    <span class="status-indicator" aria-hidden="true"></span>
                                </div>  
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
                    <a href="<?php echo $login; ?>" class="popup-with-zoom-anim log-in-button"><i class="icon-feather-log-in"></i> <span><?php echo $text_login; ?> / <?php echo $text_register; ?></span></a>
                </div> 
                <?php } ?>
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