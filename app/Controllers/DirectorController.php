<?php

namespace App\Controllers;

use App\Models\Director;

class DirectorController extends CoreController
{
    /**
     * liste des réalisateurs
     *
     * @return void
     */
    public function directorsList()
    {
         $this->show('user/directors_list', [
            'directors' => Director::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }
        

    public function addDirector()
    {
        $this->show('user/director-add_edit', [
            'title' => "Ajouter un Réalisateur",
            'director'  => new Director(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addDirectorPost()
    {

        $tabErreurs = [];
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname  = filter_input(INPUT_POST, 'lastname');
        $birth      = filter_input(INPUT_POST, 'birth');
        $poster      = filter_input(INPUT_POST, 'poster');
        $biography      = filter_input(INPUT_POST, 'biography');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }

        if ($firstname === null || strlen($firstname) === 0) {
            $tabErreurs[] = "Le prénom n'est pas correct";
        }
        if ($lastname === null || strlen($lastname) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }
        if ($birth === null || strlen($birth) === 0) {
            $tabErreurs[] = "La date de naissance n'est pas correcte";
        }
        if ($poster === null || strlen($poster) === 0) {
            $tabErreurs[] = "L'image n'est pas correct";
        }
        if ($biography === null || strlen($biography) === 0) {
            $tabErreurs[] = "La biographie n'est pas correcte";
        }

        $director = new Director();
        $director->setFirstname($firstname);
        $director->setLastname($lastname);
        $director->setBirth($birth);
        $director->setPoster($poster);
        $director->setBiography($biography);

        if (count($tabErreurs) === 0) {
            $resultDB = $director->save();
            header("Location: /user/directors-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/director-add_edit', [
                'title' => "Ajouter un utilisateur",
                'director'  => $director,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }

    public function deleteDirector($id)
    {
        $director = Director::find($id);

        // On récupère le token Csrf passé dans la route sous la forme
        // /movie/delete/id?tokenCsrf=ziuefchieuhefiefzuhezfiuh

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        if ($director == null || $director === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $director->delete();
            header("Location: /user/directors-list");
        }
    }

}
