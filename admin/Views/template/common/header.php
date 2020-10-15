<!doctype html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/css/stylesheet.css" type="text/css">
    <link rel="stylesheet" href="assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-sweetalert/sweetalert.css">
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script src="assets/libs/js/common.js"></script>
</head>
<body>
<div id="container">
<nav class="navbar navbar-expand-lg" id="header-nav">
<div class="container-fluid">
    <a id="header-logo" class="navbar-header" href="#">
    <img src="assets/images/logo.svg" alt="<?php echo $admin_panel_title; ?>" title="<?php echo $admin_panel_title; ?>">
    </a>
    <button type="button" id="button-menu" class="btn btn-light">
        <i class="fas fa-align-left"></i>
    <span>Toggle Sidebar</span>
    </button>
    <a class="navbar-toggler" href="#" role="button" data-toggle="collapse" data-target="#" aria-controls="" aria-expanded="false" aria-label="Toggle navigation" id="button-menu">
    <span class="navbar-toggler-icon"></span></a>
    <?php if ($logged) { ?>
    <ul class="nav justify-content-end">
        <!-- Notifications DropDown-->
        <?php if ($notifications) { ?>
        <li class="nav-item">
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" role="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i><span class="badge badge-success"><?php echo $notifications_total; ?></span></a>
          <div class="dropdown-menu" aria-labelledby="notification">
            <?php foreach ($notifications as $notification) { ?>
              <a class="dropdown-item" href="<?php echo $notification['href']; ?>">
                <?php echo $notification['name']; ?></a>
            <?php } ?> 
          </div>
        </div>
       </li>
     <?php } ?>
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
