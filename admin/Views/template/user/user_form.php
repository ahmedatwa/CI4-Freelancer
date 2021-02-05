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
       <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
       <div class="form-group row">
        <label for="input-image" class="col-md-2 col-form-label"><?php echo $entry_image; ?></label>
        <div class="col-md-10">
          <a href="" id="thumb-image" data-toggle="image" class="img-fluid">
            <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" class="img-thumbnail" /></a>
            <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
          </div>
        </div>    
        <div class="form-group row">
          <label for="input-firstname" class="col-md-2 col-form-label"><?php echo $entry_firstname; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-firstname" name="firstname" value="<?php echo $firstname; ?>">
            <?php echo form_error('firstname'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="input-lastname" class="col-md-2 col-form-label"><?php echo $entry_lastname; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-lastname" name="lastname" value="<?php echo $lastname; ?>">
            <?php echo form_error('lastname'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="input-username" class="col-md-2 col-form-label"><?php echo $entry_username; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-username" name="username" value="<?php echo $username; ?>">
            <?php echo form_error('username'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="input-email" class="col-md-2 col-form-label"><?php echo $entry_email; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="text" id="input-email" name="email" value="<?php echo $email; ?>">
            <?php echo form_error('email'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="input-password" class="col-md-2 col-form-label"><?php echo $entry_password; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="password" id="input-password" name="password" value="<?php echo $password; ?>">
            <?php echo form_error('password'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="input-confirm" class="col-md-2 col-form-label"><?php echo $entry_confirm; ?></label>
          <div class="col-md-10">
            <input class="form-control" type="password" id="input-confirm" name="confirm" value="<?php echo $password; ?>">
              <?php echo form_error('confirm'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label"><?php echo $entry_user_group; ?></label>
          <div class="col-md-10">
            <select class="form-control" name="user_group_id">
              <?php foreach($user_groups as $user_group) { ?>
                <?php if ($user_group['user_group_id'] == $user_group_id) { ?> 
                  <option value="<?php echo $user_group['user_group_id']; ?>" selected><?php echo $user_group['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
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
      </form>
    </div><!-- Card Body -->
  </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<?php echo $footer; ?>