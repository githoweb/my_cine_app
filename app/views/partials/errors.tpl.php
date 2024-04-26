<?php if (!empty($errors)) : ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $error) : ?>
      <div><?= $error ?></div>
    <?php endforeach ?>
  </div>
<?php endif ?>

<?php if (!empty($success)) : ?>
  <div class="alert alert-success">
    <?php foreach ($success as $msg) : ?>
      <div><?= $msg ?></div>
    <?php endforeach ?>
  </div>
<?php endif ?>