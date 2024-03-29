<?php echo $header; ?><?php echo $dashboard_menu ;?>
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded border">
	<div class="dashboard-content-inner">
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
			<ul class="nav nav-pills float-right" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="employer-tab" data-toggle="tab" href="#employer" role="tab" aria-controls="employer" aria-selected="true">Employer</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="applicant-tab" data-toggle="tab" href="#applicant" role="tab" aria-controls="applicant" aria-selected="false">Applicant</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<div class="tab-content mt-4" id="myTabContent">
					<div class="tab-pane fade" id="employer" role="tabpanel" aria-labelledby="employer-tab"><div id="employer-job-list"></div></div> 
					<div class="tab-pane fade" id="applicant" role="tabpanel" aria-labelledby="applicant-tab"><div id="applicant-job-list"></div></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Add Job -->
<div class="modal fade" id="add-new-job" tabindex="-1" aria-labelledby="add-new-job" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add-new-job">Add New Local Job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form id="form-add-job" accept-charset="utf-8" enctype="multipart/form-data">
	  <input type="hidden" name="customer_id" value="<?= $customer_id ?>" />
		<div class="form-group row">
			<label for="input-name" class="col-sm-2 col-form-label">Name</label>
			<div class="col-sm-10">
			<input type="text" class="form-control" id="input-name" name="job_description[name]">
			</div>
		</div>
		<div class="form-group row">
			<label for="input-description" class="col-sm-2 col-form-label">Description</label>
			<div class="col-sm-10">
			<textarea type="text" class="form-control summernote" id="input-description" name="job_description[description]"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="input-description" class="col-sm-2 col-form-label">Tags</label>
			<div class="col-sm-10">
			<input type="text" class="form-control" id="input-meta_keyword" name="job_description[meta_keyword]">
			</div>
		</div>
		<div class="form-group row">
			<label for="input-description" class="col-sm-2 col-form-label">Salary</label>
			<div class="col-sm-10">
			<input type="number" class="form-control" id="input-salary" min="1" name="salary">
			</div>
		</div>
		<div class="form-group row">
			<label for="input-description" class="col-sm-2 col-form-label">Type</label>
			<div class="col-sm-10">
			<select class="custom-select my-1 mr-sm-2" id="input-type" name="type">
				<option value="1" selected>Full Time</option>
				<option value="2">Part Time</option>
				<option value="3">Intern</option>
				<option value="4">Temporary</option>
			</select>
			</div>
		</div>
     </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="button-new-job">Add</button>
      </div>
    </div>
  </div>
</div>
<!-- include summernote css/js -->
<link href="catalog/default/vendor/summernote/summernote.min.css" rel="stylesheet">
<script src="catalog/default/vendor/summernote/summernote.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('.summernote').summernote({
	height: 200,
	toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['picture', 'video']],
          ['view', ['fullscreen', 'codeview']]
        ]
  });
});
</script>
<!-- Modal Add Job -->
<script type="text/javascript">
$('#myTab #employer-tab').on('click', function (e) {
	$.ajax({
		url: 'account/jobs/getEmployerJobs',
		dataType: 'html',
		beforeSend: function() {
			$('#employer-job-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#employer-job-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});

$('#employer-job-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#employer-job-list').fadeOut('slow');
	$('#employer-job-list').load(this.href);
	$('#employer-job-list').fadeIn('slow');
});

$('#myTab li:first-child a').tab('show') // Select first tab
$('#myTab li:first-child a').trigger('click') // Select first tab


$('#myTab #applicant-tab').on('click', function (e) {
	$.ajax({
		url: 'account/jobs/getApplicantJobs',
		dataType: 'html',
		beforeSend: function() {
			$('#applicant-job-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
		},
		complete: function() {
  		    $('#spinner').remove();
		},
		success: function(html) {
		    $('#applicant-job-list').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});

$('#applicant-job-list').on('click', '.pagination a', function(e) {
	e.preventDefault();
	$('#applicant-job-list').fadeOut('slow');
	$('#applicant-job-list').load(this.href);
	$('#applicant-job-list').fadeIn('slow');
});

</script>

<?php echo $footer; ?>