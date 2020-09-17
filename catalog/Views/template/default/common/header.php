<!doctype html>
<html lang="<?php echo $lang; ?>" direction="<?php echo $direction; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="catalog/default/stylesheet/style.css">
<link rel="stylesheet" href="catalog/default/stylesheet/colors/blue.css">
<link rel="stylesheet" href="catalog/default/vendor/bootstrap/css/bootstrap.min.css">

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
                    <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $name; ?>"></a>
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
                <div class="header-widget">
                    <a href="<?php echo $login; ?>" class="log-in-button margin-left-5"><span><?php echo $text_login; ?></span> | </a>
                    <a href="<?php echo $register; ?>" class="log-in-button margin-left-5"><span><?php echo $text_register; ?></span></a>
                </div>
                <!-- Mobile Navigation Button -->
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
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