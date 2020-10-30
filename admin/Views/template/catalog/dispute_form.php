<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<!-- Page Header Begin -->
	<div class="page-header">
		<div class="container-fluid">
			<div class="float-right">
<!-- 				<button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" name="<?php //echo $button_save; ?>"><i class="far fa-save"></i></button>
 -->				<a href="<?php echo $cancel; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_cancel; ?>"><i class="fas fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?> </h1>
			<nav aria-label="breadcrumb" id="breadcrumb">
				<ol class="breadcrumb">
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
						<li class="breadcrumb-item">
							<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb-link"><?php echo $breadcrumb['text']; ?></a>
						</li>
					<?php } ?>
				</ol>
			</nav>	
		</div>
	</div>
	<!-- Page Heaedr End -->
	<div class="container-fluid">
		<?php if ($error_warning){ ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-exclamation-triangle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
		<div class="card">
			<div class="card-header"><i class="far fa-edit"></i> <?php echo $text_form; ?></div>
			<div class="card-body">
				<fieldset class="mb-3">
					<legend><?php echo $text_details; ?></legend>
					<ul class="list-group list-group-flush">
					  <li class="list-group-item">Employer: <?php echo $employer; ?></li>
					  <li class="list-group-item">Freelancer: <?php echo $freelancer; ?></li>
					  <li class="list-group-item">Comment: <?php echo $comment; ?></li>
					  <li class="list-group-item">Project: <?php echo $project; ?></li>
					</ul>
				</fieldset>
				
				
             
				
				<form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
								<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
								<div class="form-group row">
									<label class="col-md-2 col-form-label"><?php echo $entry_dispute_action; ?></label>
									<div class="col-md-10">
										<select class="form-control" name="dispute_action_id">
											<?php foreach ($dispute_actions as $dispute_action) { ?>
											<?php if ($dispute_action['dispute_action_id'] == $dispute_action_id) { ?>
												<option value="<?php echo $dispute_action['dispute_action_id']; ?>" selected><?php echo $dispute_action['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $dispute_action['dispute_action_id']; ?>"><?php echo $dispute_action['name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div> 
						</form>
					</div><!-- Card -->
				</div><!-- container-fluid -->
			</div>
<?php echo $footer; ?>
