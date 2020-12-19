<?php echo $header; ?><?php echo $dashboard_menu; ?>
<div class="container">
	<div class="dashboard-content-container">
	<div class="row">
		<div class="dashboard-content-inner">
				<div class="dashboard-headline">
				<h3>Manage Candidates</h3>
				<span class="margin-top-7">Job Applications for <a href="#"><?php echo $job_name; ?></a></span>
			</div>	
			<div class="row">
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">
						<div class="headline">
							<h3><i class="icon-material-outline-supervisor-account"></i> <?php echo $total_candidates; ?> Candidates</h3>
						</div>
						<div class="content">
							<ul class="dashboard-box-list w-100">
							<?php foreach ($candidates as $candidate) { ?>
								<li>
									<div class="freelancer-overview manage-candidates">
										<div class="freelancer-overview-inner">
											<div class="freelancer-avatar">
												<div class="verified-badge"></div>
												<img src="images/user-avatar-big-03.jpg" alt="">
											</div>
											<div class="freelancer-name">
												<h4><?php echo $candidate['name']; ?></h4>
												<span class="freelancer-detail-item"><i class="icon-feather-mail"></i> <?php echo $candidate['email']; ?></span>
												<span class="freelancer-detail-item">Applied: <?php echo $candidate['date_added']; ?></span>
												<span class="freelancer-detail-item">Status: <?php if ($candidate['status'] == 1) { ?>
													<span class="badge badge-danger text-white"><?php echo $candidate['status']; ?></span>
												<?php } else { ?>
													<span class="badge badge-success text-white"><?php echo $candidate['status']; ?></span>
												<?php } ?></span>								
												<div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
												<a href="<?php echo $candidate['download']; ?>" class="button ripple-effect"><i class="icon-feather-file-text"></i> Download CV</a>
												<a role="button" href="javascript:void(0);" onclick="setStatus(<?php echo $candidate['job_applicant_id']; ?>);" class="button ripple-effect dark"><i class="fas fa-thumbs-up"></i> Change Status</a>
												</div>
											</div>
										</div>
									</div>
								</li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
	</div>
</div>
<?php echo $footer; ?>

<script>
function setStatus(job_applicant_id) {
	bootbox.prompt({
		title: 'Change Application Status!',
		message: '<p>Please select an option from below:</p>',
		inputType: 'radio',
		inputOptions: [
        {
        text: '<?php echo $text_screened; ?>',
        value: '2',
        },
        {
        text: '<?php echo $text_short_listed; ?>',
        value: '3',
        }
    ],
	buttons: {
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm',
			className: 'btn-success',
        },
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel',
			className: 'btn-danger',
        }
    },
		callback: function (result) {
			if (result) {
				$.ajax({
                    url: 'account/jobs/setJobApplicationStatus',
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
					data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'job_applicant_id': job_applicant_id, 'status': $('.bootbox-input-radio ').val()},
					dataType: 'json',
					success: function(json) {
						$('.content').before('<div class="alert alert-success alert-dismissible fade show" role="alert">'+ json['success'] +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
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