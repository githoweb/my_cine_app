<?php

namespace App\Controllers;

use App\Models\Genre;

class GenreController extends CoreController
{

    public function genresList()
    {
         $this->show('user/genres_list', [
            'genres' => Genre::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addGenre()
    {
        $this->show('user/genre-add_edit', [
            'title' => "Ajouter un genre",
            'genre'  => new Genre(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addGenrePost()
    {

        $tabErreurs = [];
        $name = filter_input(INPUT_POST, 'name');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }

        if ($name === null || strlen($name) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }

        $genre = new Genre();
        $genre->setName($name);

        if (count($tabErreurs) === 0) {
            if ($genre->save() === false) {
                $tabErreurs[] = "Echec de la sauvegarde";
            };
        }

        if (count($tabErreurs) === 0) {
            $resultDB = $genre->save();
            header("Location: /user/genres-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/genre-add_edit', [
                'title' => "Ajouter un genre",
                'genre'  => $genre,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }

    public function deleteGenre($id)
    {
        $genre = Genre::find($id);

        // On récupère le token Csrf passé dans la route sous la forme
        // /movie/delete/id?tokenCsrf=ziuefchieuhefiefzuhezfiuh

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        if ($genre == null || $genre === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $genre->delete();
            header("Location: /user/genres-list");
        }
    }
}
