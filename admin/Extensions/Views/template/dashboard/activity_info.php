<div class="card mb-3">
  <div class="card-header p-2">
    <i class="fas fa-calendar-alt"></i> <?php echo $heading_title; ?> 
  </div>
  <div class="card-body p-2">
    <ul class="list-group list-group-flush">
     <?php if ($activities) { ?>
      <?php foreach ($activities as $activity) {?>
        <li class="list-group-item d-flex justify-content-between align-items-center"> <p><?php echo $activity['comment']; ?></p> 
        <span class="badge badge-info badge-pill"> <i class="fa fa-clock-o"></i> <?php echo $activity['date_added']; ?></span>
        </li>
        <?php } ?>
      <?php } else { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center"> <?php echo $text_no_results; ?></li>
      <?php } ?>
    </ul>
  </div>
</div>
