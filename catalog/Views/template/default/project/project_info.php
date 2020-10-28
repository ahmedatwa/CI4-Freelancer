<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded">
	<div class="dashboard-content-inner" >
		<div class="dashboard-headline">
			<h3><?php echo $name; ?></h3>
            <small><?php echo $budget; ?></small>
		</div>
		<div class="row">
			<div class="col-12">
			<ul class="nav nav-tabs" id="project-info" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="bids-tab" data-toggle="tab" href="#bids" role="tab" aria-controls="bids" aria-selected="true">Bids</a>
                </li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="true">Messages</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones" role="tab" aria-controls="milestones" aria-selected="false">Milestone</a>
				</li>
<!-- 				<li class="nav-item" role="presentation">
					<a class="nav-link" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a>
				</li>
 -->				<li class="nav-item" role="presentation">
					<a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
				</li>
<!-- 				<li class="nav-item" role="presentation">
					<a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="false">Transaction</a>
				</li>
 -->			</ul>

			<div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="bids" role="tabpanel" aria-labelledby="bids-tab"></div> <!-- </div> bids-tab  -->
				<div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab"></div> <!-- </div> messages-tab  -->
				<div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab">

                <div id="milestones-list"></div>

                </div> <!-- </div> milestones-tab  -->
<!-- 				<div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">...</div>
 -->                 <!-- </div> invoice-tab  -->
				<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
					<input type="file" id="input-upload" name="file">
				</div> <!-- </div> files-tab  -->

<!-- 				<div class="tab-pane fade" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">...</div>
 -->			</div>
          </div>
		</div>
	</div>
</div>


<!-- Upload Files -->
<link href="catalog/default/vendor/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="catalog/default/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="catalog/default/vendor/bootstrap-fileinput/themes/fas/theme.min.js"></script>
<script type="text/javascript">	
    $("#input-upload").fileinput({
        uploadUrl: "tool/upload?cid=<?php echo $customer_id; ?>&pid=<?php echo $project_id; ?>",
        enableResumableUpload: false,
        uploadExtraData: {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>', 
        },
        maxFileCount: 3,
        allowedFileExtensions: ['zip','txt','png','jpe','jpeg','jpg','gif','bmp','ico','tiff','tif','svg','svgz','rar','mp3','mov','pdf','psd','ai','doc'],    // allow only images
        showCancel: true,
        initialPreviewAsData: true,
        overwriteInitial: false,
        showUpload: false,
        showRemove: false,
        initialPreview: <?php echo $initial_preview_data; ?>,          // if you have previously uploaded preview files
        initialPreviewConfig: <?php echo $initial_preview_config_data; ?>,    // if you have previously uploaded preview files
        theme: 'fas',
        deleteUrl: "tool/upload/delete?cid=<?php echo $customer_id; ?>&pid=<?php echo $project_id; ?>",
        fileActionSettings: {
            showZoom: false,
        },
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: { 
                // configure your icon file extensions
                'doc': '<i class="fas fa-file-word text-primary"></i>',
                'xls': '<i class="fas fa-file-excel text-success"></i>',
                'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                'zip': '<i class="fas fa-file-archive text-muted"></i>',
                'htm': '<i class="fas fa-file-code text-info"></i>',
                'txt': '<i class="fas fa-file-alt text-info"></i>',
                'mov': '<i class="fas fa-file-video text-warning"></i>',
                'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                // note for these file types below no extension determination logic
                // has been configured (the keys itself will be used as extensions)
                'jpg': '<i class="fas fa-file-image text-danger"></i>',
                'gif': '<i class="fas fa-file-image text-muted"></i>',
                'png': '<i class="fas fa-file-image text-primary"></i>'
            },
            previewFileExtSettings: { // configure the logic for determining icon file extensions
                'doc': function (ext) {
                    return ext.match(/(doc|docx)$/i);
                },
                'xls': function (ext) {
                    return ext.match(/(xls|xlsx)$/i);
                },
                'ppt': function (ext) {
                    return ext.match(/(ppt|pptx)$/i);
                },
                'zip': function (ext) {
                    return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                },
                'txt': function (ext) {
                    return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                },
                'mov': function (ext) {
                    return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                },
                'mp3': function (ext) {
                    return ext.match(/(mp3|wav)$/i);
                }
            }
    }).on('fileuploaded', function(event, previewId, index, fileId) {
        console.log('File Uploaded', 'ID: ' + fileId + ', Thumb ID: ' + previewId);
        console.log('Modified initial preview is ', $("#input-upload").data('fileinput').initialPreview);
    }).on('fileuploaderror', function(event, data, msg) {
        console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
    }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
        console.log('File Batch Uploaded', preview, config, tags, extraData);
    });

