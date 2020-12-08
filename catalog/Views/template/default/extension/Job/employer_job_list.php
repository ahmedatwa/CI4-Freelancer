<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add-new-job"><i class="fas fa-plus"></i> Add New Job</button>
<div class="table-responsive mt-4">
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">Job ID</th>
      <th scope="col">Job Name</th>
      <th scope="col">Type</th>
      <th scope="col">Salary</th>
      <th scope="col">Status</th>
      <th scope="col" class="text-center">Applicants</th>
      <th scope="col">Date Added</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($jobs as $job) { ?>
    <tr>
      <th scope="row"><?php echo $job['job_id']; ?></th>
      <td><?php echo $job['name']; ?></td>
      <td><?php echo $job['type']; ?></td>
      <td><?php echo $job['salary']; ?></td>
      <td><?php echo $job['status']; ?></td>
      <td class="text-center"><?php if ($job['total'] > 0) { ?>
        <span class="badge badge-success"><?php echo $job['total']; ?></span>
      <?php } else { ?>
        <span class="badge badge-danger"><?php echo $job['total']; ?></span>
      <?php } ?>   
      </td>
      <td><?php echo $job['date_added']; ?></td>
      <td>
      <?php if ($job['total'] > 0) { ?>
      <a role="button" href="<?php echo $job['view']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View Applicants"><i class="fas fa-eye"></i></a>
      <?php } else { ?>
        <a role="button" href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View Applicants" disabled><i class="fas fa-eye"></i></a>
      <?php } ?>
      <button type="button" class="btn btn-warning btn-sm" id="button-job-cease" data-toggle="tooltip" data-placement="top" onclick="ceaseJob(<?php echo $job['job_id']; ?>);" title="Cease Job"><i class="fas fa-hand-paper"></i></button>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
<script type="text/javascript">
$('#button-new-job').on('click', function() {
  $.ajax({
        url: 'account/jobs/add',
        dataType: 'json',
        method:'post',
        data: $('#form-add-job').serialize(),
        beforeSend: function() {
            $(this).html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>');
            $('.alert, .invalid-feedback, .text-danger').remove();
        },
        complete: function() {
           $(this).html('Save');
        },
        success: function(json) {                  
            if (json['error']) {
              if (json['error']['validation']){
                for (i in json['error']['validation']) {
                  
                  var element = $('#input-' + i.substring(i.lastIndexOf("[") + 1, i.lastIndexOf("]")));

                  if (element.parent().hasClass('form-group')) {
                      element.parent().after('<div class="invalid-feedback">' + json['error']['validation'][i] + '</div>');
                    } else {
                      element.after('<div class="text-danger">' + json['error']['validation'][i] + '</div>');
                  }
                }
              }
            }
            if (json['success']) {
                $('#employer-job-list').load('account/jobs/getEmployerJobs');

                $('#employer-job-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
            } 
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
</script>

<script type="text/javascript">

function ceaseJob(job_id) {
  bootbox.confirm({
    message: "Are You Sure",
    size: 'small',
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
      if (result) {
        $.ajax({
          url: 'account/jobs/ceaseJob?job_id=' + job_id,
          method: 'post',
          dataType: 'json',
          data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>'},
          beforeSend: function() {
            $('#button-job-cease').html('<button class="btn btn-warning" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>');
            $('.alert, .invalid-feedback, .text-danger').remove();
          },
          complete: function() {
            $('#button-job-cease').html('<i class="fas fa-hand-paper"></i>');
          },
          success: function(json) {                  
                  if (json['success']) {
                      $('#employer-job-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
                  } 
              },
              error: function(xhr, ajaxOptions, thrownError) {
                  alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      }
    }
  });
}
</script>