<?php if ($languages) { ?>
    <hr />
    <div class="table-responsive col-md-12">    
        <table class="table table-bordered" id="languages-table">
            <thead>
                <tr>
                    <th><?php echo $column_name; ?></th>
                    <th width="20%"><?php echo $column_level; ?></th>
                    <th width="10%"><?php echo $column_action; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($languages as $language) { ?>
                    <tr>
                        <td><?php echo $language['name']; ?></td>
                        <td><?php echo $language['level']; ?></td>
                        <td><button type="button" value="<?php echo $language['language_id']; ?>"
                            id="button-delete-language<?php echo $language['language_id']; ?>" data-toggle="tooltip"
                            title="<?php echo $button_delete; ?>" class="btn btn--icon btn-sm btn-danger"><i class="icon-feather-trash-2"></i>
                        </button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<div class="row">
    <div class="float-left">
        <?php echo $pagination;?>
    </div>
</div>
