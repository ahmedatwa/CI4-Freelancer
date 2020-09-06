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
				<div class="table-responsive">
					<table id="table-extension" class="table">
						<thead>
							<tr>
								<th width="1%"></th>
								<th><?php echo $column_name; ?></th>
							</tr>
						</thead>

					</table>
				</div>
			</div><!-- Card Body -->
		</div><!-- Card -->
	</div><!-- container-fluid -->
</div>
<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>
 <script type="text/javascript">
function format (d) {
       return d.href;
} 
var table = $('#table-extension').DataTable( {
'ajax': {
	'url': "index.php/setting/extension/getList?user_token=<?php echo $user_token;?>",
	'dataSrc': '',
    },
	"columns": [
	   {
		"className": 'details-control',
		"orderable": false,
		"data": null,
		"defaultContent": ''
	   },
	{ "data": "text" },
	],
	"order": [[1, 'asc']],
	"processing": true
});

// Add event listener for opening and closing details
$('#table-extension tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
    	$.ajax({
	    	url: format(row.data()),
	    	dataType: 'html',
	    	success: function(html) {
	    		row.child(html).show();
	    	},
	    });
        // Open this row
        tr.addClass('shown');
    }
});       
 </script>   
<?php echo $footer; ?>
