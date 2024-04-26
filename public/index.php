<?php
// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)

use App\Controllers\MainController;
use App\Controllers\MovieController;
use App\Controllers\ActorController;
use App\Controllers\DirectorController;
use App\Controllers\GenreController;
use App\Controllers\UserController;

require_once '../vendor/autoload.php';

// Mise en route des sessions au niveau de PHP
session_start();


/* ---- SCSS ---- */
use ScssPhp\ScssPhp\Compiler;

$compiler = new Compiler();

$source = file_get_contents('../app/scss/styles.scss');

try {
  $output = $compiler->compile($source);
  file_put_contents('assets/css/output.css', $output);
//   echo 'SCSS compiled successfully!';
} catch (\Exception $e) {
//   echo 'Error compiling SCSS: ' . $e->getMessage();
}


/* ------------
--- ROUTAGE ---
-------------*/


$router = new AltoRouter();

// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

$router->map(
    'GET',
    '/',
    [
        'method' => 'list',
        'controller' => MovieController::class,
        // 'acl' => ["admin"]
    ],
    'main-home'
);


/* --- Movies --- */

$router->map(
    'GET',
    '/movie/list',
    [
        'method' => 'list',
        'controller' => MovieController::class,
        // 'acl' => ["admin"]
    ],
    'movies-list'
);

$router->map(
    'GET',
    '/movie/listFiltered',
    [
        'method' => 'listFiltered',
        'controller' => MovieController::class,
        // 'acl' => ["admin"]
    ],
    'movies-listFiltered'
);

$router->map(
    'GET',
    '/movie/[i:id]',
    [
        'method' => 'movieDetail',
        'controller' => MovieController::class,
                // 'acl' => ["admin"]
    ],
    'movie-detail'
);

$router->map(
    'GET',
    '/user/movies-list',
    [
        'method' => 'moviesList',
        'controller' => MovieController::class,
        'acl' => ["admin", "member"] 
    ],
    'user-movies-list'
);

$router->map(
    'GET',
    '/user/movie-add',
    [
        'method' => 'addMovie',
        'controller' => MovieController::class,
        'acl' => ["admin", "member"]
    ],
    'movie-add'
);

$router->map(
    'POST',
    '/user/movie-add',
    [
        'method' => 'addMoviePost',
        'controller' => MovieController::class,
        'acl' => ["admin", "member"]
    ],
    'movie-add-post'
);

$router->map(
    'GET',
    '/movie/delete/[i:id]',
    [
        'method' => 'deleteMovie',
        'controller' => MovieController::class,
        'acl' => ["admin"]
    ],
    'movie-delete'
);


/* --- Actors --- */

$router->map(
    'GET',
    '/user/actors-list',
    [
        'method' => 'actorsList',
        'controller' => ActorController::class,
        'acl' => ["admin", "member"] 
    ],
    'user-actors-list'
);


$router->map(
    'GET',
    '/user/actor-add',
    [
        'method' => 'addActor',
        'controller' => ActorController::class,
        'acl' => ["admin", "member"]
    ],
    'actor-add'
);

$router->map(
    'POST',
    '/user/actor-add',
    [
        'method' => 'addActorPost',
        'controller' => ActorController::class,
        'acl' => ["admin", "member"]
    ],
    'add-actor-post'
);

$router->map(
    'GET',
    '/actor/delete/[i:id]',
    [
        'method' => 'deleteActor',
        'controller' => ActorController::class,
        'acl' => ["admin"]
    ],
    'actor-delete'
);



/* --- Directors --- */

$router->map(
    'GET',
    '/director/list',
    [
        'method' => 'list',
        'controller' => DirectorController::class,
        'acl' => ["admin", "member"]
    ],
    'directors-list'
);

$router->map(
    'GET',
    '/user/directors-list',
    [
        'method' => 'directorsList',
        'controller' => DirectorController::class,
        'acl' => ["admin", "member"] 
    ],
    'user-directors-list'
);

$router->map(
    'GET',
    '/user/director-add',
    [
        'method' => 'addDirector',
        'controller' => DirectorController::class,
        'acl' => ["admin", "member"]
    ],
    'director-add'
);

$router->map(
    'POST',
    '/user/director-add',
    [
        'method' => 'addDirectorPost',
        'controller' => DirectorController::class,
        'acl' => ["admin", "member"]
    ],
    'director-add-post'
);

$router->map(
    'GET',
    '/director/delete/[i:id]',
    [
        'method' => 'deleteDirector',
        'controller' => DirectorController::class,
        'acl' => ["admin"]
    ],
    'director-delete'
);

/* --- Genres --- */

$router->map(
    'GET',
    '/user/genres-list',
    [
        'method' => 'genresList',
        'controller' => GenreController::class,
        'acl' => ["admin", "member"] 
    ],
    'user-genres-list'
);

$router->map(
    'GET',
    '/user/genre-add',
    [
        'method' => 'addGenre',
        'controller' => GenreController::class,
        'acl' => ["admin", "member"]
    ],
    'genre-add'
);

$router->map(
    'POST',
    '/user/genre-add',
    [
        'method' => 'addGenrePost',
        'controller' => GenreController::class,
        'acl' => ["admin", "member"]
    ],
    'genre-add-post'
);

$router->map(
    'GET',
    '/genre/delete/[i:id]',
    [
        'method' => 'deleteGenre',
        'controller' => GenreController::class,
        'acl' => ["admin"]
    ],
    'genre-delete'
);


/* --- USER --- */

$router->map(
    'GET|POST',
    '/login',
    [
        'method' => 'loginPost',
        'controller' => UserController::class,
    ],
    'login'
);

$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => UserController::class ,
        'acl' => ["admin", "member"]
    ],
    'logout'
);

$router->map(
    'GET',
    '/user/users-list',
    [
        'method' => 'usersList',
        'controller' => UserController::class,
        'acl' => ["admin"] 
    ],
    'users-list'
);

$router->map(
    'GET',
    '/user/user-add',
    [
        'method' => 'addUser',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'user-add'
);

$router->map(
    'POST',
    '/user/user-add',
    [
        'method' => 'addUserPost',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'user-add-post'
);

$router->map(
    'GET',
    '/user/delete/[i:id]',
    [
        'method' => 'deleteUser',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'user-delete'
);



/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
