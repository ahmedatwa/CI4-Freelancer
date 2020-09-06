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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-location" class="form-horizontal">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
          <div class="col-sm-10">
            <select name="dashboard_online_width" id="input-width" class="form-control">
              <?php foreach ($columns as $column) { ?>
                <?php if ($column == $dashboard_online_width) { ?>
                  <option value="<?php echo $column; ?>" selected="selected"><?php echo $column; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $column; ?>"><?php echo $column; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
          <div class="col-sm-10">
            <select name="dashboard_online_status" id="input-status" class="form-control">
              <?php if ($dashboard_online_status) { ?>
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
          <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
          <div class="col-sm-10">
            <input type="text" name="dashboard_online_sort_order" value="<?php echo $dashboard_online_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
          </div>
        </div>
      </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<?php echo $footer; ?>