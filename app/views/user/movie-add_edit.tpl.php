<div class="form_action">
    <a href="<?= $router->generate('user-movies-list') ?>" class="btn btn-primary">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <?php
        // Affichage des erreurs
        include __DIR__ . '/../partials/errors.tpl.php';
        include __DIR__ . '/../partials/csrf.tpl.php';
        ?>

        <div class="formItem">
            <label for="title">Titre</label>
            <input type="text" id="title" placeholder="Titre" name="title" value="<?= $movie->getTitle() ?>">
        </div>
        <div class="formItem">
            <label for="poster">Affiche</label>
            <input type="text" id="poster" placeholder="Affiche" name="poster" value="<?= $movie->getPoster() ?>">
        </div>
        <div class="formItem">
            <label for="duration">Durée</label>
            <input type="text" id="duration" placeholder="Durée" name="duration" value="<?= $movie->getDuration() ?>">
        </div>
        <div class="formItem">
            <label for="year">Date</label>
            <input type="text" id="year" placeholder="year" name="year" value="<?= $movie->getDate() ?>">
        </div>
        <div class="formItem">
            <label for="genre_id">Genre</label>
            <input type="text" id="genre_id" placeholder="Genre" name="genre_id" value="<?= $movie->getGenreId() ?>">
        </div>
        <div class="formItem">
            <label for="director_id">Réalisateur</label>
            <input type="text" id="director_id" placeholder="Réalisateur" name="director_id" value="<?= $movie->getDirectorId() ?>">
        </div>
        <div class="formItem">
            <label for="synopsis">Synopsis</label>
            <textarea value="<?= $movie->getDirectorId() ?>" placeholder="Synopsis" name="synopsis"></textarea>
        </div>
        <div class="action">
            <button type="submit" class="btn btn-success">Valider</button>
        </div>

    </form>
</div>