<?php if (count($currencies) > 0) { ?>
  <div class="footer-row">
    <div class="footer-row-inner language-switcher">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
        <div class="form-group">
          <select class="custom-select" id="currency-list">
            <?php foreach ($currencies as $currency) { ?>
              <?php if ($currency['code'] == $code) { ?>
                <option value="<?php echo $currency['code'];?>" selected><?php echo $currency['title'];?></option>
              <?php } else { ?>
                <option value="<?php echo $currency['code'];?>"><?php echo $currency['title'];?></option>
              <?php } ?>   
            <?php } ?>
          </select>
        </div>
        <input type="hidden" name="code" value=""/> <input type="hidden" name="redirect" value="<?php echo $redirect; ?>"/>
      </form>
    </div>
  </div>
  <?php } ?>