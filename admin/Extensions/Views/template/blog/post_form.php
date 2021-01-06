<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <!-- Page Header Begin -->
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-right">
        <button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" name="<?php echo $button_save; ?>"><i class="far fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_cancel; ?>"><i class="fas fa-reply"></i></a>
      </div>
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
<!-- Page Heaedr End -->
<div class="container-fluid">
  <?php if ($error_warning) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php } ?>
  <div class="card">
    <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_form; ?></div>
    <div class="card-body">
      <form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
       <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
       <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
       <div class="form-group row required">
        <label for="input-title" class="col-md-2 col-form-label"><?php echo $entry_title; ?></label>
        <div class="col-md-10">
          <input class="form-control" type="text" id="input-title" name="title" value="<?php echo $title; ?>">
        </div>
      </div>
      <div class="form-group row required">
        <label for="input-body" class="col-md-2 col-form-label"><?php echo $entry_body; ?></label>
        <div class="col-md-10">
          <textarea class="form-control" data-toggle="summernote" type="text" id="input-body" name="body"><?php echo $body; ?></textarea>
        </div>
      </div>
      <div class="form-group row required">
        <label class="col-md-2 col-form-label"><?php echo $entry_category; ?></label>
        <div class="col-md-10">
          <select class="form-control mb-2 ml-2" name="category_id" id="input-category-id">
            <option><?php echo $text_select; ?></option>
            <?php foreach($categories as $category) { ?> 
              <?php if ($category['category_id'] == $category_id) { ?>
                <option value="<?php echo $category['category_id']; ?>" selected><?php echo $category['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-body" class="col-md-2 col-form-label"><?php echo $entry_tags; ?></label>
        <div class="col-md-10">
          <input class="form-control" type="text" id="input-tags" name="tags" value="<?php echo $tags; ?>" data-toggle="tagsinput">
        </div>
      </div>
      <div class="form-group row">
        <label for="input-image" class="col-md-2 col-form-label"><?php echo $entry_image; ?></label>
        <div class="col-md-10">
          <a href="" id="thumb-image" data-toggle="image" class="img-fluid">
            <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" class="img-fluid" /></a>
            <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label"><?php echo $entry_status; ?></label>
          <div class="col-md-10">
            <select class="form-control" name="status">
              <?php if ($status) { ?> 
                <option value="1" selected><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label" for="input-featured"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_featured; ?>">
            <?php echo $entry_featured; ?> <i class="fas fa-info-circle"></i></span></label>
          <div class="col-md-10">
            <?php if ($featured) { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="featured" id="input-featured" value="1" checked>
                <label class="form-check-label" for="input-featured"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="featured" id="input-featured" value="0">
                <label class="form-check-label" for="input-featured"><?php echo $text_no; ?></label>
              </div>
            <?php } else { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="featured" id="input-featured" value="0" checked>
                <label class="form-check-label" for="input-featured"><?php echo $text_no; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="featured" id="input-featured" value="1">
                <label class="form-check-label" for="input-featured"><?php echo $text_yes; ?></label>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label" for="input-trending"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_trending; ?>">
            <?php echo $entry_trending; ?> <i class="fas fa-info-circle"></i></span></label>
          <div class="col-md-10">
            <?php if ($trending) { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="trending" id="input-trending" value="1" checked>
                <label class="form-check-label" for="input-trending"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="trending" id="input-trending" value="0">
                <label class="form-check-label" for="input-trending"><?php echo $text_no; ?></label>
              </div>
            <?php } else { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="trending" id="input-trending" value="0" checked>
                <label class="form-check-label" for="input-trending"><?php echo $text_no; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="trending" id="input-trending" value="1">
                <label class="form-check-label" for="input-trending"><?php echo $text_yes; ?></label>
              </div>
            <?php } ?>
          </div>
        </div>
      </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<link href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
<script src="assets/vendor/summernote/summernote-bs4.js"></script> 
<script src="assets/vendor/summernote/image-manager.js"></script> 
<link href="assets/vendor/summernote/summernote-bs4.css" rel="stylesheet">
<!-- // tags input -->
<script type="text/javascript">
  $('input[data-toggle=\'tagsinput\']').tagsinput({
    maxTags: 5,
    trimValue: true,
    confirmKeys: [13, 44, 32]
  });
</script>
<!-- <script type="text/javascript">
  $('#button-category').on('click', function(){
    swal({
      title: "<?php //echo $button_add_category; ?>",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      inputPlaceholder: "<?php //echo $text_category_name; ?>"
    }, function (inputValue) {
      if (inputValue === false) return false;
      if (inputValue === "") {
        swal.showInputError("Category Name is required!");
        return false
      } else {
        $.ajax({
          url: 'index.php/blog/post/addCategory?user_token=<?php //echo $user_token; ?>',
          method:'post',
          dataType: 'json',
          data: {name: inputValue},
          success: function(json) {
            if (json['success']) {
              setTimeout(function () {
                location.reload();
              }, 800);
            }
        }, // success
        error: function (xhr, ajaxOptions, thrownError) {
          swal("Error!", thrownError , "error");
        }
      });
      }
    });
  });
</script> -->
<!-- Success SweetAlert -->
<script type="text/javascript">
  <?php if($success) { ?>
    swal({
      title: 'Success!',
      text: '<?php echo $success; ?>',
      type: "success",
    });
  <?php } ?>
</script>
<?php echo $footer; ?>
