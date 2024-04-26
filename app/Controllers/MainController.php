<?php

namespace App\Controllers;

use App\Models\Movie;

class MainController extends CoreController
{
    /**
     * page d'accueil
     *
     * @return void
     */
    public function home()
    {
        $movieObj = new Movie();
        $movies = $movieObj->findAll();

        $this->show('main/home', [
            'movies'   => $movies,
        ]);
    }
}