</script>

<!-- // load the bidders List Table-->
<script type="text/javascript">
$('#project-info a[href="#bids"]').on('click', function (e) {
 $.ajax({
    url: 'freelancer/project/bids?pid=<?php echo $pid; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('#bids').html('<p id="loader-div" class="text-center"><i class="fas fa-spinner fa-spin fa-lg"></i> Retrieving Data...</p>');
    },
    complete: function() {
        $('#loader-div').remove();
    },
    success: function(html) {
        $('#bids').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
}); 


// Messages
$('#project-info a[href="#messages"]').on('click', function (e) {
 $.ajax({
    url: 'freelancer/project/getProjectMessages?pid=<?php echo $pid; ?>&customer_id=<?php echo $employer_id; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('#messages').html('<p id="loader-div" class="text-center"><i class="fas fa-spinner fa-spin fa-lg"></i> Retrieving Data...</p>');
    },
    complete: function() {
        $('#loader-div').remove();
    },
    success: function(html) {
        $('#messages').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
}); 
$('#project-info li:first-child a').trigger('click') // Select first tab

</script>
<!-- accept Offer -->
<script type="text/javascript">
// load the bidders List Table
$(document).on('click',"#award-freelancer-button", function() {
    var $node = $(this);
    var freelancer_id = $($node).attr('data-freelancer-id');
    var bid_id = $($node).attr('data-bid-id');
    var project_id = <?php echo $pid; ?>;

    modal = '<div class="modal fade" id="award-freelancer-modal" tabindex="-1" aria-labelledby="" aria-hidden="true">';
    modal += '<div class="modal-dialog modal-sm">';
    modal += '<div class="modal-content">';
    modal += '<div class="modal-header">';
    modal += '<h5 class="modal-title" id="exampleModalLabel">Award Freelancer</h5>';
    modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    modal += '<span aria-hidden="true">&times;</span>';
    modal += '</button>';
    modal += '</div>';
    modal += '<div class="modal-footer">';
    modal += '<div class="w-100">';
    modal += '<button type="button" class="button" id="modal-button-select">Award</button>';
    modal += '<button type="button" data-dismiss="modal" class="button dark float-right">Cancel</button>';
    modal += '</div></div>';
    modal += '</div>';
    modal += '</div>';
    modal += '</div>';

    $('body').append(modal);

    $('#award-freelancer-modal').modal('show');

    $('#award-freelancer-modal #modal-button-select').on('click', function (e) {
         $.ajax({
            url: 'freelancer/project/awardWinner?pid=<?php echo $pid; ?>',
            dataType: 'json',
            method: 'post',
            data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', freelancer_id: freelancer_id, bid_id: bid_id, project_id : project_id},
            success: function(json) {
               if (json['success']) {
                    // dispose the modal first
                    $('#award-freelancer-modal').modal('hide');
                    $.notify({
                        icon: 'fas fa-check-circle',
                        title: 'Success',
                        message: json['success']
                    },{
                        animate: {
                            enter: 'animate__animated animate__lightSpeedInRight',
                            exit: 'animate__animated animate__lightSpeedOutRight'
                        },
                        type: 'success'
                    });
                }  
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
         });
        });
}); 

// <!-- Send Message -->
$(document).on('click',"#send-message-button", function() {
    var freelancer_id = $(this).attr('data-freelancer-id');
        modal = '<div class="modal fade" id="send-message-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        modal += '<div class="modal-dialog">';
        modal += '<div class="modal-content">';
        modal += '<div class="modal-header">';
        modal += '<h5 class="modal-title" id="exampleModalLabel">Send a Message</h5>';
        modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modal += '<span aria-hidden="true">&times;</span>';
        modal += '</button>';
        modal += '</div>';
        modal += '<div class="modal-body">';
        modal += '<form id="send-message-modal-form">';
        modal += '<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />';
        modal += '<input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>" />';
        modal += '<input type="hidden" name="project_id" value="<?php echo $pid; ?>" />';
        modal += '<input type="hidden" name="freelancer_id" value="'+ freelancer_id +'" />';
        modal += '<div class="form-group">';
        modal += '<label for="input-message">Message</label>';
        modal += '<textarea type="text" class="form-control" name="message" cols="4" rows="3"></textarea>';
        modal += '</div>';
        modal += '</form>';
        modal += '</div>';
        modal += '<div class="modal-footer">';
        modal += '<button type="button" id="modal-button-save" class="button">Send</button>';
        modal += '</div>';
        modal += '</div>';
        modal += '</div>';
        modal += '</div>';

        $('body').append(modal);
        $('#send-message-modal').modal('show');
        

        $('#send-message-modal #modal-button-save').on('click', function (e) {
            e.preventDefault();
             $.ajax({
                url: 'freelancer/project/sendMessage?pid=<?php echo $pid; ?>',
                dataType: 'json',
                method: 'post',
                data: $('#send-message-modal-form').serialize(),
                beforeSend: function() {
                    $('.text-danger').remove();
                },
                success: function(json) {
                    if (json['error']) {
                        $('textarea[name=\'message\']').after('<p class="text-danger">' + json['error'] + '</p>')
                    }

                    if (json['success']) {
                        // dispose the modal first
                        $('#send-message-modal').modal('hide');
                        $.notify({
                            icon: 'fas fa-check-circle',
                            title: 'Success',
                            message: json['success']
                        },{
                         animate: {
                            enter: 'animate__animated animate__lightSpeedInRight',
                            exit: 'animate__animated animate__lightSpeedOutRight'
                        },
                        type: 'success'
                        });
                    }                        
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });    
        });  
}); 
</script>
<!-- MileStones -->
<script type="text/javascript">
$('#milestones-tab').on('shown.bs.tab', function () {

    $('#milestones-list').html('<p id="loader-div" class="text-center"><i class="fas fa-spinner fa-spin fa-lg"></i> Retrieving Data...</p>'); 

    $( "#milestones-list" ).load('freelancer/project/getProjectMilestones?project_id=<?php echo $project_id; ?>', function() {
         $('#loader-div').remove();
    });

    // Create MileStone
    $(document).on('click', '#milestone-button-add', function() {
        modal = '<div class="modal fade" id="milestone-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        modal += '<div class="modal-dialog">';
        modal += '<div class="modal-content">';
        modal += '<div class="modal-header">';
        modal += '<h5 class="modal-title" id="exampleModalLabel">Milestone</h5>';
        modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modal += '<span aria-hidden="true">&times;</span>';
        modal += '</button>';
        modal += '</div>';
        modal += '<div class="modal-body">';
        modal += '<form id="milestone-modal-form">';
        modal += '<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />';
        modal += '<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />';
        modal += '<div class="form-group">';
        modal += '<label for="input-message">Amount</label>';
        modal += '<input type="number" min="1" class="form-control" name="amount">';
        modal += '</div>';
        modal += '<div class="form-group">';
        modal += '<label for="input-message">Description</label>';
        modal += '<textarea type="text" cols="3" row="4" class="form-control" name="description"></textarea>';
        modal += '</div>';
        modal += '<div class="form-group">';
        modal += '<label for="input-message">Completed in</label>';
        modal += '<input type="number" min="1" max="30" class="form-control" name="deadline">';
        modal += '</div>';
        modal += '</form>';
        modal += '</div>';
        modal += '<div class="modal-footer">';
        modal += '<button type="button" id="milestone-button-save" class="button">Add</button>';
        modal += '</div>';
        modal += '</div>';
        modal += '</div>';
        modal += '</div>';
        $('body').append(modal);

        $('#milestone-modal').modal('show');

        $('#milestone-modal #milestone-button-save').on('click', function (e) {
            e.preventDefault();
             $.ajax({
                url: 'freelancer/project/addMilestone?pid=<?php echo $pid; ?>',
                dataType: 'json',
                method: 'post',
                data: $('#milestone-modal-form').serialize(),
                beforeSend: function() {
                    $('.text-danger').remove();
                },
                success: function(json) {
                    if (json['error']) {
                        $('textarea[name=\'message\']').after('<p class="text-danger">' + json['error'] + '</p>')
                    }

                    if (json['success']) {
                        // dispose the modal first
                        $('#milestone-modal').modal('hide');
                        $.notify({
                            icon: 'fas fa-check-circle',
                            title: 'Success',
                            message: json['success']
                        },{
                         animate: {
                            enter: 'animate__animated animate__lightSpeedInRight',
                            exit: 'animate__animated animate__lightSpeedOutRight'
                        },
                        type: 'success'
                        });
                    }                        
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });    
        });  
    });
    
});
</script>
<?php echo $footer; ?>