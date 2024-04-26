<h1>Liste de Films</h1>

<form method="get" action="<?= $router->generate('movies-list') ?>">

  <p class="filter_by">Filtrer par :</p>

  <fieldset>
    <select name="genre_id">
      <option selected=selected value="all">genre</option>
      <?php $index = 1; ?>
      <?php foreach ($genres as $genre) : ?>
        <option value="<?= $index ?>"><?= $genre->getName(); ?></option>
        <?php $index++; ?>
      <?php endforeach; ?>
    </select>

    <select name="year">
      <option selected=selected value="all">année</option>
      <?php for ($i = 1950; $i < 2024; $i++) : ?>
        <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>

    <select name="director_id">
      <option selected=selected value="all">réalisateur</option>
      <?php $index = 1; ?>
      <?php foreach ($directors as $director) : ?>
        <option value="<?= $index ?>"><?= $director->getFirstname(); ?> <?= $director->getLastname(); ?></option>
        <?php $index++; ?>
      <?php endforeach; ?>
    </select>

    <select name="actor_id">
      <option selected=selected value="all">acteur/actrice</option>
      <?php $index = 1; ?>
      <?php foreach ($actors as $actor) : ?>
        <option value="<?= $index ?>"><?= $actor->getFirstname(); ?> <?= $actor->getLastname(); ?></option>
        <?php $index++; ?>
      <?php endforeach; ?>
    </select>

    <button type="submit">GO</button>

  </fieldset>

</form>

<?php foreach ($movies as $movie) : ?>

  <?php
  // $type = gettype($movie->getDirectorId());
  // echo "Le type de la variable \$var est : $type";

  // $movie->getDirectorId() renvoie une string : il faut la convertir en integer
  $idToFind = intval($movie->getDirectorId());

  $filteredDirectors = array_filter($directors, function ($object) use ($idToFind) {
    return $object->getId() === $idToFind;
  });
  // retourne un tableau d'objets filtrés ou, s'il n'y a pas de résultats : false

  if ($filteredDirectors !== false) {
    $thisMovieDirector = reset($filteredDirectors);
  } else {
    // dans le cas où le filtrage renvoie false
    $thisMovieDirector = '';
  }
  ?>

  <div class="card">
    <div class="card-poster">
      <a href="<?= $router->generate('movie-detail', ['id' => $movie->getId()]); ?>" title=""><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $movie->getPoster() ?>" alt="" /></a>
    </div>
    <div class="card-data">
      <h2 class="card-title"><?= $movie->getTitle() ?> (<?= $movie->getDate() ?>)</h2>
      <ul class="card-item">
        <li>Réalisateur : <?= gettype($thisMovieDirector) !== 'boolean' ? $thisMovieDirector->getFirstname() : '' ?> <?= gettype($thisMovieDirector) !== 'boolean' ? $thisMovieDirector->getLastname() : '' ?></li>
        <li>Durée : <?= $movie->getDuration() ?>mn
      </ul>
      <p><?= $movie->getSynopsis() ?></p>
    </div>
  </div>

<?php endforeach ?>