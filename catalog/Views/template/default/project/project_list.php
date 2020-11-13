<?php echo $header; ?><?php echo $menu; ?>
<div class="jumbotron">
	<div class="container-fluid">
		<h2 class="display-5"><?php echo $heading_title; ?></h2>
		<div class="text-right mt-4 w-100">
			<a href="<?php echo $add_project; ?>" class="button rounded"><?php echo $button_hire; ?></a>
			<a href="<?php echo $login; ?>" class="button dark text-white"><?php echo $button_work; ?></a>
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
<div class="section mb-5 bg-white margin-top-30">		
		<div class="row">
			<div class="col">
				<div class="sidebar-container">
					<p><i class="fas fa-filter"></i> <?php echo $text_sidebar; ?></p>
					<div class="dropdown-divider"></div>
					<div class="sidebar-widget">
						<h3><?php echo $text_type; ?></h3> 
						<?php foreach ($types as $type) { ?>
						<?php if(in_array($type['value'], $filter_type) ) { ?>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="<?php echo $type['value']; ?>" name="filter_type[]" checked>
							<label class="form-check-label" for="defaultCheck1">
								<?php echo $type['text']; ?>
							</label>
						</div>
					<?php } else { ?>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="<?php echo $type['value']; ?>" name="filter_type[]">
							<label class="form-check-label" for="defaultCheck1">
								<?php echo $type['text']; ?>
							</label>
						</div>
					<?php } ?>	
					<?php } ?>	
					</div>
					<div class="dropdown-divider"></div>
					<!-- Budget -->
					<div class="sidebar-widget">
						<h3><?php echo $text_budget; ?></h3>
						 <div class="form-row">
					    <input class="range-slider" type="text" value="" data-provide="slider" data-slider-currency="$" data-slider-min="5" data-slider-max="2500" data-slider-step="5" data-slider-value="[<?php echo str_replace('_', ',', $filter_budget); ?>]" name="filter_budget"/>
					  </div>
					</div>
					<div class="dropdown-divider"></div>
					<!-- Tags -->
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
					<div class="keywords-list mt-4"></div>
					<div class="dropdown-divider"></div>
					<div class="sidebar-widget">
						<h3><?php echo $text_state; ?></h3>
						<?php foreach ($states as $state) { ?>
						<?php if($state['value'] == $filter_state)  { ?>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="<?php echo $state['value']; ?>" name="filter_state[]" checked>
							<label class="form-check-label" for="exampleRadios1">
								<?php echo $state['text']; ?>
							</label>
						</div>
					<?php } else { ?>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="<?php echo $state['value']; ?>" name="filter_state[]">
							<label class="form-check-label" for="exampleRadios1">
								<?php echo $state['text']; ?>
							</label>
						</div>
					<?php } ?>	
					<?php } ?>	
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-9 mb-4">
				<!-- Tasks Container -->
				<div class="tasks-list-container compact-list shadow mb-5 bg-white rounded">
					<div class="notify-box">
						<h3 class="float-left mx-4 mt-2"><?php echo $text_found ;?></h3>
						<div class="col-md-3 float-right">
							<div class="form-group">
								<select class="custom-select" onchange="location = this.value;">
									<?php foreach ($sorts as $sort) { ?> 
										<?php if ($sort['value'] == $sort_by  . '-' . $order_by) { ?>
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
					<?php if ($projects) { ?>
					<?php foreach ($projects as $project) { ?>
						<a href="<?php echo $project['href']; ?>" class="task-listing">
							<div class="task-listing-details">
								<div class="task-listing-description">
									<h3 class="task-listing-title"><?php echo $project['name']; ?></h3>
									<ul class="task-icons">
										<li><i class="icon-material-outline-access-time"></i> <?php echo $project['date_added']; ?></li>
									</ul>
									<p class="col task-listing-text text-wrap"><?php echo $project['description']; ?></p>
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
					<?php } else { ?>
						<div class="col-12 text-center p-4">
						<p class="p-4">No Projects Found !</p>
						<a role="button" href="<?php echo $add_project; ?>" class="btn btn-danger btn-lg">Add Project</a>
					</div>
			      <?php } ?>	
				</div>
				<div class="clearfix"></div>
					<div class="col-12">
						<?php echo $pagination; ?>
					</div>
			</div>
		</div>
	</div>
</div> <!---- content-wrapper ---->
<link href="catalog/default/vendor/select2/customSelectionAdapter/css/select2.customSelectionAdapter.min.css">		
<script src="catalog/default/vendor/select2/customSelectionAdapter/js/select2.customSelectionAdapter.min.js"></script>
<script type="text/javascript">

var uri = document.URL;

// Skills
var CustomSelectionAdapter = $.fn.select2.amd.require("select2/selection/customSelectionAdapter");
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
allowClear: false,
minimumResultsForSearch: 5,
selectionAdapter: CustomSelectionAdapter,
selectionContainer: $('.keywords-list'),

}).on("select2:select", function (e) { 
	var select_val = $(e.currentTarget).val();

	$.ajax({
		url: 'project/project/filter?url=' + encodeURIComponent(uri),
		dataType: 'json',
		method: 'post',
		data: {'CSRFCAT': $('meta[name="CSRFCAT"]').attr('content'), skills: select_val.join('_')},
		beforeSend: function() {
			$('#overlay').fadeIn().delay(2000);
		},
		complete: function() {
  		    $('#overlay').fadeOut();
		},
		success: function(json) {
			location = json['uri'];
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
  
}).on('select2:unselect', function (e) {
	  var select_val = $(e.currentTarget).val();
	  console.log(select_val)

	  $.ajax({
		url: 'project/project/filter?url=' + encodeURIComponent(uri),
		dataType: 'json',
		method: 'post',
		data: {'CSRFCAT': $('meta[name="CSRFCAT"]').attr('content'), clear: 'skills'},
		beforeSend: function() {
			$('#overlay').fadeIn().delay(2000);
		},
		complete: function() {
  		    $('#overlay').fadeOut();
		},
		success: function(json) {
			location = json['uri'];
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

// <!-- // Filters -->
$('input[name^=\'filter_state\']').on('click', function() {

    var filter = [];
    
    $('input[name^=\'filter_state\']:checked').each(function(element) {
        filter.push(this.value);
    });

    $.ajax({
		url: 'project/project/filter?url=' + encodeURIComponent(uri),
		dataType: 'json',
		method: 'post',
		data: {'CSRFCAT': $('meta[name="CSRFCAT"]').attr('content'), state: filter.join('_')},
		beforeSend: function() {
			$('#overlay').fadeIn().delay(2000);
		},
		complete: function() {
  		    $('#overlay').fadeOut();
		},
		success: function(json) {
			location = json['uri'];
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
 });    

$('input[name^=\'filter_type\']').on('click', function() {

    var filter = [];
    
    $('input[name^=\'filter_type\']:checked').each(function(element) {
        filter.push(this.value);
    });

	$.ajax({
		url: 'project/project/filter?url=' + encodeURIComponent(uri),
		dataType: 'json',
		method: 'post',
		data: {'CSRFCAT': $('meta[name="CSRFCAT"]').attr('content'), type: filter.join('_')},
		beforeSend: function() {
			$('#overlay').fadeIn().delay(2000);
		},
		complete: function() {
  		    $('#overlay').fadeOut();
		},
		success: function(json) {
			location = json['uri'];
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}); 

// <!-- // Filter Budget -->
var mySlider = $("input[name=\'filter_budget\']").slider();

mySlider.on('slideStop', function(e){
	var filter = e.value;
	
	$.ajax({
		url: 'project/project/filter?url=' + encodeURIComponent(uri),
		dataType: 'json',
		method: 'post',
		data: {'CSRFCAT': $('meta[name="CSRFCAT"]').attr('content'), budget: filter.join('_')},
		beforeSend: function() {
			$('#overlay').fadeIn().delay(2000);
		},
		complete: function() {
  		    $('#overlay').fadeOut();
		},
		success: function(json) {
			location = json['uri'];
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});

</script>
<?php echo $footer; ?>