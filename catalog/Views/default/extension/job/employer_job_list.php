<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add-new-job"><i class="fas fa-plus"></i> Add New Job</button>
<div class="table-responsive mt-4">
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">Job ID</th>
      <th>Job Name</th>
      <th >Type</th>
      <th >Salary</th>
      <th >Status</th>
      <th class="text-center">Applicants</th>
      <th >Date Added</th>
      <th >Action</th>
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
        <span data-toggle="tooltip" data-placement="top" title="View Applicants"><a role="button" href="#" class="btn btn-primary btn-sm disabled"><i class="fas fa-eye"></i></a></span>
      <?php } ?>
      <?php if ($job['status'] == 0) { ?>
      <span data-toggle="tooltip" data-placement="top" title="Cease Job"><a role="button" class="btn btn-warning btn-sm disabled" id="button-job-cease"><i class="fas fa-hand-paper"></i></a></span>
    <?php } else { ?>
      <button type="button" class="btn btn-warning btn-sm" id="button-job-cease" data-toggle="tooltip" data-placement="top" onclick="ceaseJob(<?php echo $job['job_id']; ?>);" title="Cease Job"><i class="fas fa-hand-paper"></i></button>
     <?php } ?> 
      <button type="button" class="btn btn-danger btn-sm" id="button-job-delete" data-toggle="tooltip" data-placement="top" onclick="deleteJob(<?php echo $job['job_id']; ?>);" title="Delete Job"><i class="far fa-trash-alt"></i></button>
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
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
          "X-Requested-With": "XMLHttpRequest"
        },
        dataType: 'json',
        method:'post',
        data: $('#form-add-job').serialize(),
        beforeSend: function() {
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('.alert, .invalid-feedback, .text-danger').remove();
            $('#form-add-job input, #form-add-job select').removeClass('is-invalid');
        },
        complete: function() {
           $(this).html('Add');
        },
        success: function(json) { 
            if (json['error']) {
                for (i in json['error']) {
                  var el = i.replace('.', '-');
                  var input = $('#' + el.replace('job_description', 'input'));
                    input.addClass('is-invalid');
                    input.after('<div class="invalid-feedback">' + json['error'][i] + '</div>');
                }
            }

            if (json['success']) {
                $('#add-new-job').modal('hide');

                $('#employer-job-list').load('account/jobs/getEmployerJobs');

                $('#employer-job-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
                $('#form-add-job').trigger('reset');
                // resetting summernote
                $('#input-description').summernote('reset');
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
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
          },
          method: 'post',
          dataType: 'json',
          beforeSend: function() {
            $('#button-job-cease').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('.alert, .invalid-feedback, .text-danger').remove();
          },
          complete: function() {
            $('#button-job-cease').html('<i class="fas fa-hand-paper"></i>');
          },
          success: function(json) {                  
                  if (json['success']) {
                      $('#employer-job-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
                        $('#employer-job-list').load('account/jobs/getEmployerJobs');
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

// Delete Job
function deleteJob(job_id) {
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
          url: 'account/jobs/deleteJob?job_id=' + job_id,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
          },
          method: 'post',
          dataType: 'json',
          beforeSend: function() {
            $('#button-job-delete').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $('.alert, .invalid-feedback, .text-danger').remove();
          },
          complete: function() {
            $('#button-job-delete').html('<i class="far fa-trash-alt"></i>');
          },
          success: function(json) {                  
                  if (json['success']) {
                       $('#employer-job-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
                      $('#employer-job-list').load('account/jobs/getEmployerJobs');
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