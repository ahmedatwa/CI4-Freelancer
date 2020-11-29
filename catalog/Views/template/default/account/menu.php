  <nav class="navbar navbar-expand navbar-dark bg-dark shadow-sm p-1 mb-5">
    <div class="collapse navbar-collapse" id="navbarDashboard">
      <ul class="navbar-nav mx-auto">
       <?php foreach ($menus as $menu) { ?>
         <?php if ($menu['children']) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="<?php echo $menu['icon']; ?>"></i> <?php echo $menu['name']; ?>
            </a>
            <div class="dropdown-menu mt-1" aria-labelledby="navbarDropdown">
              <?php foreach ($menu['children'] as $child) { ?>  
                <a class="dropdown-item" href="<?php echo $child['href']; ?>"><i class="<?php echo $child['icon']; ?>"></i> <?php echo $child['name']; ?></a>
              <?php } ?>
            </div>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo $menu['href']; ?>"><span class="d-none d-sm-inline-block"><i class="<?php echo $menu['icon']; ?>"></i></span> <?php echo $menu['name']; ?></a>
          </li>
        <?php } ?>		
      <?php } ?>    
    </ul>
  </div>
</nav>