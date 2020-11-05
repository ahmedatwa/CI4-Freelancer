<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <!-- Page Header Begin -->
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-right">
        <button type="submit" form="form-location" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="far fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-secondary"><i class="fas fa-reply"></i></a></div>
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
  <?php if($error_warning) { ?>
    <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php } ?>
<!-- Page Heaedr End -->
<div class="container-fluid">
  <div class="card">
    <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_edit; ?></div>
    <div class="card-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-theme" class="form-horizontal">
          <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <div class="form-group row">
              <label class="col-sm-2 control-label" for="input-directory"><?php echo $entry_directory; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_directory" id="input-directory" class="form-control">
                  <?php foreach($directories as $directory) { ?>
                  <?php if ($directory == $theme_default_directory) {?>
                  <option value="<?php echo $directory; ?>" selected="selected"><?php echo $directory; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $directory; ?>"><?php echo $directory; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
              <div class="form-group row">
              <label class="col-sm-2 control-label" for="input-color"><?php echo $entry_color; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_color" id="input-color" class="form-control">
                  <?php foreach ($colors as $color) { ?>
                   <?php if ($color == $theme_default_color) { ?>
                  <option value="<?php echo $color; ?>" selected="selected"><?php echo str_replace('.css', '', $color); ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $color; ?>"><?php echo str_replace('.css', '', $color); ?></option>
                  <?php } ?>
                   <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_status" id="input-status" class="form-control">
                  <?php if ($theme_default_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $help_projects_limit; ?>" position="top"><?php echo $entry_projects_limit; ?> <i class="fas fa-question-circle"></i></span></label>
              <div class="col-sm-10">
                <input class="form-control" name="theme_default_projects_limit" value="<?php echo $theme_default_projects_limit;?>">
              </div>
            </div>
        </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<?php echo $footer; ?>