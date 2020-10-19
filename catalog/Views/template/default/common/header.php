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
        <span class="mmenu-trigger">
          <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </button>
        </span>
      <a class="navbar-brand" href="<?php echo $home; ?>">
        <img src="<?php echo $logo; ?>" alt="<?php echo $config_name; ?>" class="d-inline-block align-top" loading="lazy"></a>

        <nav class="navbar navbar-light d-block d-sm-none">
          <?php if (! $logged) { ?>
            <span class="navbar-text">
              <a class="m-auto" href="<?php echo $login; ?>"><?php echo $text_login; ?></a>
              <a class="ml-3" href="<?php echo $register; ?>"><?php echo $text_register; ?></a>
            </span>
          <?php } ?>
        </nav>
        <div class="collapse navbar-collapse" id="navigation">
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
          <ul class="navbar-nav">
            <li class="nav-item">
             <!-- Notifications -->
             <div class="header-notifications">
              <!-- Trigger -->
              <div class="header-notifications-trigger" >
                <a href="#"><i class="icon-feather-bell"></i><span>4</span></a>
              </div>
              <!-- Dropdown -->
              <div class="header-notifications-dropdown">
                <div class="header-notifications-headline">
                  <h4>Notifications</h4>
                </div>
                <div class="header-notifications-content">
                  <div class="header-notifications-scroll" data-simplebar>
                    <ul>
                      <!-- Notification -->
                      <li class="notifications-not-read">
                        <a href="dashboard-manage-candidates.html">
                          <span class="notification-icon"><i class="icon-material-outline-group"></i></span>
                          <span class="notification-text">
                            <strong>Michael Shannah</strong> applied for a job <span class="color">Full Stack Software Engineer</span>
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item ml-3">
           <!-- Messages -->
           <div class="header-notifications">
            <div class="header-notifications-trigger">
             <a href="#"><i class="icon-feather-mail" id="message-count"></i></a>
           </div>
           <!-- Dropdown -->
           <div class="header-notifications-dropdown">
             <div class="header-notifications-headline">
              <h4 class="mr-4">Messages</h4>
              <small class="ml-4"><a href="<?php echo $all_messages; ?>" class="btn btn-link">View All Messages</a></small>
           </div>

           <div class="header-notifications-content">
            <div class="header-notifications-scroll text-center" id="message-list" data-simplebar></div>

     </div>

   </div>
 </div> 
</li>
</ul>


<?php } ?>

</div>
<?php if ($logged) { ?>
<li class="nav-item dropdown dropdown-bubble">
  <a class="nav-link dropdown-toggle" href="#" id="headerLoginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $image; ?>" alt="<?php echo $username; ?>" class="rounded-circle" loading="lazy"> <?php echo $username; ?></a>
  <div class="dropdown-menu" aria-labelledby="headerLoginDropdown">
    <a class="dropdown-item" href="<?php echo $dashboard; ?>"><i class="fas fa-tachometer-alt"></i> <?php echo $text_dashboard; ?></a>
    <a class="dropdown-item" href="<?php echo $setting; ?>"><i class="fas fa-toolbox"></i> <?php echo $text_setting; ?></a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="<?php echo $logout; ?>"><i class="fas fa-sign-out-alt"></i> <?php echo $text_logout; ?></a>
  </div>
</li>
<?php } ?>
<div class="header-widget d-none d-sm-block">
  <a href="<?php echo $add_project; ?>" class="add-project button ripple-effect rounded"><?php echo $text_add_project; ?></a>
</div> 
</nav>  

<script type="text/javascript">

$(document).ready(function(){
 
 //updating the view with notifications using ajax
function load_unseen_notification(view = '') {

 $.ajax({
  url:'common/header/getMessages',
  data:{"view":view},
  dataType:"json",
  success:function(json) {
    if (json.length > 0) {

    for (var i = 0; json.length > i; i++) {
      if(json[i].count > 0) {
       $('#message-count').html('<span>' + json[i].count + '</span>');
     } else if(json[i].count == 0) {
       $('#message-count').hide();
     }
     html = '<ul>'
     html += '<li class="notifications-not-read">';
     html += '<a href="' + json[i].href + '">';
     html += '<span class="notification-avatar status-online"><img src="'+json[i].image+'" alt=""></span>';
     html += '<div class="notification-text">';
     html += '<strong>' + json[i].name + '</strong>';
     html += '<p class="notification-msg-text">' + json[i].message + '</p>';
     html += '<span class="color">' + json[i].date_added + '</span>';
     html += '</div>';
     html += '</a>';
     html += '</li>';
     html += '</ul>';

     $('#message-list').append(html);
     $('#message-count').show();

   }
 } else {
    $('#message-list').html('<span class="m-auto"><p class="text-center m-4"> No New Messages</p></span>');
 }
  }
 }); 
}
 
load_unseen_notification();

// load new notifications
$('.header-notifications-trigger').on('click', function(){
 $('#message-count').html('');
 $('#message-list').html('');
 load_unseen_notification('yes');
});
 
setInterval(function(){
 load_unseen_notification();
}, 5000);
 
});
// $(document).ready(function(){

//   Pusher.log = function(message) {
//     if (window.console && window.console.log) {
//       window.console.log(message);
//     }
//   };

//   var pusher = new Pusher('b4093000fa8e8cab989a', {
//       cluster: 'eu'
//     });

//   var channel = pusher.subscribe('chat-channel');

//   channel.bind('new-message-event', function(data) {
//     getTotalUnssen(data);
//   });


// function getTotalUnssen() {
//   $('#message-count').html('<span>' + data.total + '</span>');
// }

 
// $('.header-notifications-trigger').on('click', function(){
//  $.ajax({
//       url: 'common/header/getMessages',
//       dataType: 'json',
//       beforeSend: function() {
//           $('#message-list').html('<p class="text-center loading-state" id="loading-state"><i class="fas fa-spinner fa-spin"></i> loading... </p>');
//           $('#message-count').html('');
//       },
//       complete: function () {
//           $('.loading-state').remove();
//       },
//       success: function(json) {

//           for (var i = 0; json.length > i; i++) {

//           if (json[i].count) {
//                $('#message-count').html('<span>' + json[i].count + '</span>');
//            } 

//            html = '<li class="notifications-not-read">';
//            html += '<a href="' + json[i].href + '">';
//            html += '<span class="notification-avatar status-online"><img src="'+json[i].image+'" alt=""></span>';
//            html += '<div class="notification-text">';
//            html += '<strong>' + json[i].name + '</strong>';
//            html += '<p class="notification-msg-text">' + json[i].message + '</p>';
//            html += '<span class="color">' + json[i].date_added + '</span>';
//            html += '</div>';
//            html += '</a>';
//            html += '</li>';

//           $('#message-list').append(html);
//         }
//       }

//     });
 
// });
// });
 



</script>
<!-- Header Container / End -->