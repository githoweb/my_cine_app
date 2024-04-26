<div>
    <a href="<?= $router->generate('actor-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Acteurs</h2>

    <div class="personsList">

        <?php foreach($actors as $actor) : ?>

        <figure>
            <img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $actor->getPoster() ?>" alt="" />
            <p><?= $actor->getFirstname() ?> <?= $actor->getLastname() ?></p>
            <span>#<?= $actor->getId() ?></span>
            <a href="<?= $router->generate('actor-delete', ['id' => $actor->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>" class="btn btn-danger">supprimer</a>
        </figure>

        <?php endforeach ?>

    </div>

</div>