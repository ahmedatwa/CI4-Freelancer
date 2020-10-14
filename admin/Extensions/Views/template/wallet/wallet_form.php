<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
        <div class="float-right">
            <button type="submit" form="form-wallet" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="far fa-save"></i></button>
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
    <div class="card">
        <div class="card-header"><i class="far fa-edit"></i> <?php echo $text_form; ?></div>
        <div class="card-body">
            <form class="form-horizontal" enctype="multipart/form-data" id="form-wallet" action="<?php echo $action; ?>" method="post">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="form-group row">
                  <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                  <div class="col-sm-10">
                    <select name="wallet_extension_status" id="input-status" class="form-control">
                      <?php if ($wallet_extension_status) { ?>
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
