<!-- Categories sub-nav -->
<div class="container" id="navbar-header-category">
    <div class="row">
        <div class="col">
            <div class="navbar-carousel">
                <?php foreach($categories as $category) { ?>
                  <div><a class="nav-link" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></div>
              <?php } ?> 
          </div>
      </div>
  </div>
</div>
<!-- Header Container / End -->