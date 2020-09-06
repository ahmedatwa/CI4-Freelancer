
</style>
<div id="filemanager" class="modal-dialog modal-lg modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
	<h4 class="modal-title"><i class="far fa-images"></i> <?php echo $heading_title; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body">
    <div class="row">
	<div class="col-sm-5">
	<a href="<?php echo $home; ?>" data-toggle="tooltip" title="<?php echo $button_home; ?>" data-placement="top" id="button-home" class="btn btn-primary"><i class="fas fa-home"></i></a> 
	<a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" data-placement="top" id="button-back" class="btn btn-secondary"><i class="fas fa-reply"></i></a>  
	<button type="button" data-toggle="tooltip" title="<?php echo $button_upload; ?>" data-placement="top" id="button-upload" class="btn btn-success"><i class="fas fa-cloud-upload-alt"></i></button>
    <button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $button_folder; ?>" id="button-folder" class="btn btn-dark"><i class="fas fa-folder"></i></button>
    <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" data-placement="top" id="button-delete" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
	<a href="<?php echo $refresh; ?>" id="button-refresh"></a>
    </div>
<!--         <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="search" value="" placeholder="<?php //echo $entry_search; ?>" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="<?php //echo $button_search; ?>" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span></div>
        </div> -->
	</div>
    <hr />
	<div class="row">
        <?php foreach ($images as $image) { ?>
        <div class="col-sm-3 col-xs-6 text-center">
		<?php if($image['type'] == 'directory') { ?>
          <div class="text-center">
		  <a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
          <label><input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" /> <?php echo $image['name']; ?></label>
		<?php } ?>
		<?php if($image['type'] == 'image') { ?>
          <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
          <label><input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" /> <?php echo $image['name']; ?></label>
		<?php } ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
<?php if($target) { ?>
$('a.thumbnail').on('click', function(e) {
	e.preventDefault();

	<?php if ($thumb) { ?>
	$('#<?php echo $thumb; ?>').find('img').attr('src', $(this).find('img').attr('src'));
	<?php } ?>

	$('#<?php echo $target; ?>').val($(this).parent().find('input').val());

	$('#modal-image').modal('hide');
});
<?php } ?>

$('a.directory').on('click', function(e) {
	e.preventDefault();
	$('#modal-image').load($(this).attr('href'));
});

$('#button-back').on('click', function(e) {
	e.preventDefault();
	$('#modal-image').load($(this).attr('href'));
});

$('#button-home').on('click', function(e) {
	e.preventDefault();
	$('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
	e.preventDefault();
	$('#modal-image').load($(this).attr('href'));
});


$('input[name=\'search\']').on('keydown', function(e) {
	if (e.which == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').on('click', function(e) {
	var url = '<?php echo $search; ?>';

	var filter_name = $('input[name=\'search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	<?php if ($thumb) { ?>
	url += '&thumb=' + '<?php echo $thumb; ?>';
	<?php } ?>

	<?php if ($target) { ?>
	url += '&target=' + '<?php echo $target; ?>';
	<?php } ?>

	$('#modal-image').load(url);
});
</script>
<script type="text/javascript">
$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

	$('#form-upload input[name=\'file[]\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file[]\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php/common/filemanager/upload?user_token=<?php echo $user_token; ?>&directory=<?php echo $directory;?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#button-folder').on('click', function(e) {
   e.preventDefault();
  swal({
  title: 'New Folder',
  type: "input",
  showCancelButton: true,
  closeOnConfirm: true,
  closeOnCancel: true,
  showLoaderOnConfirm: true,
  inputPlaceholder: '<?php echo $entry_folder; ?>',
  },
    function(inputValue) {
		if (inputValue === false) return false;
        if (inputValue) {
			$.ajax({
			url: '<?php echo $folder; ?>',
			type: 'post',
			dataType: 'json',
			data: 'folder=' + encodeURIComponent(inputValue),
			beforeSend: function() {
				$('#button-folder').prop('disabled', true);
			},
			complete: function() {
				$('#button-folder').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					swal("Warning: ", json['error'], "error");
				}

				if (json['success']) {
					//swal("Success: ", json['success'], "success");
					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
    } // Confirm        
});
});

$('#modal-image #button-delete').on('click', function(e) {
	if (confirm('<?php echo $text_confirm; ?>')) {
		$.ajax({
			url: '<?php echo $delete; ?>',
			type: 'post',
			dataType: 'json',
			data: $('input[name^=\'path\']:checked'),
			beforeSend: function() {
				$('#button-delete').prop('disabled', true);
			},
			complete: function() {
				$('#button-delete').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
</script>