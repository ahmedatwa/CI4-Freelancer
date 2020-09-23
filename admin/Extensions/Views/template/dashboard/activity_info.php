<div class="card  mb-3">
  <div class="card-header p-2">
    <i class="fas fa-calendar-alt"></i> <?php echo $heading_title; ?> 
  </div>
  <div class="card-body p-2">
    <ul class="list-group list-group-flush">
     <?php if ($activities) { ?>
      <?php foreach ($activities as $activity) {?>
        <li class="list-group-item"><p class="mb-1"> <?php echo $activity['comment']; ?></p>
          <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $activity['date_added']; ?></small></li>
        <?php } ?>
      <?php } else { ?>
        <li class="list-group-item text-center"> <?php echo $text_no_results; ?></li>
      <?php } ?>
    </ul>
  </div>
</div>
