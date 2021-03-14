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
        <?php $setting_row = 0; ?>
                    <table class="table table-bordered" id="table-project-upgrade">
                      <thead>
                        <tr>
                          <th>Fee</th>
                          <th>Description</th>
                          <th width="2%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($module_bid_upgrade_setting as $setting) { ?>
                        <tr id="social-row<?php echo $setting_row; ?>">
                          <td width="20%"><input name="module_bid_upgrade_setting[<?php echo $setting_row; ?>][fee]" value="<?php echo $setting['fee']; ?>" class="form-control" id="input-fee" /></td>
                          <td><textarea name="module_bid_upgrade_setting[<?php echo $setting_row; ?>][description]" class="form-control" id="input-description"><?php echo $setting['description']; ?></textarea></td>
                          <td width="4%"><button type="button" onclick="$('#setting-row<?php echo $setting_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                        <?php $setting_row++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" class="text-right">
                            <button id="button-module-add" type="button" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_add; ?>" data-placement="top"><i class="fas fa-plus-circle"></i></button>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
          <div class="col-sm-10">
            <select name="module_bid_upgrade_status" id="input-status" class="form-control">
              <?php if ($module_bid_upgrade_status) { ?>
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
<script type="text/javascript">
  var setting_row = <?php echo $setting_row; ?>;
  $('#button-module-add').on('click', function(){
    html = '<tr id="social-row'+ setting_row +'">';
    html += '<td width="20%"><input type="text" class="form-control" name="module_bid_upgrade_setting['+ setting_row +'][fee]"/></td>';
    html += '<td><textarea type="text" class="form-control" name="module_bid_upgrade_setting['+ setting_row +'][description]"/></textarea></td>';
    html += '<td><button type="button" class="btn btn-danger" id="button-delete" onclick="$(\'#social-row' + setting_row  + ', .tooltip\').remove();" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></button></td>';
    html += '</tr>';
  $('#table-project-upgrade').append(html);
  setting_row++;
    });         
  $('#button-delete').remove();                                     
</script>
<?php echo $footer; ?>