<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <!-- Page Header Begin -->
  <div class="page-header">
    <div class="container-fluid">
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
    <div class="card">
      <div class="card-header"><i class="fas fa-list"></i> <?php echo $text_list; ?></div>
      <div class="card-body">
          <?php if ($error_warning) { ?>
            <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php }  ?>
        <?php if ($success) { ?>
          <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php }  ?>
      <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_layout; ?></div>
      <table class="table table-bordered table-hover" id="table-location">
        <thead>
          <tr>
            <td class="text-left" width="70%"><?php echo $column_name; ?></td>
            <td class="text-left"><?php echo $column_status; ?></td>
            <td class="text-right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($extensions) { ?>
            <?php foreach ($extensions as $extension) { ?>
              <tr>
                <td><b><?php echo $extension['name']; ?></b></td>
                <td><?php echo $extension['status']; ?></td>
                <td class="text-right">
                  <?php if ($extension['installed']) { ?>
                    <?php if ($extension['module']) { ?>
                      <a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i></a>
                    <?php } else { ?> 
                     <a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a> 
                   <?php } ?>
                 <?php } else { ?>
                  <button type="button" class="btn btn-primary btn-sm" disabled="disabled"><i class="fas fa-edit"></i></button>
                <?php } ?>
                <?php if (! $extension['installed']) { ?>
                  <a href="<?php echo $extension['install']; ?>" data-toggle="tooltip" title="<?php echo $button_install; ?>" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i></a> 
                <?php } else { ?>
                  <a href="<?php echo $extension['uninstall']; ?>" data-toggle="tooltip" title="<?php echo $button_uninstall; ?>" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></a><?php } ?>
                </td>
              </tr>
              <?php foreach($extension['module'] as $module) { ?>
                <tr>
                  <td class="text-left"><span class="ml-3"></span><i class="fa fa-folder-open text-info"></i><span class="ml-1"></span><?php echo $module['name']; ?></td>
                  <td class="text-left"><?php echo $module['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $module['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a> <a href="<?php echo $module['delete']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-warning btn-sm"><i class="far fa-trash-alt"></i></a></td>
                </tr>
              <?php } ?>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php echo $footer; ?>