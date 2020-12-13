<?php echo $header; ?>
<div class="container">
  <div class="row align-items-center justify-content-center h-100">
    <div id="login" class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-lock"></i> <?php echo $heading_title; ?></div>
            <div class="card-body p-3">
                <!-- Alerts -->
                <?php if($success) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <?php if($warning) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $warning; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <form action="<?php echo $action; ?>" method="post" encrypt="multipart/form-data" accept-charset="utf-8">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="form-group">
                    <label for=""><?php echo $entry_email; ?></label>
                        <input type="text" name="email" class="form-control" id="input-email" placeholder="<?php echo $entry_email; ?>" value="<?php echo $email; ?>">
                        <?php echo form_error('email');?>
                    </div>
                    <div class="form-group">
                    <label for=""><?php echo $entry_password; ?></label>
                        <input type="password" name="password" class="form-control" id="input-password" placeholder="<?php echo $entry_password; ?>" value="<?php echo $password; ?>">
                        <?php echo form_error('password');?>

                    </div>
                    <div class="mt-4 text-center">
                        <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> <?php echo $button_login; ?></button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="<?php echo $forgot; ?>" class="text-dark"><i class="fas fa-unlock-alt"></i> <?php echo $text_forget_password; ?></a>
                    </div>
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $footer; ?>

