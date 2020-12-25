<?php echo $header; ?><?php echo $menu; ?>
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
				
				<!-- Keywords -->
<!-- 				<div class="sidebar-widget">
					<h3>Keywords</h3>
					<div class="keywords-container">
						<div class="keyword-input-container">
							<input type="text" class="keyword-input" placeholder="e.g. job title"/>
							<button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
						</div>
						<div class="keywords-list">/div>
						<div class="clearfix"></div>
					</div>
				</div> -->
					<!-- Tags -->
					<!--<div class="dropdown-divider"></div>
					 <div class="sidebar-widget">
						<h3><?php //echo $text_tags; ?></h3>
						<div class="keywords-container margin-top-20">
							<div class="input-group keyword-input-container">
								<select class="form-control" name="filter_category[]" data-width="100%" multiple="multiple">
									<?php //foreach($tags as $tag) { ?>
									<?php //if (in_array($tag['id'], $filter_tags)) { ?>
										<option value="<?php //echo $tag['id']; ?>" selected><?php //echo $tag['text']; ?></option>
										<?php //} else { ?>
										<option value="<?php //echo $tag['id']; ?>"><?php //echo $tag['text']; ?></option>
										<?php //} ?>
										<?php //} ?>
									</select>
							</div> 
						</div>
					</div>-->
				</div>
			</div>
			<div class="col-sm-12 col-md-9 mb-4">
				<!-- Tasks Container -->
				<div class="notify-box margin-top-15">
				<div class="switch-container">
					<?php echo $text_found ;?>
				</div>
				<div class="sort-by">
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
				<div class="clearfix"></div>
					<!-- Task -->
					<div class="listings-container margin-top-35">
				    <?php foreach ($jobs as $job) { ?>
				     <a href="<?php echo $job['href']; ?>" class="job-listing">
					  <div class="job-listing-details">
						
						<div class="job-listing-description">
							<h3 class="job-listing-title"><?php echo $job['name']; ?></h3>
							<p class="job-listing-text"><?php echo $job['description']; ?></p>
						</div>
					</div>
					<div class="job-listing-footer">
						<ul>
							<li><i class="icon-material-outline-business-center"></i> <?php echo $job['type']; ?></li>
							<li><i class="icon-material-outline-access-time"></i> <?php echo $job['date_added']; ?></li>
						</ul>
					</div>
				</a>	
			<?php } ?>
			</div>
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
	    headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
          "X-Requested-With": "XMLHttpRequest"
        },
		dataType: 'json',
		method: 'post',
		data: {skills: select_val.join('_')},
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
	    headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
          "X-Requested-With": "XMLHttpRequest"
        },
		dataType: 'json',
		method: 'post',
		data: {clear: 'skills'},
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

$('input[name^=\'filter_type\']').on('click', function() {

    var filter = [];

    $('input[name^=\'filter_type\']:checked').each(function(element) {
        filter.push(this.value);
    });

	$.ajax({
		url: 'extension/job/job/filter?url=' + encodeURIComponent(uri),
	    headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
          "X-Requested-With": "XMLHttpRequest"
        },
		dataType: 'json',
		method: 'post',
		data: {type: filter.join('_')},
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