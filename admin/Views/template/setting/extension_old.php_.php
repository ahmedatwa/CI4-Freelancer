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
				<fieldset>
					<legend><?php echo $text_type; ?></legend>
					<div class="input-group">
						<select name="type" class="form-control">
							<?php foreach ($categories as $category) { ?>
								<?php if ($category['code'] == $type) { ?>
									<option value="<?php echo $category['href']; ?>" selected="selected"><?php echo $category['text']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $category['href']; ?>"><?php echo $category['text']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div class="input-group-append">
							<label class="input-group-text"><i id="filter" class="fa fa-filter"></i></label>
						</div>
					</div>
				</fieldset>
				<div id="extension" class="mt-3"></div>
			</div><!-- Card Body -->
		</div><!-- Card -->
	</div><!-- container-fluid -->

<div class="container-fluid">
			<div class="card">
			<div class="card-body">

<table id="example" class="table table-bordered">
        <thead>
            <tr>
            <th width="2%"></th>
            <th>text</th>
            </tr>
        </thead>
       
    </table>
   </div> 
</div>
</div>

	<!-- last Div dont delete -->
</div>

 <link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>

 <script type="text/javascript">
function format (d) {
       return d.href;
} 
var table = $('#example').DataTable( {
'ajax': {
	'url': "index.php/setting/extension/autocomplete?user_token=<?php echo $user_token;?>",
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
	"order": [[1, 'asc']]
});

    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
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
<?php if ($categories) { ?>
	<script type="text/javascript">
		$('select[name="type"]').on('change', function() {
			$.ajax({
				url: $('select[name="type"]').val(),
				dataType: 'html',
				beforeSend: function() {
					$('#filter').removeClass('fa fa-filter');
					$('#filter').addClass('fas fa-spinner fa-spin');
				},
				complete: function() {
					$('#filter').removeClass('fas fa-spinner fa-spin');
					$('#filter').addClass('fa fa-filter');
				},
				success: function(html) {
					$('#extension').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$('select[name="type"]').trigger('change');

		$('#extension').on('click', '.btn-success', function(e) {
			e.preventDefault();
			
			var element = this;

			$.ajax({
				url: $(element).attr('href'),
				dataType: 'html',
				beforeSend: function() {
					$(element).html('<i class="fas fa-spinner fa-spin"></i> loading...');
				},
				complete: function() {
					$(element).prop('disabled', false);

				},
				success: function(html) {
					$('#extension').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$('#extension').on('click', '.btn-danger, .btn-warning', function(e) {
			e.preventDefault();
			
			if (confirm('<?php echo $text_confirm; ?>')) {
				var element = this;
				
				$.ajax({
					url: $(element).attr('href'),
					dataType: 'html',
					beforeSend: function() {
						$(element).html('<i class="fas fa-spinner fa-spin"></i> loading...');
					},
					complete: function() {
						$(element).prop('disabled', false);
					},
					success: function(html) {
						$('#extension').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		});
		//--></script>
	<?php } ?>
	<?php echo $footer; ?>
