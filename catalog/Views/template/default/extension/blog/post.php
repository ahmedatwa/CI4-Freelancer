{{ header }}{{ menu }}
<main class="bg_color">
		<div class="filters_full">
		    <div class="container clearfix">
		        <div class="sort_select">
		            <select name="sort" id="sort">
		                <option value="popularity" selected="selected">Sort by Popularity</option>
		                <option value="rating">Sort by Average rating</option>
		                <option value="date">Sort by newness</option>
		            </select>
		        </div>
		        <a href="#collapseFilters" data-toggle="collapse" class="btn_filters"><i class="icon_adjust-vert"></i><span>Filters</span></a>
		        <a class="btn_map mobile btn_filters" data-toggle="collapse" href="#collapseMap"><i class="icon_pin_alt"></i></a>
		        <div class="search_bar_list">
				    <input type="text" class="form-control" placeholder="Search again...">
				</div>
				<a class="btn_search_mobile btn_filters" data-toggle="collapse" href="#collapseSearch"><i class="icon_search"></i></a>
		    </div>
		    <div class="collapse filters_2" id="collapseFilters">
		    <div class="container margin_detail">
		        <div class="row">
		            <div class="col-md-4">
		                <div class="filter_type">
		                    <h6>Rating</h6>
		                    <ul>
		                        <li>
		                            <label class="container_check">Superb 9+ <small>06</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                        <li>
		                            <label class="container_check">Very Good 8+ <small>12</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                        <li>
		                            <label class="container_check">Good 7+ <small>17</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                        <li>
		                            <label class="container_check">Pleasant 6+ <small>43</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <div class="col-md-4">
		            	 <div class="filter_type">
		                    <h6>Availability</h6>
		                    <ul>
		                        <li>
		                            <label class="container_check">Apointment <small>12</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                        <li>
		                            <label class="container_check">Chat <small>24</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                        <li>
		                            <label class="container_check">Video Call <small>23</small>
		                                <input type="checkbox">
		                                <span class="checkmark"></span>
		                            </label>
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <div class="col-md-4">
		                <div class="filter_type">
		                    <h6>Price</h6>
		                    <div class="range_input">Price range from 0 to <span></span>$</div>
		                    <div><input type="range" min="10" max="100" step="10" value="30" data-orientation="horizontal"></div>
		                </div>
		            </div>
		        </div>
		        <!-- /row -->
		    </div>
		</div>
		<!-- /filters -->
		<div class="collapse" id="collapseSearch">
		    <div class="search_bar_list">
		        <input type="text" class="form-control" placeholder="Search again...">
		    </div>
		</div>
		<!-- /collapseSearch -->
		</div>
		<!-- /filters_full -->

		<div class="collapse" id="collapseMap">
			<div id="map" class="map"></div>
		</div>
		<!-- /Map -->

		<div class="container margin_30_40">
			<div class="page_header">
			    <div class="breadcrumbs">
			        <ul>
			        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
			            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			        <?php } ?>    
			        </ul>
			    </div>
			    <h1><?php //echo $text_jobs; ?></h1><span>: <?php //echo $total_jobs; ?> <?php //echo $text_found; ?></span>
			</div>
			<!-- /page_header -->
	    <div class="row">
	                            <h3>{{ title }}</h3>
	                            <small>Pediatrician, Psychologist ...</small>
	                        </div>
	        <!-- /strip grid -->
	    </div>
	    <!-- /row -->
	</div>
	<!-- /container -->	
	</main>
	<!-- /main -->
{{ footer }}