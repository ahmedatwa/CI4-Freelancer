<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded">
	<div class="dashboard-content-inner" >
		<div class="dashboard-headline">
			<h3><?php echo $name; ?></h3>
		</div>
        <div class="col-12 mb-4">
        <h4 class="mb-2">Project Details: </h4>
            <ul class="list-group list-group-flush mb-4 col-6">
                  <li class="list-group-item list-group-item-light"><strong>Project ID: </strong><?php echo $project_id; ?></li>
                  <li class="list-group-item list-group-item-light"><strong>Budget: </strong><?php echo $budget; ?></li>
                  <li class="list-group-item list-group-item-light"><strong>Type: </strong><?php echo $type; ?></li>
                  <li class="list-group-item list-group-item-light"><strong>Freelancer: </strong>@<a href="<?php echo $freelancer_profile; ?>"><?php echo $freelancer; ?></a></li>
                  <li class="list-group-item list-group-item-light"><strong>Bid Quote: </strong><?php echo $bid_amount; ?></li>
            </ul>
        </div>
		<div class="row">
			<div class="col-12">
			<ul class="nav nav-tabs" id="project-info" role="tablist">
                 <?php if ($employer_id == $customer_id) { ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="bids-tab" data-toggle="tab" href="#bids" role="tab" aria-controls="bids" aria-selected="true">Bids <span class="badge badge-success"><?php echo $total_bids; ?></span></a>
                </li>
                <?php } ?>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones" role="tab" aria-controls="milestones" aria-selected="false">Milestone</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
				</li>
			</ul>

			<div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade" id="bids" role="tabpanel" aria-labelledby="bids-tab"></div> <!-- </div> bids-tab  -->
				<div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab"></div> <!-- </div> messages-tab  -->
				<div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab">
                <div id="milestones-list"></div>
                </div> <!-- </div> milestones-tab  -->
				<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
					<input type="file" id="input-upload" name="file">
				</div> <!-- </div> files-tab  -->
			</div>
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
    url: 'freelancer/project/bids?pid=<?php echo $project_id; ?>',
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
    url: 'freelancer/project/getProjectMessages?pid=<?php echo $project_id; ?>&customer_id=<?php echo $employer_id; ?>',
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

$('#project-info li:first-child a').tab('show') // Select first tab

$('#project-info li:first-child a').trigger('click') // Select first tab

</script>
<!-- accept Offer -->
<script type="text/javascript">
 // Award the Freelancer 
function awardFreelancer(freelancer_id, bid_id) {
   bootbox.confirm({
    message: "Are you sure?",
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
            url: 'freelancer/project/awardWinner?pid=<?php echo $project_id; ?>',
            dataType: 'json',
            method: 'post',
            data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'freelancer_id': freelancer_id, 'bid_id': bid_id, 'project_id' :  <?php echo $project_id; ?>},
            success: function(json) {
               if (json['success']) {
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
                    // Reload the Bids Tab
                    $('#bids').load('freelancer/project/bids?pid=<?php echo $project_id; ?>'); 
                }  
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
         });
      } // if end
    } // callback end
   });  // bootbox end
}

