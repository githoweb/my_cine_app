<div>

    <h2>Formulaire de connexion</h2>

    <form action="" method="POST">

        <?php
        // Pour afficher les messages d'erreurs éventuels.
        include __DIR__ . '/../partials/errors.tpl.php';
        ?>

        <div class="formItem">
            <label for="email">Email</label>
            <input name="email" value="<?= $userEmail ?>" type="text" id="email" placeholder="Entrez ici votre adresse mail" aria-describedby="emailHelpBlock">
            <small id="emailHelpBlock" class="form-text text-muted">
                mettez ici une adresse mail valide
            </small>
        </div>

        <div class="formItem">
            <label for="password">Password</label>
            <input name="password" type="password" id="password" placeholder="Entrez ici votre password" aria-describedby="passwordHelpBlock">
            <small id="passwordHelpBlock" class="form-text text-muted">
                Entrez votre password
            </small>
        </div>

        <div class="action">
            <button type="submit" class="btn btn-success">Se connecter</button>
        </div>

    </form>
</div>