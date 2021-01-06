<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<!-- Page Header Begin -->
	<div class="page-header">
		<div class="container-fluid">
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
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><i class="fas fa-list"></i> <?php echo $text_list; ?></div>
			<div class="card-body">
				<fieldset>
					<legend><?php echo $text_type; ?></legend>
					<div class="input-group">
						<select name="report" onchange="location = this.value;" class="form-control">
							<?php foreach ($reports as $report) { ?>
								<?php if ($report['code'] == $code) { ?>
									<option value="<?php echo $report['href']; ?>" selected="selected"><?php echo $report['text']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $report['href']; ?>"><?php echo $report['text']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="input-group-append">
							<label class="input-group-text"><i id="filter" class="fa fa-filter"></i></label>
						</div>
					</div>
				</fieldset>
				<div class="mt-3"><?php echo $report_list; ?></div>
			</div><!-- Card Body -->
		</div><!-- Card -->
	</div><!-- container-fluid -->
	<!-- last Div dont delete -->
</div>
<?php echo $footer; ?>