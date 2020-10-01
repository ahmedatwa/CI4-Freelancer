<?php if ($skills) { ?>
    <div class="table-responsive col-md-12">
        <table class="table table-bordered" id="skills-table">
            <thead>
                <tr>
                    <th><?php echo $column_name; ?></th>
                    <th><?php echo $column_level; ?></th>
                    <th width="10%"><?php echo $column_action; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($skills as $skill) { ?>
                    <tr>
                        <td><?php echo $skill['name']; ?></td>
                        <td><?php echo $skill['level']; ?></td>
                        <td><button type="button" value="<?php echo $skill['skill_id']; ?>"
                            id="button-delete-skill<?php echo $skill['skill_id']; ?>"
                            data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip"
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