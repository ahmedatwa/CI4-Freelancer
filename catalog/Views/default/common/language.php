<?php if ($languages) { ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <div class="form-group">
      <select class="custom-select" id="language-list">
        <?php foreach ($languages as $language) { ?>
          <?php if ($language['code'] == $code) { ?>
            <option value="<?php echo $language['code'];?>" data-redirect="<?php echo $language['href'];?>" selected><?php echo $language['name'];?></option>
          <?php } else { ?>
            <option value="<?php echo $language['code'];?>" data-redirect="<?php echo $language['href'];?>"><?php echo $language['name'];?></option>
         <?php } ?>   
        <?php } ?>
      </select>
    </div>
    <input type="hidden" name="code" value=""/> 
    <input type="hidden" name="redirect" value=""/>
  </form>
<?php } ?>