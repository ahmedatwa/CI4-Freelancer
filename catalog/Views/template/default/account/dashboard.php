<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container">
	<section class="gray">
	<div class="m-4">
		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<h3><?php echo $text_greeting; ?></h3>
		</div>
		
		<div class="row justify-content-center mb-4">
			<div class="col-auto mb-3">
				<div class="card mx-2">
					<div class="card-body row">
						<div class="col-9">
							<h2>Profile Views</h2>
						</div>
						<div class="col-3">
							<span class="text-right"><i class="far fa-eye fa-2x text-success"></i></span>
						</div>
						<div class="col-12"><h1 class="text-center"><?php echo $profile_views; ?></h1></div>
					</div>
				</div>
			</div>
			<div class="col-auto mb-3">
				<div class="card mx-2">
					<div class="card-body row">
						<div class="col-9">
							<h2>Total Projects</h2>
						</div>
						<div class="col-3">
							<span class="text-right"><i class="fas fa-briefcase fa-2x text-warning"></i></span>
						</div>
						<div class="col-12"><h1 class="text-center"><?php echo $projects_total; ?></h1></div>
					</div>
				</div>
			</div>
			<div class="col-auto mb-3">
				<div class="card mx-2">
					<div class="card-body row">
						<div class="col-9">
							<h2>Balance</h2>
						</div>
						<div class="col-3">
							<span class="text-right"><i class="fas fa-wallet fa-2x text-info"></i></span>
						</div>
						<div class="col-12"><h1 class="text-center"><?php echo $balance; ?></h1></div>
					</div>
				</div>
			</div>
		</div>
		<div class="content mt-4">
			<!-- Chart -->
			<div class="chart">
				<h3 class="mb-3"><i class="fas fa-chart-line text-danger"></i> Balance Monthly</h3>
				<canvas id="chart" width="100" height="45"></canvas>
			</div>
		</div>
		<div class="row">
			<!-- Dashboard Box -->
			<div class="col">
				<div class="dashboard-box mt-4">
					<div class="headline">
						<h3><i class="icon-material-baseline-notifications-none"></i> <?php echo $text_news_feed; ?></h3>
					</div>
					<div class="content shadow-sm p-4 m-2 border">
						<?php if ($news_feeds) { ?>
						<ul class="dashboard-box-list">
							<?php foreach ($news_feeds as $news_feed) { ?>
							<li>
								<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
								<span class="notification-text">
									<?php echo $news_feed['comment']; ?>. <small><?php echo $news_feed['date_added']; ?></small>	
								</span>
							</li>
							<?php } ?>
						</ul>
					<?php } else { ?>
					<p class="text-center">No Feeds! </p>	
				<?php } ?>
					</div>
				</div>
			</div>

		</div>
	</div>
	</section>
</div>
<!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
<script src="catalog/default/javascript/chart.min.js"></script>
<script>
	Chart.defaults.global.defaultFontFamily = "Nunito";
	Chart.defaults.global.defaultFontColor = '#888';
	Chart.defaults.global.defaultFontSize = '14';

	var ctx = document.getElementById('chart').getContext('2d');

	var chart = new Chart(ctx, {
		type: 'line',

		// The data for our dataset
		data: {
			labels: [],
			// Information about the dataset
	   		datasets: [{
				label: "Balance",
				backgroundColor: 'rgba(42,65,232,0.08)',
				borderColor: '#2a41e8',
				borderWidth: "3",
				data: [],
				pointRadius: 5,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			}]
		},

		// Configuration options
		options: {

		    layout: {
		      padding: 10,
		  	},

			legend: { display: false },
			title:  { display: false },

			scales: {
				yAxes: [{
					scaleLabel: {
						display: false
					},
					gridLines: {
						 borderDash: [6, 10],
						 color: "#d8d8d8",
						 lineWidth: 1,
	            	},
				}],
				xAxes: [{
					scaleLabel: { display: false },  
					gridLines:  { display: false },
				}],
			},

		    tooltips: {
		      backgroundColor: '#333',
		      titleFontSize: 13,
		      titleFontColor: '#fff',
		      bodyFontColor: '#fff',
		      bodyFontSize: 13,
		      displayColors: false,
		      xPadding: 10,
		      yPadding: 10,
		      intersect: false
		    }
		},
    });

    ajax_chart(chart, 'account/dashboard/chart');
    // function to update our chart
    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON('account/dashboard/chart', data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.total;
            chart.update(); 
        });
    }
</script>
<?php echo $footer; ?>