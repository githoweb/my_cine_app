<div>
    <a href="<?= $router->generate('genre-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Genres</h2>

    <ul>
        <?php foreach ($genres as $genre) : ?>

            <li>
                <span>#<?= $genre->getId() ?></span>
                <?= $genre->getName() ?> => <a href="<?= $router->generate('genre-delete', ['id' => $genre->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>"class="btn btn-danger">supprimer</a>
            </li>

        <?php endforeach ?>

</div>