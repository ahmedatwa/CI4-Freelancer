  <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-none d-md-none d-lg-block">
    <div class="collapse navbar-collapse" id="navbarDashboard">
      <ul class="navbar-nav mx-auto">
       <?php foreach ($menus as $menu) { ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="<?php echo $menu['href']; ?>"><?php echo $menu['name']; ?></a>
        </li>
      <?php } ?>		
    </ul>
  </div>
</nav>

