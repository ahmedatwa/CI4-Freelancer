<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <!-- Page Header Begin -->
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-right">
        <button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_save; ?>"><i class="far fa-save"></i></button>
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
  <?php if ($error_warning){ ?>
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
       <div class="form-group row">
        <label for="input-name" class="col-md-2 col-form-label"><?php echo $entry_name; ?></label>
        <div class="col-md-10">
          <input class="form-control" type="text" id="input-name" name="name" value="<?php echo $name; ?>">
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
      <ul class="nav nav-tabs" id="language" role="tablist">
        <?php foreach ($languages as $language) { ?>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="<?php echo $language['language_id']; ?>-tab" data-toggle="tab" href="#tab-<?php echo $language['language_id']; ?>" role="tab" aria-controls="<?php echo $language['language_id']; ?>" aria-selected="true"><?php echo $language['name']; ?></a>
          </li>
        <?php } ?>
      </ul>
      <div class="tab-content">
        <?php $image_row = 0; ?>
        <?php foreach ($languages as $language) { ?>
          <div class="tab-pane fade mt-3" id="tab-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="<?php echo $language['language_id']; ?>-tab">
            <table id="table-<?php echo $language['language_id']; ?>" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th><?php echo $column_title; ?></th>
                  <th><?php echo $column_link; ?></th>
                  <th><?php echo $column_image; ?></th>
                  <th><?php echo $column_sort_order; ?></th>
                  <th><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($banner_images) { ?>
                  <?php foreach ($banner_images[$language['language_id']] as $banner_image) { ?>
                   <tr id="image-row<?php echo $image_row; ?>">
                    <td><input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][title]" value="<?php echo $banner_image['title'];?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
                      <?php echo form_error("banner_image.".$language['language_id'].".".$banner_image['banner_image_id'].".title"); ?></td>
                      <td><input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][link]" value="<?php echo $banner_image['link']; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>
                      <td><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image"><img src="<?php echo $banner_image['thumb']; ?>" alt="" title="" class="img-thumbnail" data-placeholder="<?php echo $placeholder; ?>" />
                       </a>
                        <input type="hidden" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image'] ;?>" id="input-image<?php echo $image_row; ?>" /></td>
                        <td width="12%"><input type="text" name="banner_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][sort_order]" value="<?php echo $banner_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                        <td width="4%"><button type="button" id="button-remove" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>           
                      </tr>
                      <?php $image_row++; ?> 
                    <?php } ?>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="4"></th>
                    <th class="text-center"><button type="button" onclick="addImage('<?php echo $language['language_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div> <!--- Tab Pane --->
          <?php } ?>
        </div>
      </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript">
<?php foreach ($languages as $language) { ?>
$('#table-<?php echo $language['language_id']; ?>').DataTable({
    "order": [[ 3, "asc" ]],
    "lengthMenu": [5, 10, 15, 20],
});
<?php } ?>

var image_row = <?php echo $image_row; ?>

function addImage(language_id) {
  var t = $('#table-' + language_id).DataTable();
    t.row.add([
      '<input type="text" name="banner_image[' + language_id + '][' + image_row + '][title]" value="" placeholder="<?php echo $entry_title; ?>" class="form-control" />', 
      '<input type="text" name="banner_image[' + language_id + '][' + image_row + '][link]" value="" placeholder="<?php $entry_link; ?>" class="form-control" />', 
      '<a href="" id="thumb-image' + image_row + '" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>"  class="img-thumbnail" /></a><input type="hidden" name="banner_image[' + language_id + '][' + image_row + '][image]" value="" id="input-image' + image_row + '" />',
      '<input type="text" name="banner_image[' + language_id + '][' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />',
      '<button type="button" id="button-remove" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button>']).node().id = 'image-row' + image_row;
    t.draw( false );
    image_row ++;

    t.on( 'click', '#button-remove', function () {
      t.row( $(this).parents('tr')).remove().draw();
    });
  }
</script>
<script type="text/javascript">
  $('#language li:first a').tab('show');
</script> 
<?php echo $footer; ?>