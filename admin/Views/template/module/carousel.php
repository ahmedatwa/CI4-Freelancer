<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <!-- Page Header Begin -->
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-right">
        <button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="far fa-save"></i></button>
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
  <div class="container-fluid">
  <?php if($error_warning) { ?>
    <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php } ?>
</div>
<!-- Page Heaedr End -->
<div class="container-fluid">
  <div class="card">
    <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_edit; ?></div>
    <div class="card-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
          <div class="col-sm-10">
            <input class="form-control" name="name" value="<?php echo $name; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-banner"><?php echo $entry_banner; ?></label>
          <div class="col-sm-10">
            <select name="banner_id" id="input-banner" class="form-control">
              <?php foreach ($banners as $banner) { ?>
              <?php if ($banner['banner_id'] == $banner_id) { ?>
                <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
          <div class="col-sm-10">
            <input class="form-control" name="width" value="<?php echo $width; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
          <div class="col-sm-10">
            <input class="form-control" name="height" value="<?php echo $height; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-autoplay"><?php echo $entry_autoplay; ?></label>
          <div class="col-sm-10">
            <?php if ($autoplay == 1)  { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="autoplay" value="1" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="autoplay" value="0">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } else { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="autoplay" value="1">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="autoplay" value="0" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-dots"><?php echo $entry_dots; ?></label>
          <div class="col-sm-10">
            <?php if ($dots == 1)  { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dots" value="1" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dots" value="0">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } else { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dots" value="1">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dots" value="0" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } ?>
          </div>       
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-infinite"><?php echo $entry_infinite; ?></label>
          <div class="col-sm-10">
            <?php if ($infinite == 1)  { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="infinite" value="1" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="infinite" value="0">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } else { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="infinite" value="1">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="infinite" value="0" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } ?>
          </div>      
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-infinite"><?php echo $entry_arrows; ?></label>
          <div class="col-sm-10">
            <?php if ($arrows == 1)  { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="arrows" value="1" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="arrows" value="0">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } else { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="arrows" value="1">
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_yes; ?></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="arrows" value="0" checked>
                <label class="form-check-label" for="inlineRadio1"><?php echo $text_no; ?></label>
              </div>
            <?php } ?>
          </div>      
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
          <div class="col-sm-10">
            <select name="status" id="input-status" class="form-control">
              <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<?php echo $footer; ?>