<div class="swiper-viewport">
  <div id="carousel{{ module }}" class="swiper-container">
    <div class="swiper-wrapper">
      <?php foreach ($banners as $banner ) { ?>
      <div class="swiper-slide text-center">
        <?php if ($banner['link']) { ?>
        <a href="<?php echo $banner['link']; ?>">
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
          <?php } ?></div>
      <?php } ?></div>
  </div>
  <div class="swiper-pagination carousel{{ module }}"></div>
  <div class="swiper-pager">
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</div>
<script type="text/javascript"><!--
$('#carousel{{ module }}').swiper({
	mode: 'horizontal',
	slidesPerView: 5,
	pagination: '.carousel{{ module }}',
	paginationClickable: true,
	nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
	autoplay: 2500,
	loop: true
});
--></script>