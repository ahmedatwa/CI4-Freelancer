<!-- Category Boxes -->
<div class="section margin-top-65">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="section-headline centered margin-bottom-15">
          <h3><?php echo $heading_title; ?></h3>
        </div>
        
        <div class="categories-container">
          <?php foreach ($categories as $category) { ?>
          <a href="<?php echo $category['href']; ?>" class="category-box">
            <div class="category-box-icon">
              <i class="<?php echo $category['icon']; ?>"></i>
            </div>
            <div class="category-box-counter"><?php echo $category['total']; ?></div>
            <div class="category-box-content">
              <h3><?php echo $category['name']; ?></h3>
              <p>Software Engineer, Web / Mobile Developer & More</p>
            </div>
          </a>
          <?php } ?>
        </div>

      </div>
    </div>
  </div>
</div>