// <!-- Send Private  Message -->
function sendMessage(sender_id, receiver_id) {
   bootbox.prompt({
    title: 'Send A Message',
    message: "",
    className: 'animate__animated animate__fadeInDown',
    inputType: 'textarea',
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
            url: 'freelancer/project/sendMessage?pid=<?php echo $project_id; ?>',
            dataType: 'json',
            method: 'post',
            data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'sender_id': sender_id, 'receiver_id': receiver_id, 'message': $('.bootbox-input-textarea').val(), 'project_id': <?php echo $project_id; ?>},
            beforeSend: function() {
                $('.text-danger, .alert').remove();
            },
            complete: function() {

            },
            success: function(json) {
                if (json['error']) {
                    $('textarea[name=\'message\']').after('<p class="text-danger">' + json['error'] + '</p>')
                }

                if (json['success']) {
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
                  $('#messages').load('freelancer/project/getProjectMessages?pid=<?php echo $project_id; ?>&customer_id=<?php echo $employer_id; ?>');
                  $('#send-message-modal-form').trigger('reset');
                }                        
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
      } // if end
    } // callback end
   });  // bootbox end
}
</script>
<!-- MileStones -->
<script type="text/javascript">
$('#project-info a[href="#milestones"]').on('click', function (e) {
 $.ajax({
    url: 'freelancer/project/getProjectMilestones?project_id=<?php echo $project_id; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('.alert').remove();
        $('#milestones-list').html('<p id="loader-div" class="text-center"><i class="fas fa-spinner fa-spin fa-lg"></i> Retrieving Data...</p>');
    },
    complete: function() {
        $('#loader-div').remove();
    },
    success: function(html) {
        $('#milestones-list').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
}); 

 function addMilestone() {
   bootbox.confirm({
    title: 'Create Milestone',
    message: '<form id="milestone-modal-form"><input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /><input type="hidden" name="project_id" value="<?php echo $project_id; ?>" /><input type="hidden" name="created_by" value="<?php echo $customer_id; ?>" /><input type="hidden" name="created_for" value="<?php echo $created_for; ?>" /><div class="form-group"><label for="input-message">Amount</label><input type="number" min="1" class="form-control" name="amount"></div><div class="form-group"><label for="input-message">Description</label><textarea type="text" cols="3" row="4" class="form-control" name="description"></textarea></div><div class="form-group"><label for="input-message">Completed in</label><input type="number" min="1" max="30" class="form-control" name="deadline"></div></form>',
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
                url: 'freelancer/project/addMilestone?pid=<?php echo $project_id; ?>',
                dataType: 'json',
                method: 'post',
                data: $('#milestone-modal-form').serialize(),
                beforeSend: function() {
                    $('.text-danger, .alert').remove();
                },
                success: function(json) {
                    if (json['error']) {
                        $('textarea[name=\'message\']').after('<p class="text-danger">' + json['error'] + '</p>')
                    }

                    if (json['success']) {
                        $('#milestones-list').load('freelancer/project/getProjectMilestones?project_id=<?php echo $project_id; ?>');   
                        $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }                        
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
          });
      } // if end
    } // callback end
   });  // bootbox end
}

// Cancel MileStone
function cancelMilestone(milestone_id) {
    bootbox.confirm({
    message: 'Are You Sure',
    className: 'animate__animated animate__fadeInDown',
    size:'small',
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
        url: 'freelancer/project/cancelMilestone',
        dataType: 'json',
        method: 'post',
        data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'milestone_id': milestone_id},
        beforeSend: function() {
            $('.text-danger, .alert').remove();
        },
        success: function(json) {
            if (json['success']) {
            
             $('#milestones-list').load('freelancer/project/getProjectMilestones?project_id=<?php echo $project_id; ?>');   
             $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }                        
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
  });
  } // if end
} // callback end
});  // bootbox end
}

// Approve MileStone
function approveMilestone(milestone_id) {
    bootbox.confirm({
    message: 'Are You Sure',
    className: 'animate__animated animate__fadeInDown',
    size:'small',
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
        url: 'freelancer/project/approveMilestone',
        dataType: 'json',
        method: 'post',
        data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'milestone_id': milestone_id},
        beforeSend: function() {
            $('.text-danger, .alert').remove();
        },
        success: function(json) {
            if (json['success']) {
            
             $('#milestones-list').load('freelancer/project/getProjectMilestones?project_id=<?php echo $project_id; ?>');   
             $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }                        
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
  });
  } // if end
} // callback end
});  // bootbox end
}

// Pay MileStone
function payMilestone(milestone_id, amount, employer_id, freelancer_id) {
    bootbox.confirm({
    title: 'Are You Sure',
    message: 'Are You Sure',
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
    onShown: function(e) {
        $(this).find('.modal-body').text(amount + '.00 EGP will be deducted from your Balance');
    },
    callback: function (result) {
    if (result) {
    $.ajax({
        url: 'freelancer/project/payMilestone',
        dataType: 'json',
        method: 'post',
        data: {'<?= csrf_token() ?>': '<?= csrf_hash() ?>', 'milestone_id': milestone_id, 'amount': amount, 'employer_id': employer_id, 'freelancer_id': freelancer_id},
        beforeSend: function() {
            $('.text-danger, .alert').remove();
        },
        success: function(json) {
            if (json['success']) {
            
             $('#milestones-list').load('freelancer/project/getProjectMilestones?project_id=<?php echo $project_id; ?>');   
             $('#milestones-list').before('<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }                        
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
  });
  } // if end
} // callback end
});  // bootbox end
}
</script>
<script type="text/javascript">
var url = document.URL;
var hash = url.substring(url.indexOf('#'));

$('#project-info').find("li a").each(function(key, val) {
    if (hash == $(val).attr('href')) {
        $(val).click();
    }
    
    $(val).click(function(ky, vl) {
        location.hash = $(this).attr('href');
    });
});

</script>
<?php echo $footer; ?>