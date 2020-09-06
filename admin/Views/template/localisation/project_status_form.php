<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
        <div class="float-right">
            <button type ="submit" form="form-location" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_save; ?>"><i class="far fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="<?php echo $button_cancel; ?>"><i class="fas fa-reply"></i></a></div>
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
        <div class="form-group row required">
          <label class="col-sm-2 control-label" for="input-project-status"><?php echo $entry_name;?></label>
          <div class="col-sm-10">
          <?php foreach($languages as $language) { ?>
          <div class="input-group mb-2">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <img src="assets/images/flags/<?php echo $language['code'];?>.png" title="<?php echo $language['name'];?>" /></span>
          </div>
            <input type="text" name="project_status[<?php echo $language['language_id'];?>][name]" value="<?php echo $project_status[$language['language_id']]['name'] ?? "";?>" placeholder="<?php echo $entry_name;?>" class="form-control" />
                    <?php echo form_error("project_status.".$language['language_id'].".name"); ?>
          </div>
          <?php } ?>
          </div>
          </div>
        </form>
    </div><!-- Card Body -->
</div><!-- Card -->
</div><!-- container-fluid -->
</div>
<?php echo $footer; ?>
