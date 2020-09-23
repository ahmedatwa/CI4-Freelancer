  <legend><i class="fas fa-gavel"></i> <?php echo $heading_title; ?></legend>
 <?php if ($error_warning) { ?>
  <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped" id="table-bid">
      <thead>
        <tr>
          <td width="70%"><?php echo $column_name; ?></td>
          <td class="text-right"><?php echo $column_status; ?></td>
          <td class="text-right"><?php echo $column_action; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php if ($extensions) { ?>
        <?php foreach ($extensions as $extension) { ?>
        <tr>
          <td class="text-left"><?php echo $extension['name']; ?></td>
          <td class="text-right"><?php echo $extension['status']; ?></td>
          <td class="text-right">
            <?php if ($extension['installed'])  { ?>
            <a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
          <?php } else { ?>
            <button type="button" class="btn btn-primary btn-sm" disabled="disabled"><i class="fas fa-edit"></i></button>
          <?php } ?>
            <?php if (! $extension['installed']) { ?>
            <a href="<?php echo $extension['install']; ?>" data-toggle="tooltip" title="<?php echo $button_install; ?>" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i></a>
            <?php } else { ?>
            <a href="<?php echo $extension['uninstall']; ?>" data-toggle="tooltip" title="<?php echo $button_uninstall; ?>" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></a>
            <?php } ?></td>
        </tr>
            <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</fieldset>
