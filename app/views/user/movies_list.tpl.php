<div>
    <a href="<?= $router->generate('movie-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Films</h2>
    
    <div class="personsList">

        <?php foreach($movies as $movie) : ?>

        <figure>
            <img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $movie->getPoster() ?>" alt="" />
            <p><?= $movie->getTitle() ?></p>
            <span>#<?= $movie->getId() ?></span>
            <a href="<?= $router->generate('movie-delete', ['id' => $movie->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>"class="btn btn-danger">supprimer</a>
        </figure>

        <?php endforeach ?>

    </div>

</div>