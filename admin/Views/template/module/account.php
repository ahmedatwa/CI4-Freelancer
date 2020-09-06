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
          <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
          <div class="col-sm-10">
            <select name="module_account_status" id="input-status" class="form-control">
              <?php if ($module_account_status) { ?>
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