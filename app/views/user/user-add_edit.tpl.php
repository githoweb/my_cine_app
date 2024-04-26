<div class="form_action">
    <a href="<?= $router->generate('users-list') ?>" class="btn btn-primary">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <?php
        include __DIR__ . '/../partials/csrf.tpl.php';
        // Affichage des erreurs
        include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div class="formItem">
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" placeholder="Prénom de l'utilisateur" name="firstname" value="<?= $user->getFirstName() ?>">
        </div>

        <div class="formItem">
            <label for="lastname">Nom</label>
            <input type="text" id="lastname" placeholder="Nom de l'utilisateur" name="lastname" value="<?= $user->getLastName() ?>">
        </div>

        <div class="formItem">
            <label for="email">Email</label>
            <input type="text" id="email" placeholder="Adresse mail de l'utilisateur" name="email" value="<?= $user->getEmail() ?>">
        </div>

        <div class="formItem">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" placeholder="Mot de passe de l'utilisateur" name="password" value="">
        </div>

        <div class="formItem">
            <label for="category">Role de l'utilisateur</label>
            <select name="role" id="role" aria-describedby="roleHelpBlock">
                <option value="admin" <?= $user->getRole() === "admin" ? " selected" : "" ?>>Admin</option>
                <option value="catalog-manager" <?= $user->getRole() == "catalog-manager" ? " selected" : "" ?>>Gestionnaire de catalogue</option>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                Le role de l'utilisateur
            </small>
        </div>

        <div class="action">
            <button type="submit" class="btn btn-success">Valider</button>
        </div>

    </form>
</div>