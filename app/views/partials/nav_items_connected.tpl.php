<ul>
  <li>
    <a href="<?= $router->generate('movies-list') ?>" title="Films">Affichage Front Office</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-movies-list') ?>">Les Films</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-actors-list') ?>">Les Acteurs</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-directors-list') ?>">Les Réalisateurs</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-genres-list') ?>">Les Genres</a>
  </li>
  <li>
    <a href="<?= $router->generate('users-list') ?>">Les Utilisateurs</a>
  </li>
</ul>


<div class="logged">
  Vous êtes connecté
  <a href="<?= $router->generate('logout') ?>">Déconnexion</a>
</div>
