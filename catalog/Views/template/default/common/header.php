<!doctype html>
<html lang="<?php echo $lang; ?>" direction="<?php echo $direction; ?>">
<head>
  <title><?php echo $title; ?></title>
  <base href="<?php echo $base; ?>">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="<?php echo csrf_token(); ?>" content="<?php echo csrf_hash(); ?>">
  <meta name="google-signin-client_id" content="135080641897-8bvr7qigp836nhjfe8hff7jd9asdf58l.apps.googleusercontent.com">
  <!-- CSS -->
  <link rel="stylesheet" href="catalog/default/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="catalog/default/stylesheet/stylesheet.css">
  <link rel="stylesheet" href="catalog/default/vendor/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="catalog/default/javascript/jquery-ui/jquery-ui.css">
  <!-- Animate -->
  <link href="catalog/default/vendor/animate/animate.min.css" rel="stylesheet" type="text/css">
  <!-- Select2 -->
  <link href="catalog/default/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="catalog/default/vendor/select2/css/select2-bootstrap4.min.css" rel="stylesheet" type="text/css">
  <!-- Color Scheme -->
  <link rel="stylesheet" href="catalog/default/stylesheet/colors/<?php echo $defaut_color_scheme; ?>">
  <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
  <?php } ?>
  <!-- Scripts -->
  <script src="catalog/default/javascript/jquery-3.5.1.min.js"></script>
  <script src="catalog/default/javascript/jquery-ui/jquery-ui.js"></script>
  <script src="catalog/default/javascript/moment.js"></script>
  <script src="catalog/default/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="catalog/default/vendor/bootstrap-slider/dist/bootstrap-slider.min.js"></script> 

  <script src="catalog/default/javascript/simplebar.min.js"></script>
  <script src="catalog/default/vendor/slick/slick.min.js"></script>
  <script src="catalog/default/javascript/magnific-popup.min.js"></script>
  <!-- Notify JS -->
  <script src="catalog/default/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="catalog/default/javascript/jquery.counterup.min.js"></script>
  <script src="catalog/default/vendor/select2/js/select2.min.js"></script> 
  <script src="catalog/default/vendor/bootbox/bootbox.min.js"></script> 

  <!-- Pusher -->
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script src="catalog/default/javascript/common.js"></script>

  <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
  <?php } ?>
</head>
<body class="grey">
  <div id="wrapper">
    <b class="screen-overlay"></b>
 <nav class="navbar navbar-expand navbar-light bg-white d-lg-none">
  <!-- Mobile Menu Trigger -->
    <button data-trigger="#navbar_main" class="d-lg-none btn btn-light bg-white border border-white ml-0" type="button"><i class="fas fa-bars"></i></button>
    <!-- Logo -->
    <a class="navbar-brand pt-0 ml-3" href="<?php echo $home; ?>">
      <img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>" class="d-inline-block align-top" loading="lazy">
    </a>
    <!-- ./Logo -->
    <ul class="navbar-nav ml-auto">
      <?php if (! $logged) { ?>
        <li class="nav-item"><a class="nav-link" href="<?php echo $login; ?>"><?php echo $text_login; ?> </a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $register; ?>"> <?php echo $text_register; ?> </a></li>
      <?php } else { ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="headerLoginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img src="<?php echo $image; ?>" alt="<?php echo $username; ?>" class="rounded-circle" width="42px" height="42px" loading="lazy"> <?php echo $username; ?></a>
      <div class="row justify-content-md-center">
        <div class="dropdown-menu multi-column" aria-labelledby="headerLoginDropdown">
          <div class="multi-column-dropdown col-6 border-right">
            <h4><?php echo $text_finance; ?></h4>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0);"> <?php echo $text_balances; ?> <span class="badge badge-secondary"><?php echo $customer_balance; ?></span></a>
            <a class="dropdown-item" href="<?php echo $deposit; ?>"> <?php echo $text_deposite_funds; ?></a>
            <a class="dropdown-item" href="<?php echo $withdraw; ?>"> <?php echo $text_withdraw_funds; ?></a>
          </div>
          <div class="multi-column-dropdown col-6">
            <h4><?php echo $text_account; ?></h4>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $dashboard; ?>"> <?php echo $text_dashboard; ?></a>
            <a class="dropdown-item" href="<?php echo $setting; ?>"> <?php echo $text_setting; ?></a>
            <a class="dropdown-item" href="<?php echo $profile; ?>"> <?php echo $text_profile; ?></a>
            <a role="button" id="button-logout" class="dropdown-item"> <?php echo $text_logout; ?></a>
          </div>
        </div>
      </div>
    </li>
  <?php } ?>
  </ul>
</nav>
<!-- Main Nav -->
 <nav id="navbar_main" class="mobile-offcanvas navbar navbar-expand-lg navbar-light p-sm-0 bg-white">
  <div class="offcanvas-header p-2">  
    <button type="button" class="close btn-close" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="py-2 text-white text-center"></h5>
  </div>
