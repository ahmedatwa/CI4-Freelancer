<div class="">
<div class="video-container" id="carousel-slick-carousel">
  <?php foreach ($banners as $banner ) { ?>
    <?php if ($banner['link']) { ?>
       <div> <a href="<?php echo $banner['link']; ?>">
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a></div>
          <?php } else { ?>
        <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></div>
      <?php } ?>
<?php } ?>
</div>
</div>

<script type="text/javascript">
$('#carousel-slick-carousel').slick({
  centerMode: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true,
  infinite: true,
  fade: true,
  autoplay:true,
  arrows: false
  
});
</script>