<?php echo $header; ?>
<section class="hero-area">
	<div class="dashboard_menu_area">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-md-5 text-left">
					<h1 class="page-title"><?php echo $text_projects; ?></h1>
				</div>
				<div class="col-md-5 text-right">
					<button type="button" class="btn btn-warning rounded"><?php echo $button_hire; ?></button>
					<button type="button" class="btn btn-outline-primary text-white"><?php echo $button_work; ?></button>
				</div>	
			</div>
		</div>
	</div>
</section>
<div class="content-wrapper">	
	<section>
		<div class="breadcrumb">
			<ul>
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li>
						<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</section>	
	<div class="container-fluid margin-top-40">
		<div id="search-container">
			<div class="input-group mb-3">
				<input type="text" class="form-control form-control-lg" placeholder="<?php echo $text_search_keyword; ?>" id="search-input">
				<div class="input-group-append">
					<button class="btn btn-primary ripple-effect button-sliding-icon" type="button"><i class="fas fa-search fa-lg"></i> <?php echo $button_search; ?> </button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="sidebar-container p-3">
					<p><?php echo $text_sidebar; ?></p>
					<!-- Keywords -->
					<div class="sidebar-widget mt-4">
						<h3><?php echo $text_type; ?></h3>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								<?php echo $text_fixed_price; ?>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								<?php echo $text_per_hour; ?>
							</label>
						</div>
					</div>
					<!-- Budget -->
					<div class="sidebar-widget">
						<h3><?php echo $text_budget; ?></h3>
						<div class="form-group">
							<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
							<div id="slider-range"></div>
						</div>
					</div>
					<!-- Tags -->
					<div class="sidebar-widget">
						<h3><?php echo $text_skills; ?></h3>
						<!-- More Skills -->
						<div class="keywords-list">
							<?php foreach ($categories as $category) { ?>
								<div class="form-check">
									<input class="form-check-input" name="categories" type="checkbox" value="<?php echo $category['category_id']; ?>">
									<label class="form-check-label" for="defaultCheck1">
										<?php echo $category['name']; ?>
									</label>
								</div>
							<?php } ?>
						</div>
						<div class="keywords-container margin-top-20">
							<div class="input-group keyword-input-container">
								<input type="text" class="form-control keyword-input" name="filter_category" placeholder="add more skills">
								<div class="input-group-append">
									<button class="btn btn-outline-primary" type="button"><i class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="sidebar-widget">
						<h3><?php echo $text_state; ?></h3>

						<div class="form-check">
							<input class="form-check-input" type="radio" name="exampleRadios" value="option1" checked>
							<label class="form-check-label" for="exampleRadios1">
								<?php echo $text_all_open; ?>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="exampleRadios" value="option1" checked>
							<label class="form-check-label" for="exampleRadios1">
								<?php echo $text_all_open_closed; ?>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<!-- Tasks Container -->
				<div class="tasks-list-container compact-list ">
					<div class="notify-box">
						<p class="float-left ml-3"><?php echo $text_found ;?></p>
						<div class="col-md-3 float-right">
							<div class="form-group">
								<select class="form-control" onchange="location = this.value;">
									<?php foreach ($sorts as $sort) { ?> 
										<?php if ($sort['value']== $sort_by  . '-' . $order_by) { ?>
											<option value="<?php echo $sort['href']; ?>" selected><?php echo $sort['text']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $sort['href']; ?>"><?php echo $sort['text']; ?></option>  
										<?php } ?>
									<?php } ?>      
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<!-- Task -->
					<?php foreach ($projects as $project) { ?>
						<a href="<?php echo $project['href']; ?>" class="task-listing">
							<!-- Job Listing Details -->
							<div class="task-listing-details">
								<!-- Details -->
								<div class="task-listing-description">
									<h3 class="task-listing-title"><?php echo $project['name']; ?></h3>
									<ul class="task-icons">
										<li><i class="icon-material-outline-access-time"></i> <?php echo $project['date_added']; ?></li>
									</ul>
									<p class="task-listing-text"><?php echo $project['description']; ?></p>
									<?php if ($project['meta_keyword']) { ?>
										<div class="task-tags">
											<?php foreach ($project['meta_keyword'] as $meta_keyword) { ?>
												<span><?php echo $meta_keyword; ?></span>
											<?php } ?>	
										</div>
									<?php } ?>	
								</div>
							</div>
							<div class="task-listing-bid">
								<div class="task-listing-bid-inner">
									<div class="task-offers">
										<strong><?php echo $project['budget']; ?></strong>
										<span><?php echo $project['type']; ?></span>
									</div>
									<span class="button button-sliding-icon ripple-effect"><?php echo $button_bid_now; ?> <i class="fas fa-gavel"></i></span>
								</div>
							</div>
						</a>
					<?php } ?>
					<!-- ./Task END-->
				</div>
				<!-- Tasks Container / End -->
				<!-- Pagination -->
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12">
						<?php echo $pagination; ?>
					</div>
				</div>
				<!-- Pagination / End -->
			</div>
		</div>
		</div>
		</div> <!---- content-wrapper ---->
<script type="text/javascript">
// Skills
$('input[name=\'filter_category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'project/category/autocomplete?filter_category=' + encodeURIComponent(request.term),
			dataType : 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['university'],
						value: item['university_id'],
						country: item['country']
					}
				}));
			}
		});
	},
	'select': function(event, ui) {
		event.preventDefault();
		$('input[name=\'filter_university\']').val(ui.item.label);
		$('input[name=\'university_id\']').val(ui.item.value);
		$('input[name=\'education_country\']').val(ui.item.country);
	}
});
</script>	
<script>
	$( function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 10,
			max: 1000,
			values: [ 75, 300 ],
			slide: function( event, ui ) {
				$( "#amount" ).val( "EGP" + ui.values[ 0 ] + " - EGP" + ui.values[ 1 ] );
			}
		});
		$( "#amount" ).val( "EGP " + $( "#slider-range" ).slider( "values", 0 ) +
			" - EGP " + $( "#slider-range" ).slider( "values", 1 ) );
	} );
</script>	


<?php echo $footer; ?>