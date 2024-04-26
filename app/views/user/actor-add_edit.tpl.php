<div class="form_action">
    <a href="<?= $router->generate('user-actors-list') ?>" class="btn btn-primary">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <?php 
            include __DIR__ . '/../partials/csrf.tpl.php';
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php';
        ?>

        <?= $actor->getId() ?>

        <div class="formItem">
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" placeholder="Prénom"
                   name="firstname" value="<?= $actor->getFirstname() ?>">
        </div>

        <div class="formItem">
            <label for="lastname">Nom</label>
            <input type="text" id="lastname" placeholder="Nom"
                   name="lastname" value="<?= $actor->getLastname() ?>">
        </div>

        <div class="formItem">
            <label for="poster">Photo</label>
            <input type="text" id="poster" placeholder="Photo"
                   name="poster" value="<?= $actor->getPoster() ?>">
        </div>

        <div class="formItem">
            <label for="birth">Naissance</label>
            <input type="text" id="birth" placeholder="Année de naissance"
                   name="birth" value="<?= $actor->getBirth() ?>">
        </div>

        <div class="formItem">
            <label for="biography">Biographie</label>
            <textarea id="biography" name="biography"><?= $actor->getBiography() ?></textarea>
        </div>

        <div class="action">
            <button type="submit" class="btn btn-success">Valider</button>
        </div>

    </form>
</div>