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
                  <li class="list-group-item"><strong>Bid Quote: </strong><?php echo $bid_amount; ?></li>
            </ul>
        </div>
		<div class="row">
			<div class="col-12">
			<ul class="nav nav-tabs" id="project-info" role="tablist">
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
            'csrf-token': $('meta[name="<?= csrf_token() ?>"]').attr('content'), 
            'X-Requested-With': 'XMLHttpRequest'
        },
        maxFileCount: 3,
        uploadAsync: false,
        allowedFileExtensions: <?php echo json_encode($allowedFileExtensions); ?>, 
        showCancel: true,
        initialPreviewAsData: true,
        overwriteInitial: false,
        showUpload: false,
        showRemove: false,
        initialPreview: <?php echo $initial_preview_data; ?>,          // if you have previously uploaded preview files
        initialPreviewConfig: <?php echo $initial_preview_config_data; ?>,    // if you have previously uploaded preview files
        theme: 'fas',
        deleteUrl: "tool/upload/remove?project_id=<?php echo $project_id; ?>&freelancer_id=<?php echo $customer_id; ?>",
        deleteExtraData: {
            'csrf-token': $('meta[name="<?= csrf_token() ?>"]').attr('content'), 
            'X-Requested-With': 'XMLHttpRequest'
        },
        fileActionSettings: {
            showZoom: false,
            showDrag: false,
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
    });
</script>

<!-- // load the bidders List Table-->
<script type="text/javascript">

$('#project-info #bids-tab').on('click', function (e) {
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
$('#project-info #messages-tab').on('click', function (e) {
 $.ajax({
    url: 'account/message/getProjectMessages?project_id=<?php echo $project_id; ?>&receiver_id=<?php echo $receiver_id; ?>',
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

$('#project-info li:first-child a').tab('show') // Select first tab
$('#project-info li:first-child a').trigger('click') // Select first tab
</script>
<?php echo $footer; ?>