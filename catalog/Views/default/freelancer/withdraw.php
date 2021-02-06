<?php echo $header; ?> 
<div class="jumbotron">
	<div class="container-fluid">
		<h2 class="display-5"><?php echo $heading_title; ?></h2>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">

		</div>
	</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-8">
			<!-- Hedline -->
			<h3 class="heading"><?php echo $heading_title; ?></h3>
			<div class="card mt-4">
			<div class="card-body">	
			<form action="<?php echo $action; ?>" method="post" encrypt="multipart/form-data" accept-charset="utf-8" id="form-withdraw">
			<input type="hidden" name="status_id" value="<?php echo $status_id; ?>" />
			<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
			  <div class="form-group row">
			    <label for="input-amount" class="col-sm-2 col-form-label"><?php echo $entry_amount; ?></label>
			    <div class="col-sm-10">
			      <input type="number" class="form-control" id="input-amount" name="amount" value="<?php echo $amount; ?>">
			    </div>
			  </div>
			  <div class="text-right">
			  	<?php if ($amount > 0) { ?>
			    <button type="button" id="button-submit" class="btn btn-danger"><?php echo $button_submit; ?></button>
			   <?php } else { ?>
			   	<button type="button" class="btn btn-danger" disabled><?php echo $button_submit; ?></button>
			   <?php } ?>
			</div>
			</form>
			</div>
		</div>
		  <div class="dropdown-divider mb-4 mt-4"></div>
		<div class="table-responsive mt-4">
			<table class="table table-striped table-bordered" id="table-withdraw">
				<thead>
					<tr>
						<th scope="col"><?php echo $column_date_added; ?></th>
						<th scope="col"><?php echo $column_amount; ?></th>
						<th scope="col"><?php echo $column_status; ?></th>
						<th scope="col"><?php echo $column_date; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($withdrawals as $withdrawal) { ?>
					<tr>
						<td><?php echo $withdrawal['date_added']; ?></td>
						<td><?php echo $withdrawal['amount']; ?></td>
						<td><?php echo $withdrawal['status']; ?></td>
						<td><?php echo $withdrawal['date_processed']; ?></td>
					</tr>
				<?php } ?>	
				</tbody>
			</table>
		</div>	
	</div>
		<!-- Summary -->
		<div class="col margin-top-50">
			<!-- Summary -->
			<div class="boxed-widget summary margin-top-0">
				<div class="boxed-widget-headline" id="payment-summery">
					<h3><?php echo $text_balance; ?></h3>
				</div>
				<div class="boxed-widget-inner">
					<ul>
						<li class=""><?php echo $text_total; ?> <span id="total"><?php echo $balance; ?></span></li>
					</ul>
				</div>
			</div>
			<!-- Summary / End -->
		</div>
	</div>
</div>
<!-- Container / End -->
</div>
<div class="margin-bottom-30"></div>
<link href="catalog/default/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript">
var table = $('#table-withdraw').DataTable({
    "order":[[ 1, "asc" ]],
    "lengthMenu": [10, 20, 30]
});
// submit the form
$('#button-submit').on('click', function() {
	var $node = $(this);
	bootbox.confirm({
    message: "Are you sure?",
    size: 'small',
    className: 'animate__animated animate__fadeInDown',
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel',
            className: 'btn-dark'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm',
            className: 'btn-success'
        }
    },
    callback: function (result) {
   if (result) {
	$.ajax({
		url: 'freelancer/withdraw/add',
		headers: {
              'X-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content'),
              'X-Requested-With': 'XMLHttpRequest'
        },
		method: 'post',
		dataType: 'json',
		data: $('#form-withdraw').serialize(),
		beforeSend: function() {
			$('.fas, .alert').remove();
			$($node).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
			$('#overlay').fadeIn().delay(2000);
		},
		complete: function() {
			$('#overlay').fadeOut(2000);
		},
		success: function(json) {
			if (json['success']) {
				$('.card-body').before('<div class="alert alert-success alert-dismissible fade show" role="alert">'+ json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				location.reload();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
		 alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	    }
	});
	}
    } 
   });  
});
</script>
<?php echo $footer; ?>
