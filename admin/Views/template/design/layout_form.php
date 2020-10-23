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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-layout" accept-charset="utf-8">
          <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
          <div class="form-group required row">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php echo form_error('name'); ?>
            </div>
          </div>
          <table id="route" class="table table-bordered">
            <thead>
              <tr>
                <td class="text-left"><?php echo $entry_route; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr id="route-row">
                <td class="text-left">
                  <input type="text" name="layout_route" value="<?php echo $layout_route; ?>" placeholder="<?php echo $entry_route; ?>" class="form-control" />
                </td>
              </tr>
            </tbody>
          </table>
          <div class="table-responsive">
          <table id="module" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left" width="40%"><?php echo $entry_module; ?></td>
                <td class="text-left"><?php echo $entry_position; ?></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
              <tr id="module-row<?php echo $module_row; ?>">
                <td class="text-left"><select name="layout_module[<?php echo $module_row; ?>][code]" class="form-control">
                    <?php foreach ($extensions as $extension) { ?>
                    <?php if (!$extension['module']) { ?>
                    <?php if ($extension['code'] == $layout_module['code']) { ?>
                    <option value="<?php echo $extension['code']; ?>" selected="selected"><?php echo $extension['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                    <optgroup label="<?php echo $extension['name']; ?>">
                    <?php foreach ($extension['module'] as $module) { ?>
                    <?php if ($module['code'] == $layout_module['code']) { ?>
                    <option value="<?php echo $module['code']; ?>" selected="selected"><?php echo $module['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    </optgroup>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="text-left"><select name="layout_module[<?php echo $module_row; ?>][position]" class="form-control">
                    <?php if ($layout_module['position'] == 'content_top') { ?>
                    <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                    <?php } else { ?>
                    <option value="content_top"><?php echo $text_content_top; ?></option>
                    <?php } ?>
                    <?php if ($layout_module['position'] == 'content_bottom') { ?>
                    <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                    <?php } else { ?>
                    <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                    <?php } ?>
                    <?php if ($layout_module['position'] == 'column_left') { ?>
                    <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                    <?php } else { ?>
                    <option value="column_left"><?php echo $text_column_left; ?></option>
                    <?php } ?>
                    <?php if ($layout_module['position'] == 'column_right') { ?>
                    <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                    <?php } else { ?>
                    <option value="column_right"><?php echo $text_column_right; ?></option>
                    <?php } ?>
                  </select></td>
                <td class="text-right"><input type="text" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                <td class="text-left"><button type="button" id="button-remove" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $module_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_module_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
        </div>
        </form>
 </div><!-- Card Body -->
</div><!-- Card -->
</div><!-- container-fluid -->
</div>
<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
<script src="assets/vendor/DataTables/datatables.min.js"></script>
<script type="text/javascript">

function addRoute(route_row) {
  html  = '<tr id="route-row' + route_row + '">';
  html += '  <td class="text-left"><input type="text" name="layout_route[' + route_row + '][route]" value="" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#route-row' + route_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#route tbody').append(html);
  
  route_row++;
}

var module_row = <?php echo $module_row; ?>;
var t = $('#module').DataTable();

function addModule() {
  t.row.add([
	'<select name="layout_module[' + module_row + '][code]" class="form-control"><?php foreach ($extensions as $extension) { ?><?php if (!$extension['module']) { ?><option value="<?php echo $extension['code']; ?>"><?php echo addslashes($extension['name']); ?></option><?php } else { ?><optgroup label="<?php echo addslashes($extension['name']); ?>"><?php foreach ($extension['module'] as $module) { ?><option value="<?php echo $module['code']; ?>"><?php echo addslashes($module['name']); ?></option><?php } ?></optgroup><?php } ?><?php } ?></select>',
	'<select name="layout_module[' + module_row + '][position]" class="form-control"><option value="content_top"><?php echo $text_content_top; ?></option><option value="content_bottom"><?php echo $text_content_bottom; ?></option><option value="column_left"><?php echo $text_column_left; ?></option><option value="column_right"><?php echo $text_column_right; ?></option></select>',
	'<input type="text" name="layout_module[' + module_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />',
  '<button type="button" id="button-remove" data-toggle="tooltip" title="<?php echo $button_remove; ?>"class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>'
	]).node().id = 'module-row' + module_row;
    t.draw( false );
	
	module_row++;

}

 t.on('click', '#button-remove', function () {
      t.row( $(this).parents('tr')).remove().draw();
    });

</script>
<?php echo $footer; ?>