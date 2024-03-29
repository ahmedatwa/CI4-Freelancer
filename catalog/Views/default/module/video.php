  <div class="intro-banner dark-overlay big-padding">
  
  <!-- Transparent Header Spacer -->
  <div class="transparent-header-spacer"></div>

  <div class="container">
    
    <!-- Intro Headline -->
    <div class="row">
      <div class="col-md-12">
        <div class="banner-headline-alt">
          <h3>Don't Just Dream, Do</h3>
          <span>Find the best jobs in the digital industry</span>
        </div>
      </div>
    </div>
    <!-- Search Bar -->
    <div class="row">
      <div class="col-md-12">
        <div class="intro-banner-search-form margin-top-95" id="search-container">
          <!-- Search Field -->
          <div class="intro-search-field">
            <div class="input-group input-group-lg">
              <input type="text" class="form-control" placeholder="What job you want?">
              <div class="input-group-append">
                <button class="button ripple-effect" type="button" id="button-addon2">Search</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="row">
      <div class="col-md-12">
        <ul class="intro-stats margin-top-45 hide-under-992px">
          <li>
            <strong class="counter">1,586</strong>
            <span>Jobs Posted</span>
          </li>
          <li>
            <strong class="counter">3,543</strong>
            <span>Tasks Posted</span>
          </li>
          <li>
            <strong class="counter">1,232</strong>
            <span>Freelancers</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Video Container -->
  <div class="video-container" data-background-image="<?php echo $background_image; ?>">
    <video loop autoplay muted>
      <?php foreach ($videos as $video) { ?>
      <source src="<?php echo $video['link']; ?>" type="<?php echo $video['mime']; ?>">
      <?php } ?>
    </video>
  </div>
</div>
