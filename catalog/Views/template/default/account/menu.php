<nav class="navbar navbar-expand-lg navbar-dark bg-dark margin-top-10">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDashboard" aria-controls="navbarDashboard" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
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


