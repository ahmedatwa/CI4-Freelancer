<?php echo $header; ?>
<div class="container">
  <div class="row align-items-center justify-content-center h-100">
    <div id="login">
        <div class="card">
            <div class="card-header"><i class="fas fa-lock"></i> <?php echo $heading_title; ?></div>
            <div class="card-body p-3">
                <?php if($error) { ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <?php echo $error; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post" encrypt="multipart/form-data" accept-charset="utf-8">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="form-group auth-form-group-custom mb-4">
                    <i class="ri-mail-line auti-custom-input-icon"></i>
                    <label for="useremail"><?php echo $entry_email; ?></label>
                    <input type="email" class="form-control" id="useremail" value="<?php echo $email; ?>" name="email">
                </div>
                <div class="mt-4 text-center">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit"><?php echo $button_reset; ?></button>
                    <a class="btn btn-light" href="<?php echo $cancel; ?>">
                        <i class="fas fa-reply"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $footer; ?>
