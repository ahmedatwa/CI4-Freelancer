<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded border">
	<div class="dashboard-content-inner" >
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
		</div>
		<!-- Row -->
		<div class="row">
			<div class="col-12 mb-4">
				<ul class="nav nav-pills float-right mb-4" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active ripple-effect" id="pills-freelancer-tab" data-toggle="pill" href="#freelancer-review" role="tab" aria-controls="freelancer-review" aria-selected="true">Freelancer</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-employer-tab" data-toggle="pill" href="#employer-review" role="tab" aria-controls="employer-review" aria-selected="false">Employer</a>
					</li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="freelancer-review" role="tabpanel" aria-labelledby="freelancer-review-tab">
						<div class="table-responsive">
						<table id="table-location" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo $column_name; ?></th>
									<th><?php echo $column_employer; ?></th>
									<th><?php echo $column_status; ?></th>
									<th><?php echo $column_action; ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($projects) { ?>
									<?php foreach ($projects as $project) { ?>
										<?php if ($project['freelancer_id'] == $customer_id) { ?>
										<tr>
											<td><?php echo $project['name']; ?></td>
											<td><?php echo $project['employer']; ?></td>
											<td><?php echo $project['status']; ?></td>
											<td class="text-center">
													<span data-toggle="tooltip" data-placement="top" title="Leave Feedback">
													<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#rateModal" data-freelancer="<?php echo $project['freelancer']; ?>" data-projectid="<?php echo $project['project_id']; ?>" data-freelancerid="<?php echo $project['freelancer_id']; ?>" data-employerid="<?php echo $project['employer_id']; ?>"><i class="far fa-thumbs-up"></i></button>
													</span>
												</td>
											</tr>
										<?php } else { ?>
											<tr>
												<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
											</tr>
											<?php } ?>	
										<?php } ?>
									<?php } else { ?>
										<tr>
											<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
										</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>
						</div> <!--pills-freelancer-tab-->
						<!-- Rate Freelancers -->
						<div class="tab-pane fade" id="employer-review" role="tabpanel" aria-labelledby="employer-review-tab">
							<div class="table-responsive">
							<table id="table-location" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th><?php echo $column_name; ?></th>
										<th><?php echo $column_freelancer; ?></th>
										<th><?php echo $column_status; ?></th>
										<th><?php echo $column_action; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($projects) { ?>
										<?php foreach ($projects as $project) { ?>
										 <?php if ($project['employer_id'] == $customer_id) { ?>
											<tr>
												<td><?php echo $project['name']; ?></td>
												<td><?php echo $project['freelancer']; ?></td>
												<td><?php echo $project['status']; ?></td>
												<td class="text-center">
													<span data-toggle="tooltip" data-placement="top" title="Leave Feedback">
													<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#rateModal" data-freelancer="<?php echo $project['freelancer']; ?>" data-projectid="<?php echo $project['project_id']; ?>" data-freelancerid="<?php echo $project['freelancer_id']; ?>" data-employerid="<?php echo $project['employer_id']; ?>"><i class="far fa-thumbs-up"></i></button>
													</span>
												</td>
												</tr>
											<?php } else { ?>
											<tr>
												<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
											</tr>
											<?php } ?>	
											<?php } ?>
										<?php } else { ?>
											<tr>
												<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
											</tr>
										<?php } ?>	
									</tbody>
								</table>
							</div>
							</div> <!--pills-employer-tab-->
						</div>
					</div>
				</div>
				<!-- Row / End -->
			</div>
		</div>

<!-- Modal -->
<div class="modal fade" id="rateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Leave a Feedback</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form-for-freelancer">
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<div class="form-group">
						<label for="staticEmail" class="col-form-label">Project Delivered on-time</label>
						<div class="col-sm-12">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="ontime" value="1">
								<label class="form-check-label" for="inlineCheckbox1">Yes</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="ontime" value="0">
								<label class="form-check-label" for="inlineCheckbox1">No</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="staticEmail" class="col-form-label">Recommended</label>
						<div class="col-sm-12">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="recommended" value="1">
								<label class="form-check-label" for="inlineCheckbox1">Yes</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="recommended" value="0">
								<label class="form-check-label" for="inlineCheckbox1">No</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="staticEmail" class="col-form-label">Overall Rating</label>
						<div class="col-sm-12">
							<input type="text" id="rating" class="rating-loading">
							<input type="hidden" name="rating" id="rating-value" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="staticEmail" class="col-form-label">Comment</label>
						<div class="col-sm-12">
							<textarea name="comment" cols="5" rows="5" class="form-control"></textarea>	
						</div>
					</div>			
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="button-submit-feedback">Submit</button>
			</div>
		</div>
	</div>
</div>	

<link rel="stylesheet" href="catalog/default/vendor/kartik-v-bootstrap-star/css/star-rating.css" media="all" type="text/css"/>
<link rel="stylesheet" href="catalog/default/vendor/kartik-v-bootstrap-star/themes/krajee-fa/theme.min.css" media="all" type="text/css"/>
<script src="catalog/default/vendor/kartik-v-bootstrap-star/js/star-rating.js" type="text/javascript"></script>
<script src="catalog/default/vendor/kartik-v-bootstrap-star/themes/krajee-fa/theme.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#rating').rating({
    	hoverEnabled: true,
    	hoverOnClear: false,
    	showClear: false,
    	min: 0,
    	max: 5,
    	step: 1,
    	size: 'sm',
    	showCaption: false,
        theme: 'krajee-fa',
        filledStar: '<i class="fas fa-star"></i>',
        emptyStar: '<i class="far fa-star"></i>'
    }).on('rating:change', function(event, value, caption) {
      $('#rating-value').val(value);
});  
});
</script>

<!-- scri -->
<script type="text/javascript">
$('#rateModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var freelancer = button.data('freelancer'); 
  var project_id = button.data('projectid'); 
  var freelancer_id = button.data('freelancerid'); 
  var employer_id = button.data('employerid'); 
  var modal = $(this)
  modal.find('.modal-title').text('Leave a Feedback for ' + freelancer);

  $('#button-submit-feedback').on('click', function(){
  	var $node = $(this);
  	$.ajax({
  		url: 'account/review/add?project_id=' + project_id + '&freelancer_id=' + freelancer_id + '&employer_id=' + employer_id,
  		method: 'post',
  		dataType: 'json',
  		data: $('#form-for-freelancer').serialize(),
  		beforeSend: function() {
  			$($node).html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
  		},
  		complete: function() {
		    $($node).html('Submit');
  		},
  		success: function(json) {
		   	
		   	if (json['success']) {
		   		$('#rateModal').modal('hide');

	        	$.notify({
                icon: 'fas fa-check-circle',
                title: 'Success',
                message: json['success']
	            },{
	             animate: {
	                enter: 'animate__animated animate__lightSpeedInRight',
	                exit: 'animate__animated animate__lightSpeedOutRight'
	            },
               type: 'success'
             });
	        }
  		},
		error: function(xhr, ajaxOptions, thrownError) {
		    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}

  	});
  });

});
</script>
<script type="text/javascript">
var url = document.URL;
var hash = url.substring(url.indexOf('#'));

$(".nav-pills").find("li a").each(function(key, val) {
    if (hash == $(val).attr('href')) {
        $(val).click();
    }
    
    $(val).click(function(ky, vl) {
        location.hash = $(this).attr('href');
    });
});
</script>
<?php echo $footer; ?>