  <nav class="navbar navbar-expand navbar-dark bg-dark shadow-sm p-1 mb-5">
    <div class="collapse navbar-collapse" id="navbarDashboard">
      <ul class="navbar-nav mx-auto">
       <?php foreach ($menus as $menu) { ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="<?php echo $menu['href']; ?>"><span class="d-none d-sm-inline-block"><i class="<?php echo $menu['icon']; ?>"></i></span> <?php echo $menu['name']; ?></a>
        </li>
      <?php } ?>		
    </ul>
  </div>
</nav>