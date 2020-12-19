<?php if ($certificates) { ?>
<div class="table-responsive">
    <table class="table table-bordered" id="certificats-table">
        <thead>
            <tr>
                <th><?php echo $column_name; ?></th>
                <th><?php echo $column_year; ?></th>
                <th width="10%"><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certificates as $certificate) { ?>
            <tr>
                <td><?php echo $certificate['name']; ?></td>
                <td><?php echo $certificate['year']; ?></td>
                <td><button type="button" value="<?php echo $certificate['certificate_id']; ?>"
                    id="button-delete-certificate<?php echo $certificate['certificate_id']; ?>"
                    data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip"
                    title="<?php echo $button_delete; ?>" class="btn btn--icon btn-sm btn-danger"><i class="icon-feather-trash-2"></i>
                </button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
<div class="mt-4 float-left">
 <?php echo $pagination;?>
</div>
