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
       <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
       <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo $tab_general; ?></a></li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false"><?php echo $tab_reviews; ?></a></li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="wallet" aria-selected="false"><?php echo $tab_wallet; ?></a></li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-3" id="general" role="tabpanel" aria-labelledby="general-tab">
             <fieldset>
               <legend><?php echo $text_account; ?></legend>
               <div class="form-group row">
                <label for="input-customer-group" class="col-md-2 col-form-label"><?php echo $entry_customer_group; ?></label>
                <div class="col-md-10">
                  <select class="form-control" name="customer_group_id">
                    <option><?php echo $text_select; ?></option>
                    <?php foreach ($customer_groups as $group) { ?> 
                      <?php if ($group['customer_group_id'] == $customer_group_id) { ?>  
                        <option value="<?php echo $group['customer_group_id']; ?>" selected><?php echo $group['name']; ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $group['customer_group_id']; ?>"><?php echo $group['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row required">
                <label for="input-firstname" class="col-md-2 col-form-label"><?php echo $entry_firstname; ?></label>
                <div class="col-md-10">
                  <input class="form-control" type="text" id="input-firstname" name="firstname" value="<?php echo $firstname; ?>">
                  <?php echo form_error('firstname'); ?>
                </div>
              </div>
              <div class="form-group row required">
                <label for="input-lastname" class="col-md-2 col-form-label"><?php echo $entry_lastname; ?></label>
                <div class="col-md-10">
                  <input class="form-control" type="text" id="input-lastname" name="lastname" value="<?php echo $lastname; ?>">
                  <?php echo form_error('lastname'); ?>
                </div>
              </div>
              <div class="form-group row required">
                <label for="input-email" class="col-md-2 col-form-label"><?php echo $entry_email; ?></label>
                <div class="col-md-10">
                  <input class="form-control" type="text" id="input-email" name="email" value="<?php echo $email; ?>">
                  <?php echo form_error('email'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="input-telephone" class="col-md-2 col-form-label"><?php echo $entry_telephone; ?></label>
                <div class="col-md-10">
                  <input class="form-control" type="text" id="input-telephone" name="telephone" value="<?php echo $telephone; ?>">
                </div>
              </div>
            </fieldset>
            <fieldset>
              <legend><?php echo $text_password; ?></legend>
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
            </fieldset>
            <fieldset>
              <legend><?php echo $text_other; ?></legend>
              <div class="form-group row">
                <label class="col-md-2 col-form-label"><?php echo $entry_newsletter; ?></label>
                <div class="col-md-10">
                  <select class="form-control" name="newsletter">
                    <?php if ($newsletter) { ?> 
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
            </fieldset>
          </div>
          <div class="tab-pane fade mt-3" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
           <div id="review-content"></div>
         </div>
          <div class="tab-pane fade mt-3" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
           <div id="wallet-content"></div>
         </div>
       </div><!-- tab Content -->
     </form>
   </div><!-- Card Body -->
 </div><!-- Card -->
</div><!-- container-fluid -->
</div>
<script type="text/javascript">
  $('#review-content').load("index.php/customer/customer/review?user_token=<?php echo $user_token;?>");
  $('#wallet-content').load("index.php/customer/customer/wallet?user_token=<?php echo $user_token;?>&customer_id=<?php echo $customer_id; ?>");
</script>
<?php echo $footer; ?>