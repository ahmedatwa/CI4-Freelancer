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
                  <li class="list-group-item"><strong>Project ID: </strong><?php echo $project_id; ?></li>
                  <li class="list-group-item"><strong>Budget: </strong><?php echo $budget; ?></li>
                  <li class="list-group-item"><strong>Type: </strong><?php echo $type; ?></li>
                  <?php if ($freelancer) { ?>
                  <li class="list-group-item"><strong>Freelancer: </strong>@<a href="<?php echo $freelancer_profile; ?>"><?php echo $freelancer; ?></a></li>
                  <li class="list-group-item"><strong>Bid Quote: </strong><?php echo $bid_amount; ?></li>
              <?php } ?>
            </ul>
        </div>
		<div class="row">
			<div class="col-12">
			<ul class="nav nav-tabs" id="project-info" role="tablist">
                 <?php if ($employer_id == $customer_id) { ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="bids-tab" data-toggle="tab" href="#bids" role="tab" aria-controls="bids" aria-selected="true">Bids <?php if ($total_bids > 0) { ?><span class="badge badge-success"><?php echo $total_bids; ?></span><?php } ?></a>
                </li>
                <?php } ?>
				<!-- <li class="nav-item" role="presentation">
					<a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
				</li> -->
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones" role="tab" aria-controls="milestones" aria-selected="false">Milestone</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
				</li>
			</ul>
			<div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade" id="bids" role="tabpanel" aria-labelledby="bids-tab">
                    <div id="bids-list"></div></div> 
				<div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div id="messages-list"></div></div> 
				<div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab">
                    <div id="milestones-list"></div></div> 
				<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
					<input type="file" id="input-upload" name="file"></div> 
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
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        maxFileCount: 3,
        allowedFileExtensions: <?php echo json_encode($allowedFileExtensions); ?>, 
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

$('#project-info #bids-tab').on('click', function (e) {
 $.ajax({
    url: 'employer/project/bids?pid=<?php echo $project_id; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('#bids-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
    },
    complete: function() {
        $('#spinner').remove();
    },
    success: function(html) {
        $('#bids-list').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
}); 


// Messages
$('#project-info #messages-tab').on('click', function (e) {
 $.ajax({
    url: 'account/message/getProjectMessages?project_id=<?php echo $project_id; ?>&employer_id=<?php echo $employer_id; ?>&freelancer_id=<?php echo $freelancer_id; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('#messages-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
    },
    complete: function() {
        $('#spinner').remove();
    },
    success: function(html) {
        $('#messages-list').html(html);
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
$('#project-info #milestones-tab').on('click', function (e) {
 $.ajax({
    url: 'freelancer/milestone?project_id=<?php echo $project_id; ?>',
    dataType: 'html',
    beforeSend: function() {
        $('.alert').remove();
        $('#milestones-list').html('<div id="spinner" class="d-flex justify-content-center"><div class="spinner-border mr-2" role="status"><span class="sr-only">Loading...</span></div>Loading...</div>');
    },
    complete: function() {
        $('#spinner').remove();
    },
    success: function(html) {
        $('#milestones-list').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
 });
}); 
</script>
<?php echo $footer; ?>