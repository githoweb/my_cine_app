<h1><?= $movie->getTitle() ?></h1>

<?php

$baseUrl = $router->generate('movies-list');
$url = $baseUrl . '?' . $queryString;
?>

<a href="<?= $url ?>" class="btn btn-primary" title="">Retour à la liste des films</a>

<div class="card card-alt">

  <div class="card-poster">
    <img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $movie->getPoster() ?>" alt="" />
  </div>
  <div class="card-data">
    <div class="card-item">
      <p>Date de sortie : <?= $movie->getDate() ?></p>
    </div>
    <div class="card-item">
      <p><?= $movie->getSynopsis() ?></p>
    </div>
  </div>
</div>