<!-- Logo -->
<a class="navbar-brand pt-0 d-none d-lg-block ml-3" href="<?php echo $home; ?>">
 <img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>" class="d-inline-block align-top" loading="lazy"></a>
 <!-- Logo End -->
 <ul class="navbar-nav p-md-2">
  <?php foreach ($informations as $information) { ?>
   <li class="nav-item"><a class="nav-link" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
 <?php }  ?>
 <li class="nav-item"><a class="nav-link" href="<?php echo $blog; ?>"> <?php echo $text_blog; ?></a></li>
<li><a class="nav-link" href="<?php echo $projects; ?>"><?php echo $text_projects; ?></a></li>
<?php if($logged) { ?>
<ul class="list-unstyled d-lg-none mt-3">
  <h3>freelancer</h3>
   <div class="dropdown-divider"></div>
  <li class="ml-4"><a class="nav-link" href="<?php echo $dashboard; ?>"><i class="fas fa-angle-right"></i> <?php echo $text_dashboard; ?></a></li>
  <li class="ml-4"><a class="nav-link" href="<?php echo $my_projects; ?>"><i class="fas fa-angle-right"></i> <?php echo $text_my_projects; ?></a></li>
  <li class="ml-4"><a class="nav-link" href="<?php echo $messages; ?>"><i class="fas fa-angle-right"></i> <?php echo $text_messages; ?></a></li>
  <li class="ml-4"><a class="nav-link" href="<?php echo $reviews; ?>"><i class="fas fa-angle-right"></i> <?php echo $text_reviews; ?></a></li>
</ul>
<?php } ?>
</ul>
<ul class="navbar-nav ml-auto mr-3" id="nav-user-main">
    <?php if (! $logged) { ?>
      <li class="nav-item d-none d-lg-block"><a class="nav-link" href="<?php echo $login; ?>"><?php echo $text_login; ?> </a></li>
      <li class="nav-item d-none d-lg-block"><a class="nav-link" href="<?php echo $register; ?>"> <?php echo $text_register; ?> </a></li>
    <?php } else { ?>
      <!-- Messages -->
      <ul class="navbar-nav">
            <li class="nav-item ml-3 d-none d-lg-block">
            <div class="header-notifications">
            <!-- Trigger -->
            <div class="header-notifications-trigger" id="header-notifications">
              <a href="#"><i class="icon-feather-bell" id="notifications-count"></i></a>
            </div>
            <!-- Dropdown -->
            <div class="header-notifications-dropdown">
              <div class="header-notifications-headline" id="notifications-read">
                <h4>Notifications</h4>
                <button id="mark-read-button" type="button" class="btn btn-danger btn-sm float-right" title="Mark all as read" data-placement="left" data-toggle="tooltip">
                  <i class="icon-feather-check-square"></i>
                </button>
              </div>

              <div class="header-notifications-content">
                <div class="header-notifications-scroll" data-simplebar>
                 <ul id="notifications-list"></ul>
                </div>
              </div>
            </div>
          </div>
             <div class="header-notifications">
              <div class="header-notifications-trigger" id="header-messages">
               <a href="#"><i class="icon-feather-mail" id="message-count"></i></a>
             </div>
             <div class="header-notifications-dropdown">
               <div class="header-notifications-headline">
                <h4 class="mr-4">Messages</h4>
                <small class="ml-4"><a href="<?php echo $all_messages; ?>" class="btn btn-link">View All Messages</a></small>
              </div>
              <div class="header-notifications-content">
                <div class="header-notifications-scroll text-center" data-simplebar>
                  <ul id="message-list"></ul>
                </div>
              </div>
            </div>
          </div> 
        </li>
      </ul>
      <!-- Messages -->
      <li class="nav-item dropdown d-none d-lg-block">
        <a class="nav-link dropdown-toggle" href="#" id="headerLoginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?php echo $image; ?>" alt="<?php echo $username; ?>" class="rounded-circle" width="42px" height="42px" loading="lazy"> <?php echo $username; ?>
        </a>
          <div class="row justify-content-md-center">
            <div class="dropdown-menu multi-column" aria-labelledby="headerLoginDropdown">
              <div class="multi-column-dropdown col-6 border-right">
                <h4><?php echo $text_finance; ?></h4>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);"> <?php echo $text_balances; ?> <span class="badge badge-secondary"><?php echo $customer_balance; ?></span></a>
                <a class="dropdown-item" href="<?php echo $deposit; ?>"> <?php echo $text_deposite_funds; ?></a>
                <a class="dropdown-item" href="<?php echo $withdraw; ?>"> <?php echo $text_withdraw_funds; ?></a>
              </div>
              <div class="multi-column-dropdown col-6">
                <h4><?php echo $text_account; ?></h4>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $dashboard; ?>"> <?php echo $text_dashboard; ?></a>
                <a class="dropdown-item" href="<?php echo $setting; ?>"> <?php echo $text_setting; ?></a>
                <a class="dropdown-item" href="<?php echo $profile; ?>"> <?php echo $text_profile; ?></a>
                <a class="dropdown-item" href="#" id="button-logout"> <?php echo $text_logout; ?></a>
              </div>
            </div>
          </div>
        </li>

      <?php } ?>
      <li class="mt-lg-2 ml-4 d-none d-lg-block"> <a role="button" href="<?php echo $add_project; ?>" class="add-project button ripple-effect rounded"><?php echo $text_add_project; ?></a></li>
    </ul>  
  </nav>
