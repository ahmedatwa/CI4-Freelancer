<!doctype html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="<?php echo csrf_token(); ?>" content="<?php echo csrf_hash(); ?>">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/stylesheet/stylesheet.css" type="text/css">
    <link rel="stylesheet" href="assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-sweetalert/sweetalert.css">
    <?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
   <?php } ?>
    <!-- JS -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script src="assets/javascript/common.js"></script>
</head>
<body>
<div id="container">
<nav class="navbar navbar-expand-lg" id="header-nav">
<div class="container-fluid">
    <a id="header-logo" class="navbar-header" href="<?php echo $home; ?>">
    <img src="assets/images/logo.png" alt="<?php echo $admin_panel_title; ?>" title="<?php echo $admin_panel_title; ?>" width="180" height="35" class="my-auto">
    </a>
    <button type="button" id="button-menu" class="btn btn-white"><i class="fas fa-bars"></i><span>Toggle Sidebar</span></button>
    <?php if ($logged) { ?>
    <ul class="nav ">
        <!-- Notifications DropDown-->
        <li class="nav-item d-none d-sm-block">
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" role="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i><span class="badge badge-success"><?php echo $notifications_total; ?></span></a>
          <div class="dropdown-menu" aria-labelledby="notification">
            <?php if ($notifications) { ?>
            <?php foreach ($notifications as $notification) { ?>
              <a class="dropdown-item" href="<?php echo $notification['href']; ?>">
                <?php echo $notification['name']; ?></a>
            <?php } ?> 
            <?php } else { ?>
            <a class="dropdown-item" href="javascript:void(0)"><?php echo $text_no_notification; ?></a>
           <?php } ?>
          </div>
        </div>
       </li>
        <!-- Notifications DropDown-->
        <li class="nav-item">
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" role="button" id="mainDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo $image; ?>" alt="<?php echo $firstname . " " . $lastname; ?>" title="<?php echo $username; ?>" class="rounded" width="45" height="45" id="user-profile"> <?php echo $firstname . " " . $lastname; ?> <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu" aria-labelledby="mainDropdown">
            <a class="dropdown-item" href="<?php echo $profile; ?>">
            <i class="fas fa-user-circle"></i> <?php echo $text_profile; ?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $site; ?>" target="_blank"><i class="fas fa-home"></i> <?php echo $text_site; ?></a>
            <a class="dropdown-item" href="<?php echo $setting; ?>"><i class="fas fa-cog"></i> <?php echo $text_setting; ?></a>
          </div>
        </div>
       </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $logout; ?>">
            <i class="fas fa-sign-out-alt"></i> <?php echo $text_logout; ?></a>
        </li>
         </ul>
        <?php } ?>
 </div>       
</nav>
