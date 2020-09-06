const newLocal = "<?php echo $button_cancel; ?>";
<script type="text/javascript">
$('#button-save').on('click', function(e) {
swal({
    title: "<?php echo $text_confirm; ?>",
    //text: "<?php echo $text_no_recover; ?>",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "<?php echo $text_form; ?>",
    cancelButtonText: newLocal,
    closeOnConfirm: false,
    closeOnCancel: true,
    showLoaderOnConfirm: true,
    },
    function(isConfirm) {
        if (isConfirm) {
        $.ajax({
            url: '<?php echo $action; ?>',
            method:'post',
            dataType: 'json',
            data: $('#form-location').serialize(),
            success: function(json) {

                if (json['error']) {        
                 swal("Error!", json['warning'] , "error");
                }

                for (i in json['error']) {
					var element = $('#input-' + i.replace('_', '-'));

					if (element.parent().hasClass('input-group')) {
                   		$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}
                if (json['success']) {
                    setTimeout(function () {
                        swal("Success!", json['success'], "success");
                        //location.reload();
                    }, 800);
                }
            }, // success
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", thrownError , "error");
            }
        });
    } // Confirm        
  });    
});
</script>


<script type="text/javascript">
  $('#button-form').on('click', function(e) {
   e.preventDefault();
   swal({
    title: "<?php echo $text_confirm; ?>",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "<?php echo $text_form; ?>",
    cancelButtonText: "<?php echo $button_cancel; ?>",
    closeOnConfirm: false,
    closeOnCancel: true,
    showLoaderOnConfirm: true,
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: '<?php echo $action; ?>',
        method:'post',
        dataType: 'json',
        data: $('#form-location').serialize(),
        success: function(json) {
                // Form Validation
                if (json['error_warning']) {        
                 swal("Error!", json['error_warning'] , "error");
               }

               if (json['validator']) {
                for (i in json['validator']) {
                 var element = $('#input-' + i.replace('_', '-'));

                 if (element.parent().hasClass('input-group')) {
                   $(element).parent().after('<div class="text-danger">' + json['validator'][i] + '</div>');
                 } else {
                  $(element).after('<div class="text-danger">' + json['validator'][i] + '</div>');
                }
              }
            }
            if (json['success']) {
              setTimeout(function () {
               if (json['redirect']) {
                location = json['redirect'];
              }
            }, 800);
            }
            }, // success
            error: function (xhr, ajaxOptions, thrownError) {
              swal("Error!", thrownError , "error");
            }
          });
    } // Confirm        
  });    
 });
</script>