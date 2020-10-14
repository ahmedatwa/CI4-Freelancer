<?php echo $header; ?><?php echo $dashboard_menu ;?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow p-3 mb-5 bg-white rounded">
	<div class="dashboard-content-inner" >
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $heading_title; ?></h3>
			<!-- Breadcrumbs -->
			<!-- <nav id="breadcrumbs" class="dark">
				<ul>
					<?php //foreach ($breadcrumbs as $breadcrumb) { ?>
						<li><a href="<?php //echo $breadcrumb['href']; ?>"><?php //echo $breadcrumb['text']; ?></a></li>
					<?php //} ?>
				</ul>
			</nav> -->
		</div>
		<!-- Row -->
		<div class="row">
			<div class="col-12 mb-4">
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active ripple-effect" id="pills-freelancer-tab" data-toggle="pill" href="#pills-freelancer" role="tab" aria-controls="pills-freelancer" aria-selected="true">Freelancer</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-employer-tab" data-toggle="pill" href="#pills-employer" role="tab" aria-controls="pills-employer" aria-selected="false">Employer</a>
					</li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-freelancer" role="tabpanel" aria-labelledby="pills-freelancer-tab">
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
										<tr>
											<td><?php echo $project['name']; ?></td>
											<td><?php echo $project['employer']; ?></td>
											<td><?php echo $project['status']; ?></td>
											<td class="text-center">
												<a href="<?php echo $project['edit']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>"><i class="far fa-edit"></i></a></td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
						</div> <!--pills-freelancer-tab-->
						<div class="tab-pane fade" id="pills-employer" role="tabpanel" aria-labelledby="pills-employer-tab">
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
											<tr>
												<td><?php echo $project['name']; ?></td>
												<td><?php echo $project['freelancer']; ?></td>
												<td><?php echo $project['status']; ?></td>
												<td class="text-center">
													<a href="<?php echo $project['edit']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $button_edit; ?>"><i class="far fa-edit"></i></a></td>
												</tr>
											<?php } ?>
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
<?php echo $footer; ?>