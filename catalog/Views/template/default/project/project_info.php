<?php echo $header; ?><?php echo $dashboard_menu; ?>
<!-- Dashboard Content -->
<div class="dashboard-content-container container margin-top-40 shadow-sm p-3 mb-5 bg-white rounded">
	<div class="dashboard-content-inner" >
		<div class="dashboard-headline">
			<h3><?php echo $name; ?></h3>
		</div>
		<div class="row">
			<div class="col-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="true">Messages</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones" role="tab" aria-controls="profile" aria-selected="false">Milestone</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="false">Transaction</a>
				</li>
			</ul>

			<div class="tab-content mt-4" id="myTabContent">
				<div class="tab-pane fade show active" id="messages" role="tabpanel" aria-labelledby="messages-tab">test</div>
				<div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab">...</div>
				<div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">...</div>
				<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
					
					<input type="file" id="input-upload" name="file">

				</div>

				<div class="tab-pane fade" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">...</div>


			</div>


</div>
		</div>
	</div>
</div>

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

<?php echo $footer; ?>