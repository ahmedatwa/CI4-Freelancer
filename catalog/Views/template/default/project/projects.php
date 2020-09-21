<?php echo $header; ?> 
<div class="container margin-top-90">
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="sidebar-container">
				<!-- Keywords -->
				<div class="sidebar-widget">
					<h3>Keywords</h3>
					<div class="keywords-container">
						<div class="keyword-input-container">
							<input type="text" class="keyword-input" placeholder="e.g. task title"/>
							<button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
						</div>
						<div class="keywords-list"><!-- keywords go here --></div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- Budget -->
				<div class="sidebar-widget">
					<h3>Fixed Price</h3>
					<div class="margin-top-55"></div>
					<!-- Range Slider -->
					<input class="range-slider" type="text" value="" data-slider-currency="$" data-slider-min="10" data-slider-max="2500" data-slider-step="25" data-slider-value="[10,2500]"/>
				</div>
				<!-- Tags -->
				<div class="sidebar-widget">
					<h3>Skills</h3>
					<!-- More Skills -->
					<div class="keywords-container margin-top-20">
						<div class="keyword-input-container">
							<input type="text" class="keyword-input" placeholder="add more skills" name="filter_skill" />
							<button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
						</div>
						<div class="keywords-list"><!-- keywords go here --></div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>

			</div>
		</div>
		<div class="col-xl-9 col-lg-8 content-left-offset">
		<div class="notify-box margin-top-15">
				<div class="sort-by">
					<span>Sort by:</span>
                    <select class="selectpicker hide-tick" onchange="location = this.value;">
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
			
			<!-- Tasks Container -->
			<div class="tasks-list-container compact-list margin-top-35">
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
								<?php if ($project['tags']) { ?>
									<div class="task-tags">
										<?php foreach ($project['tags'] as $tag) { ?>
											<span><?php echo $tag; ?></span>
										<?php } ?>	
									</div>
								<?php } ?>	
							</div>
						</div>
						<div class="task-listing-bid">
							<div class="task-listing-bid-inner">
								<div class="task-offers">
									<strong><?php echo $project['budget']; ?></strong>
									<span>Fixed Price</span>
								</div>
								<span class="button button-sliding-icon ripple-effect">Bid Now <i class="icon-material-outline-arrow-right-alt"></i></span>
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
<script type="text/javascript">
$('input[name=\'filter_skill\']').typeahead({
    source: function (query, result) {
        $.ajax({
            url: "projects/autocomplete?filter_skill=" + query,
            dataType: "json",
            success: function (data) {
				result($.map(data, function (item) {
					return item;
                }));
            }
        });
    }
});
</script>	
</div>
<?php echo $footer; ?>