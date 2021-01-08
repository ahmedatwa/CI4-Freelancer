<?php echo $header; ?><?php echo $menu; ?>
<!-- Titlebar -->
<div class="single-page-header" data-background-image="catalog/default/images/single-task.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-details">
							<h3 class=""><?php echo $name; ?></h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>		
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<nav id="breadcrumbs">
				<ul>
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</nav>
		</div>
	</div>
	<!-- Page Content-->
	<div class="row align-items-start">
		<div class="col-9 mb-4 p-4 shadow-sm rounded border bg-white">
			<div class="single-page-section">
				<h3><?php echo $text_description; ?></h3>
				<p><?php echo $description; ?></p>
				<div class="single-page-section mt-4">
					<h3>Tags</h3>
					<div class="task-tags">
						<?php foreach ($tags as $value) { ?>
							<span><?php echo $value; ?></span>
						<?php } ?>
					</div>
				</div>
			</div>


		</div>
		<div class="col-3">
			<p class="text-center mb-4">
				
				<?php if (($customer_id != $employer_id) && $isLogged) { ?>
					<button type="button" data-toggle="modal" data-target="#applyform" class="btn btn-danger btn-block">Apply Now <i class="icon-material-outline-arrow-right-alt"></i></button>
				<?php } elseif ($alreadyApplied) { ?>
					<button type="button" class="btn btn-danger btn-block" disabled>Aleady Applied <i class="icon-material-outline-arrow-right-alt"></i></button>
				<?php } elseif (! $isLogged) { ?>
					<a class="btn btn-danger btn-block" role="button" href="<?php echo $login;?>">Login to apply <i class="icon-material-outline-arrow-right-alt"></i></a>
				<?php } else { ?>
				<button type="button" class="btn btn-danger btn-block" disabled>Apply Now <i class="icon-material-outline-arrow-right-alt"></i></button>
				<?php } ?>	
					</p>
					<!-- Sidebar Widget -->
					<div class="sidebar-widget">
						<div class="job-overview">
							<div class="job-overview-headline">Job Summary</div>
							<div class="job-overview-inner">
								<ul>
									<li>
										<i class="icon-material-outline-location-on"></i>
										<span>Location</span>
										<h5>Egypt</h5>
									</li>
									<li>
										<i class="icon-material-outline-business-center"></i>
										<span>Job Type</span>
										<h5><?php echo $type; ?></h5>
									</li>
									<li>
										<i class="icon-material-outline-local-atm"></i>
										<span>Salary</span>
										<h5><?php echo $salary; ?></h5>
									</li>
									<li>
										<i class="icon-material-outline-access-time"></i>
										<span>Date Posted</span>
										<h5><?php echo $date_added; ?></h5>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card p-3 border-0">
					</div><!--justify-content-center-->
				</div>	

			</div>
		</div>
	</div> <!---- content-wrapper ---->
<!-- Modal -->
<div class="modal fade" id="applyform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apply for this Job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="kartik-file-errors"></div>
      <div class="modal-body">
      	<form method="post" id="apply-now-form">
      		<input type="hidden" name="job_id" value="<?php echo $job_id; ?>" />
      		<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
      		<div class="form-group">
            <label for="firstlast">First Name</label>
      		<div class="input-group">
      			<div class="input-group-prepend">
      				<span class="input-group-text"><i class="icon-material-outline-account-circle"></i></span>
      			</div>
      			<input type="text" class="form-control" placeholder="First Name" name="firstname" id="input-apply-firstname" value="<?php echo $firstname; ?>">
      		</div>
      	</div>
      	<div class="form-group">
            <label for="firstlast">Last Name</label>
      		<div class="input-group">
      			<div class="input-group-prepend">
      				<span class="input-group-text"><i class="icon-material-outline-account-circle"></i></span>
      			</div>
      			<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="input-apply-lastname" value="<?php echo $lastname; ?>">
      		</div>
      	</div>
      	<div class="form-group">
        <label for="exampleInputEmail1">Email Address</label>
      		<div class="input-group">
      			<div class="input-group-prepend">
      				<span class="input-group-text"><i class="icon-material-baseline-mail-outline"></i></span>
      			</div>
      			<input type="email" class="form-control" placeholder="Email Address" name="email" id="input-apply-email" value="<?php echo $email; ?>">
      		</div>
      	</div>
	  		<div class="form-group">
	  			<label for="input-file">Select File: <small> PDF, DOC, DOCX, TXT</small></label>
	  			<input type="file" class="form-control btn btn-secondary" name="file" id="input-upload" required>
	  			<input type="hidden" name="download_id" value="" id="input-apply-download_id">
	  		</div>
	  	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-block" id="button-apply-job">Apply Now</button>
      </div>
    </div>
  </div>
</div>	
<script type="text/javascript">
var uri = document.URL;

$('#button-apply-job').on('click', function() {
	 $.ajax({
	    url: 'extension/job/job/apply?uri=' + encodeURIComponent(uri),
	    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
	    dataType: 'json',
	    method: 'post',
	    data: $('#apply-now-form input[name=\'firstname\'], #apply-now-form input[name=\'lastname\'], #apply-now-form input[name=\'email\'], #apply-now-form input[type=\'hidden\']'),
	    beforeSend: function() {
	    	$('#button-apply-job').html('<button class="btn btn-danger btn-block" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>');
	        $('.text-danger, .alert, .invalid-feedback').remove();
	    },
	    complete: function() {
	    	$('#button-apply-job').html('Apply');
	    },
	    success: function(json) {

	    	if (json['error']) {
	    		if (json['error']['login']) {
	    		  $('.modal-body').before('<div class="alert alert-danger fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['error']['login'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	    	    }

				if (json['error']['validation']) {
					for (i in json['error']['validation']) {
						var element = $('#input-apply-' + i);

						if (element.parent().hasClass('input-group')) {
							element.after('<div class="invalid-feedback">' + json['error']['validation'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['validation'][i] + '</div>');
						}
					}
				}
			}

	        if (json['success']) {
	          $('.modal-body').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	          $('#apply-now-form').trigger('reset');
	        }                        
	    },
	    error: function(xhr, ajaxOptions, thrownError) {
	        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	    }
	});
});
</script>
<link href="catalog/default/vendor/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="catalog/default/vendor/bootstrap-fileinput/themes/fas/theme.min.js"></script>
<script type="text/javascript">
$('#input-upload').fileinput({
	uploadUrl: 'tool/upload?type=1',
	enableResumableUpload: false,
    uploadExtraData: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    maxFileCount: 1,
    showPreview: false,
    showUpload: true,
    showCancel: true,
    autoReplace: true,
    showCaption: false,
    theme: 'fas',
    browseIcon: '<i class="fas fa-folder-open"></i>',
    browseClass: "btn btn-info",
    elErrorContainer: '#kartik-file-errors',
    allowedFileExtensions: ['pdf', 'doc', 'docx', 'txt'],
 }).on('fileuploaded', function(event, data, previewId, index) {
 	   $('.text-danger, .alert, .invalid-feedback').remove();
 	   var response = data.response, reader = data.reader;
       $('input[name=\'download_id\']').val(response.download_id);
       $(this).fileinput("disable").fileinput("refresh", {showUpload: false});
 });

</script>
<?php echo $footer; ?>
