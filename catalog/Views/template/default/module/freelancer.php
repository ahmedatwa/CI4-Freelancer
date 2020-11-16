<?php if ($freelancers) { ?>
<div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <!-- Section Headline -->
        <div class="section-headline margin-top-0 margin-bottom-25">
          <h3><?php echo $text_freelancers; ?></h3>
          <a href="<?php echo $freelancers_all; ?>" class="headline-link"><?php echo $text_all_freelancers; ?></a>
        </div>
      </div>
      <div class="col-xl-12">
        <div class="default-slick-carousel freelancers-container freelancers-grid-layout">
          <?php foreach ($freelancers as $freelancer) { ?>
          <!--Freelancer -->
          <div class="freelancer">
            <!-- Overview -->
            <div class="freelancer-overview">
              <div class="freelancer-overview-inner">
                <!-- Bookmark Icon -->
                <span class="bookmark-icon"></span>
                <!-- Avatar -->
                <div class="freelancer-avatar">
                  <div class="verified-badge"></div>
                  <a href="<?php echo $freelancer['href']; ?>"><img src="<?php echo $freelancer['image']; ?>" alt=""></a>
                </div>
                <!-- Name -->
                <div class="freelancer-name">
                  <h4><a href="<?php echo $freelancer['href']; ?>"><?php echo $freelancer['name']; ?> </a></h4>
                  <span><?php echo $freelancer['tag_line']; ?></span>
                </div>
                <!-- Rating -->
                <div class="freelancer-rating">
                <div class="rating">
                  <ul>
                    <?php for ($i=1; $i <= 5; $i++) { ?>
                      <?php if ($freelancer['rating'] < $i) { ?>
                        <li><span class="fa-stack"><i class="far fa-star fa-stack-1x"></i></span></li>
                      <?php } else { ?>
                        <li><span class="fa-stack">
                          <i class="fas fa-star fa-stack-1x"></i></span></li>
                        <?php } ?>
                      <?php } ?>
                    </ul>
                </div>
                </div>
              </div>
            </div>
            <!-- Details -->
            <div class="freelancer-details">
              <div class="freelancer-details-list mx-auto w-100">
                <div class="row">
                  <!-- <li>Location <strong><i class="icon-material-outline-location-on"></i> London</strong></li> -->
                  <div class="col pb-2">Rate:<strong> <?php echo $freelancer['rate']; ?> / hr</strong></div>
                  <div class="col pb-2">On Time:<strong> <?php echo $freelancer['success']; ?>%</strong></div>
                </div>
              </div>
              <a href="<?php echo $freelancer['href']; ?>" class="button button-sliding-icon ripple-effect"><?php echo $text_view_profile;?> <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
          </div>
          <!-- Freelancer / End -->
        <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>