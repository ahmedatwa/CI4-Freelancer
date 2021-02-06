<div class="row">
  <div class="col-3">
    <div class="nav flex-column nav-pills" id="v-message-tab" role="tablist" aria-orientation="vertical">
      <?php foreach ($members as $member) { ?>
      <a class="nav-link" id="v-pills-<?php echo $member['thread_id']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $member['thread_id']; ?>" role="tab" aria-controls="v-pills-<?php echo $member['thread_id']; ?>" aria-selected="true" data-thread="<?php echo $member['thread_id']; ?>">@<?php echo $member['receiver']; ?></a>
    <?php } ?>
    </div>
  </div>
  <div class="col-9">
    <div class="tab-content" id="v-pills-tabContent-projectMessages"></div>
  </div>
</div>
<script type="text/javascript">
  $('#v-message-tab a[data-toggle="pill"]').on('click', function () {
    $.ajax({
          url: 'account/message/getThreadMessages?thread_id=' + $(this).attr('data-thread'),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
            "X-Requested-With": "XMLHttpRequest"
          },
          dataType: 'html',
          beforeSend: function() {
             $('#v-pills-tabContent-projectMessages').html('<p id="loader-div" class="text-center"><i class="fas fa-spinner fa-spin fa-lg"></i> Retrieving Messages...</p>');
          },
          complete: function() {
            $('#loader-div').remove();
          },
          success: function(html) {
            $('#v-pills-tabContent-projectMessages').html(html);                        
          },
          error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
   });
});

$('#v-message-tab a:first-child').tab('show') // Select first tab
$('#v-message-tab a:first-child').trigger('click') // Select first tab

</script>
