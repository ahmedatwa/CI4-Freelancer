<!doctype html>
<html lang="<?php echo $lang; ?>" direction="<?php echo $direction; ?>">
<head>
  <title><?php echo $title; ?></title>
  <base href="<?php echo $base; ?>">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="google-signin-client_id" content="135080641897-8bvr7qigp836nhjfe8hff7jd9asdf58l.apps.googleusercontent.com">

  <!-- CSS -->
  <link rel="stylesheet" href="catalog/default/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="catalog/default/stylesheet/style.css">
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

  <script src="catalog/default/javascript/mmenu.min.js"></script>
  <script src="catalog/default/javascript/simplebar.min.js"></script>
  <script src="catalog/default/vendor/slick/slick.min.js"></script>
  <script src="catalog/default/javascript/magnific-popup.min.js"></script>
  <!-- Notify JS -->
  <script src="catalog/default/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="catalog/default/javascript/jquery.counterup.min.js"></script>
  <script src="catalog/default/vendor/select2/js/select2.min.js"></script> 
  <!-- Pusher -->
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

  <script src="catalog/default/javascript/custom.js"></script>

  <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
  <?php } ?>
</head>
<body class="grey">
  <div id="wrapper">
    <!-- Header Container-->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm bg-white ">
      <span class="mmenu-trigger mr-3">
        <button class="hamburger hamburger--collapse" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </span>
      <a class="navbar-brand" href="<?php echo $home; ?>">
        <img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>" class="d-inline-block align-top" loading="lazy"></a>
        <?php if (! $logged) { ?>
        <nav class="navbar navbar-light d-block d-sm-none">
            <span class="navbar-text">
              <a class="m-auto" href="<?php echo $login; ?>"><?php echo $text_login; ?></a>
              <a class="ml-3" href="<?php echo $register; ?>"><?php echo $text_register; ?></a>
            </span>
        </nav>
        <?php } ?>
        <div class="collapse navbar-collapse" id="navigation">
          <ul class="navbar-nav mr-auto">
            <?php foreach ($informations as $information) { ?>
             <li class="nav-item"><a class="nav-link" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
           <?php }  ?>
           <li class="nav-item dropdown has-megamenu">
            <a class="nav-link dropdown-toggle" href="<?php echo $projects; ?>" data-toggle="dropdown"><?php echo $text_projects; ?>  </a>
            <div class="dropdown-menu megamenu" role="menu">
              <div class="row">
                <?php foreach($categories as $category) { ?>
                  <div class="col-md-3">
                    <div class="col-megamenu">
                      <h4 class="title"><a class="" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></h4>
                      <ul class="list-unstyled">
                        <?php foreach ($category['children'] as $child) { ?>
                          <li><a href="<?php echo $child['href']; ?>"><i class="fas fa-angle-right"></i> <?php echo $child['name']; ?></a></li>
                        <?php } ?> 
                      </ul>
                    </div>  <!-- col-megamenu.// -->
                  </div><!-- end col-3 -->
                <?php } ?>
              </div><!-- end row --> 
            </div> <!-- dropdown-mega-menu.// -->
          </li>

           <li class="nav-item"><a class="nav-link" href="<?php echo $blog; ?>"> <?php echo $text_blog; ?></a></li>
           <li class="nav-item d-md-none "><a class="nav-link" href="<?php echo $dashoard; ?>"> <?php echo $text_dashboard; ?></a></li>
           <li class="nav-item d-md-none"><a class="nav-link" href="<?php echo $account_project; ?>"> <?php echo $text_my_projects; ?></a></li>
           <li class="nav-item d-md-none"><a class="nav-link" href="<?php echo $account_message; ?>"> <?php echo $text_messages; ?></a></li>
           <li class="nav-item d-md-none"><a class="nav-link" href="<?php echo $account_review; ?>"> <?php echo $text_reviews; ?></a></li>
         </ul>
         <?php if (! $logged) { ?>
           <ul class="navbar-nav">
             <li class="nav-item d-none d-md-block"><a class="nav-link" href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
             <li class="nav-item d-none d-md-block"><a class="nav-link btn btn-outline-light" href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
           </ul>
         <?php } else { ?>
          <ul class="navbar-nav">
            <li class="nav-item ml-3">
             <div class="header-notifications">
              <div class="header-notifications-trigger">
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
<?php } ?>
</div>
<?php if ($logged) { ?>
<li class="nav-item dropdown dropdown-bubble">
  <a class="nav-link dropdown-toggle" href="#" id="headerLoginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="<?php echo $image; ?>" alt="<?php echo $username; ?>" class="rounded-circle" width="42px" height="42px" loading="lazy"> <?php echo $username; ?></a>
    <div class="row justify-content-md-center">
      <div class="dropdown-menu multi-column" aria-labelledby="headerLoginDropdown">

      <div class="multi-column-dropdown col-6 border-right">
      <h4><?php echo $text_finance; ?></h4>
      <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $balance; ?>"> <?php echo $text_balances; ?> <span class="badge badge-secondary"><?php echo $customer_balance; ?></span></a>
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
<div class="header-widget d-none d-sm-block ml-3">
  <a href="<?php echo $add_project; ?>" class="add-project button ripple-effect rounded"><?php echo $text_add_project; ?></a>
</div> 
</nav>  
<!-- Header Container / End -->