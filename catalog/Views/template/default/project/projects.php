<?php echo $header; ?> 
<div class="container margin-top-90">
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="sidebar-container">
				
				<!-- Location -->
				<div class="sidebar-widget">
					<h3>Location</h3>
					<div class="input-with-icon">
						<div id="autocomplete-container">
							<input id="autocomplete-input" type="text" placeholder="Location">
						</div>
						<i class="icon-material-outline-location-on"></i>
					</div>
				</div>

				<!-- Category -->
				<div class="sidebar-widget">
					<h3>Category</h3>
					<select class="selectpicker default" multiple data-selected-text-format="count" data-size="7" title="All Categories" >
						<option>Admin Support</option>
						<option>Customer Service</option>
						<option>Data Analytics</option>
						<option>Design & Creative</option>
						<option>Legal</option>
						<option>Software Developing</option>
						<option>IT & Networking</option>
						<option>Writing</option>
						<option>Translation</option>
						<option>Sales & Marketing</option>
					</select>
				</div>

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

				<!-- Hourly Rate -->
				<div class="sidebar-widget">
					<h3>Hourly Rate</h3>
					<div class="margin-top-55"></div>

					<!-- Range Slider -->
					<input class="range-slider" type="text" value="" data-slider-currency="$" data-slider-min="10" data-slider-max="150" data-slider-step="5" data-slider-value="[10,200]"/>
				</div>

				<!-- Tags -->
				<div class="sidebar-widget">
					<h3>Skills</h3>

					<div class="tags-container">
						<div class="tag">
							<input type="checkbox" id="tag1"/>
							<label for="tag1">front-end dev</label>
						</div>
						<div class="tag">
							<input type="checkbox" id="tag2"/>
							<label for="tag2">angular</label>
						</div>
						<div class="tag">
							<input type="checkbox" id="tag3"/>
							<label for="tag3">react</label>
						</div>
						<div class="tag">
							<input type="checkbox" id="tag4"/>
							<label for="tag4">vue js</label>
						</div>
						<div class="tag">
							<input type="checkbox" id="tag5"/>
							<label for="tag5">web apps</label>
						</div>
						<div class="tag">
							<input type="checkbox" id="tag6"/>
							<label for="tag6">design</label>
						</div>
						<div class="tag">
							<input type="checkbox" id="tag7"/>
							<label for="tag7">wordpress</label>
						</div>
					</div>
					<div class="clearfix"></div>

					<!-- More Skills -->
					<div class="keywords-container margin-top-20">
						<div class="keyword-input-container">
							<input type="text" class="keyword-input" placeholder="add more skills"/>
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
					<select class="">
						<option>Relevance</option>
						<option>Newest</option>
						<option>Oldest</option>
						<option>Random</option>
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
									<!-- <li><i class="icon-material-outline-location-on"></i> <</li>-->					
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
									<strong><?php echo $project['price']; ?></strong>
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
</div><?php echo $footer; ?>