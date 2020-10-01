<?php if ($educations) { ?>
    <div class="table-responsive col-md-12">
        <table class="table table-bordered" id="education-table">
            <thead>
                <tr>
                    <th scope="col"><?php echo $column_country; ?></th>
                    <th scope="col"><?php echo $column_university; ?></th>
                    <th scope="col"><?php echo $column_major; ?></th>
                    <th scope="col"><?php echo $column_year; ?></th>
                    <th scope="col"><?php echo $column_action; ?></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($educations as $education) { ?>
                    <tr>
                        <td><?php echo $education['country']; ?></td>
                        <td><?php echo $education['university']; ?></td>
                        <td><?php echo $education['major']; ?></td>
                        <td><?php echo $education['year']; ?></td>
                        <td><button type="button" value="<?php echo $education['education_id']; ?>"
                            id="button-delete-education<?php echo $education['education_id']; ?>"
                            data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip"
                            title="<?php echo $button_delete; ?>" class="btn btn--icon btn-sm btn-danger"><i class="icon-feather-trash-2" aria-hidden="true"></i>
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