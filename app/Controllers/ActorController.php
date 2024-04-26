<?php

namespace App\Controllers;

use App\Models\Actor;

class ActorController extends CoreController
{
    public function actorsList()
    {
         $this->show('user/actors_list', [
            'actors' => Actor::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addActor()
    {
        $this->show('user/actor-add_edit', [
            'title' => "Ajouter un Acteur",
            'actor'  => new Actor(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addActorPost()
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

        $actor = new Actor();
        $actor->setFirstname($firstname);
        $actor->setLastname($lastname);
        $actor->setBirth($birth);
        $actor->setPoster($poster);
        $actor->setBiography($biography);

        if (count($tabErreurs) === 0) {
            $resultDB = $actor->save();
            header("Location: /user/actors-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/actor-add_edit', [
                'title' => "Ajouter un acteur",
                'actor'  => $actor,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }

    public function deleteActor($id)
    {
        $actor = Actor::find($id);

        // On récupère le token Csrf passé dans la route sous la forme
        // /movie/delete/id?tokenCsrf=ziuefchieuhefiefzuhezfiuh

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        if ($actor == null || $actor === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $actor->delete();
            header("Location: /user/actors-list");
        }
    }

}
