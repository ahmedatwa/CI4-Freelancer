<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <!-- Page Header Begin -->
  <div class="page-header">
    <div class="container-fluid">
      <div class="float-right">
        <button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_send; ?>"><i class="fas fa-paper-plane"></i></button>
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
    <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_list; ?></div>
    <div class="card-body">
      <form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>" id="form-location" accept-charset="utf-8"> 
       <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />   
        <div class="form-group row">
          <label for="input-from" class="col-md-2 col-form-label"><?php echo $entry_from; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-from" name="from" value="<?php echo $from; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="input-to" class="col-md-2 col-form-label"><?php echo $entry_to; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-to" name="to" value="<?php echo $to; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="input-customer-group" class="col-md-2 col-form-label"><?php echo $entry_customer_group; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-entry_customer-group" name="customer_group" value="<?php echo $customer_group; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="input-customer" class="col-md-2 col-form-label"><?php echo $entry_customer; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-customer" name="customer" value="<?php echo $customer; ?>">
          </div>
        </div>
        <div class="form-group row required">
          <label for="input-subject" class="col-md-2 col-form-label"><?php echo $entry_subject; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="subject" id="input-subject" name="subject" value="<?php echo $subject; ?>">
              <?php echo form_error('subject'); ?>
          </div>
        </div>
        <div class="form-group row required">
          <label for="input-subject" class="col-md-2 col-form-label"><?php echo $entry_message; ?></label>
          <div class="col-md-10">
            <textarea class="form-control" type="message" id="input-message" data-toggle="summernote" name="message"><?php echo $message; ?></textarea>
              <?php echo form_error('message'); ?>
          </div>
        </div>
      </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<script src="assets/vendor/summernote/summernote-bs4.js"></script> 
<script src="assets/vendor/summernote/image-manager.js"></script> 
<link href="assets/vendor/summernote/summernote-bs4.css" rel="stylesheet">
<?php echo $footer; ?>