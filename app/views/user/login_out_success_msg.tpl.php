<div class="msg">

    <h2>Bonjour <?= $user->getFirstName() ?> <?= $user->getLastName() ?></h2>

    <?php
    // Pour afficher les messages d'erreurs éventuels.
    include __DIR__ . '/../partials/errors.tpl.php';
    ?>
</div>