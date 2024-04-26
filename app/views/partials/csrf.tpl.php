<?php if (isset($tokenCsrf)) : ?>
  <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
<?php endif ?>