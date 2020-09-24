<?php echo $header; ?>
<!-- Dashboard Container -->
<div class="dashboard-container">
	<!-- Dashboard Sidebar-->
	<div class="dashboard-sidebar">
		<div class="dashboard-sidebar-inner" data-simplebar>
			<div class="dashboard-nav-container">
				<!-- Responsive Navigation Trigger -->
				<a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
					<span class="trigger-title"><?php echo $text_dashboard; ?></span>
				</a>
				
				<!-- Navigation -->
				<div class="dashboard-nav">
					<div class="dashboard-nav-inner">
						<?php foreach ($menus as $menu) { ?>
						<ul data-submenu-title="<?php echo $menu['name']; ?>">
							<?php foreach ($menu['children'] as $child) { ?>
							<?php if (!empty($child['children'])) { ?>	
							<li><a href="#"><i class="icon-material-outline-assignment"></i> <?php echo $child['name']; ?></a>
								<ul>
								<?php foreach ($child['children'] as $sibling) { ?>
									<li><a href="<?php echo $sibling['href']; ?>"><i class="<?php echo $sibling['icon']; ?>"></i> <?php echo $sibling['name']; ?></a></li>
								<?php } ?>	
								</ul>	
							</li>
							<?php } else { ?>	
							<li class="<?php echo $child['class']; ?>"><a href="<?php echo $child['href']; ?>"><i class="<?php echo $child['icon']; ?>"></i> <?php echo $child['name']; ?></a></li>
						   <?php } ?>
						   <?php } ?>
						</ul>
					<?php } ?>			
					</div>
				</div>
				<!-- Navigation / End -->
			</div>
		</div>
	</div>
	<!-- Dashboard Sidebar / End -->
	<!-- Dashboard Content -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<h3>Howdy, Tom!</h3>
				<span>We are glad to see you again!</span>
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Dashboard</li>
					</ul>
				</nav>
			</div>
	
			<!-- Fun Facts Container -->
			<div class="fun-facts-container">
				<div class="fun-fact" data-fun-fact-color="#36bd78">
					<div class="fun-fact-text">
						<span>Task Bids Won</span>
						<h4>22</h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
				</div>
				<div class="fun-fact" data-fun-fact-color="#b81b7f">
					<div class="fun-fact-text">
						<span>Jobs Applied</span>
						<h4>4</h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-material-outline-business-center"></i></div>
				</div>
				<div class="fun-fact" data-fun-fact-color="#efa80f">
					<div class="fun-fact-text">
						<span>Reviews</span>
						<h4>28</h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
				</div>

				<!-- Last one has to be hidden below 1600px, sorry :( -->
				<div class="fun-fact" data-fun-fact-color="#2a41e6">
					<div class="fun-fact-text">
						<span>This Month Views</span>
						<h4>987</h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
				</div>
			</div>
			
			<!-- Row -->
			<div class="row">

				<div class="col-xl-12">
					<!-- Dashboard Box -->
					<div class="dashboard-box main-box-in-row">
						<div class="headline">
							<h3><i class="icon-feather-bar-chart-2"></i> Your Profile Views</h3>
							<div class="sort-by">
								<select class="selectpicker hide-tick">
									<option>Last 6 Months</option>
									<option>This Year</option>
									<option>This Month</option>
								</select>
							</div>
						</div>
						<div class="content">
							<!-- Chart -->
							<div class="chart">
								<canvas id="chart" width="100" height="45"></canvas>
							</div>
						</div>
					</div>
					<!-- Dashboard Box / End -->
				</div>
			</div> <!-- Row / End -->

			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-6">
					<div class="dashboard-box">
						<div class="headline">
							<h3><i class="icon-material-baseline-notifications-none"></i> Notifications</h3>
							<button class="mark-as-read ripple-effect-dark" data-tippy-placement="left" title="Mark all as read">
									<i class="icon-feather-check-square"></i>
							</button>
						</div>
						<div class="content">
							<ul class="dashboard-box-list">
								<li>
									<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
									<span class="notification-text">
										<strong>Michael Shannah</strong> applied for a job <a href="#">Full Stack Software Engineer</a>
									</span>
									<!-- Buttons -->
									<div class="buttons-to-right">
										<a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
									</div>
								</li>
								
							</ul>
						</div>
					</div>
				</div>
				<!-- Dashboard Box -->
				<div class="col-xl-6">
					<div class="dashboard-box">
						<div class="headline">
							<h3><i class="icon-material-outline-assignment"></i> Orders</h3>
						</div>
						<div class="content">
							<ul class="dashboard-box-list">
								<li>
									<div class="invoice-list-item">
									<strong>Professional Plan</strong>
										<ul>
											<li><span class="unpaid">Unpaid</span></li>
											<li>Order: #326</li>
											<li>Date: 12/08/2018</li>
										</ul>
									</div>
									<!-- Buttons -->
									<div class="buttons-to-right">
										<a href="pages-checkout-page.html" class="button">Finish Payment</a>
									</div>
								</li>
		
							</ul>
						</div>
					</div>
				</div>
			</div>