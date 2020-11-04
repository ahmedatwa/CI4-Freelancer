<?php echo $header; ?> 
<div class="jumbotron">
	<div class="container-fluid">
		<h2 class="display-5"><?php echo $heading_title; ?></h2>
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
	<div class="section mb-5 bg-white margin-top-30">		
		<div class="row">
			<div class="col">
				<div class="sidebar-container">
					<!-- Category -->
					<div class="keywords-list"></div>
					<div class="dropdown-divider"></div>
					<div class="sidebar-widget">
						<h3><?php echo $text_skills; ?></h3>
						<div class="keywords-container margin-top-20">
							<div class="input-group keyword-input-container">
								<select class="form-control" name="filter_category[]" data-width="100%" multiple="multiple">
									<?php foreach($categories as $category) { ?>
										<?php if (in_array($category['category_id'], $filter_skills)) { ?>
											<option value="<?php echo $category['category_id']; ?>" selected><?php echo $category['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
								
							</div>
						</div>

					</div>
					<!-- Hourly Rate -->
					<div class="sidebar-widget">
						<h3><?php echo $text_hourly_rate; ?></h3>
						<div class="form-group">
							<select class="custom-select" onchange="location = this.value;">
								<option><?php echo $text_select; ?></option>
								<?php foreach ($rates as $rate) { ?> 
									<?php if ($rate['value'] == $filter_rate) { ?>
										<option value="<?php echo $rate['href']; ?>" selected><?php echo $rate['text']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $rate['href']; ?>"><?php echo $rate['text']; ?></option>  
									<?php } ?>
								<?php } ?>      
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-9 mb-4">
			<!-- Freelancers List Container -->
			<div class="freelancers-container freelancers-list-layout compact-list shadow p-3 mb-5 bg-white rounded">
				<div class="notify-box">
						<h3 class="float-left ml-3"><?php echo $text_found ;?></h3>
						<div class="col-md-3 float-right">
						</div>
					</div>
				<?php foreach ($freelancers as $freelancer) { ?>
				<!--Freelancer -->
				<div class="freelancer">
					<!-- Overview -->
					<div class="freelancer-overview">
						<div class="freelancer-overview-inner">
							
							<!-- Bookmark Icon -->
							<span class="bookmark-icon"></span>
							
							<!-- Avatar -->
							<div class="freelancer-avatar">
								<div class="verified-badge"></div>
								<a href="<?php echo $freelancer['href']; ?>"><img src="<?php echo $freelancer['image']; ?>" alt=""></a>
							</div>

							<!-- Name -->
							<div class="freelancer-name">
								<h4><a href="<?php echo $freelancer['href']; ?>"><?php echo $freelancer['name']; ?> <img class="flag" src="images/flags/gb.svg" alt="" title="United Kingdom" data-tippy-placement="top"></a></h4>
								<span><?php echo $freelancer['tag_line']; ?></span>
								<!-- Rating -->
								<div class="freelancer-rating">
								<div class="rating">
									<ul>
										<?php for ($i=1; $i <= 5; $i++) { ?>
											<?php if ($freelancer['rating'] < $i) { ?>
												<li><span class="fa-stack"><i class="far fa-star fa-stack-1x"></i></span></li>
											<?php } else { ?>
												<li><span class="fa-stack">
													<i class="fas fa-star fa-stack-1x"></i></span></li>
												<?php } ?>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Details -->
					<div class="freelancer-details">
						<div class="freelancer-details-list">
							<ul>
								<!-- <li>Location <strong><i class="icon-material-outline-location-on"></i> London</strong></li> -->
								<li>Rate <strong><?php echo $freelancer['rate']; ?> / hr</strong></li>
								<!-- <li>Job Success <strong>95%</strong></li> -->
							</ul>
						</div>
						<div class="clearfix"></div>
						<a href="<?php echo $freelancer['href']; ?>" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
					</div>
				</div>
				<!-- Freelancer / End -->
				<?php } ?>

				
			</div>
			<!-- Freelancers Container / End -->
			<!-- Pagination -->
			<div class="clearfix"></div>
			<?php echo $pagination; ?>
			<!-- Pagination / End -->

		</div>
	</div>
</div>
</div>
</div>

<!-- Spacer -->
<div class="margin-top-15"></div>
<!-- Spacer / End-->
<link href="catalog/default/vendor/select2/customSelectionAdapter/css/select2.customSelectionAdapter.min.css">		
<script src="catalog/default/vendor/select2/customSelectionAdapter/js/select2.customSelectionAdapter.min.js"></script>

<script type="text/javascript">
var CustomSelectionAdapter = $.fn.select2.amd.require("select2/selection/customSelectionAdapter");
// Skills

$('select[name^=\'filter_category\']').select2({
ajax: {
	url: "project/category/autocomplete",
	dataType: 'json',
	delay: 250,
	data: function (params) {
		return {
			filter_category: params.term,
		};
	},
	processResults: function (data, params) {
		var results = $.map(data, function (item) {
			item.id = item.category_id;
			item.text = item.name;
			return item;
		});
		return {
			results: results,
		};
	},
	cache: true
},
theme: 'bootstrap4',
placeholder: '<?php echo $text_select;?>',
allowClear: true,
minimumResultsForSearch: 5,
selectionAdapter: CustomSelectionAdapter,
selectionContainer: $('.keywords-list'),

}).on("select2:select", function (e) { 
	var select_val = $(e.currentTarget).val();
    location = '<?php echo $action_skills; ?>?skills=' +  select_val.join('_');
  
}).on('select2:unselect', function (e) {
	  var select_val = $(e.currentTarget).val();
	  location = '<?php echo $action_skills; ?>skills=' +  select_val.join('_');

}).on('select2:clear', function (e) {
    location = '<?php echo $action_skills; ?>';
});
</script>	
<?php echo $footer; ?>
