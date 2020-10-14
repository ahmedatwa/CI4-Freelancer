<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
    	<?php foreach ($menus as $menu) { ?>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo $menu['href']; ?>"><?php echo $menu['name']; ?></a>
      </li>
      <?php } ?>		
    </ul>
  </div>
</nav>


