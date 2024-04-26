<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController
{
    
    /**
     * traite les données POST recues après soumission du formulaire de login
     *
     * @return void
     */
    public function loginPost()
    {
        /*
            - Vérifier si le couple @mail, password est bien dans la base
            - Si Oui, alors je mémorise en session l'utilisateur qui est maintenant connecté
            - Si non, je réaffiche le formulaire de login avec une erreur

        */

        // Si la requette est 'GET' -> affichage du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            // Affichage du formulaire
            $this->show('user/login', [
                'userEmail' => ''
            ]);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $tabErreurs = [];

            // Récupération des données de formulaire (contenues dans $_POST)
            
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            if ($email === null || $email === false) {
                $tabErreurs[] = "L'adresse email est incorrecte";
            }

            if ($password === null || $password === false || $password === '') {
                $tabErreurs[] = "Le password ne doit pas être vide";
            }

            // On recherche l'email dans la base
            // retourne false si l'utilisateur n'existe pas
            $user = AppUser::findUserByEmail($email);

            if ($user === false) {
                $tabErreurs[] = "Cette adresse email n'existe pas";
            } else {
                if (password_verify($password, $user->getPassword()) === false) {
                    $tabErreurs[] = "Le mot de passe n'est pas le bon";
                }
            }

            if (count($tabErreurs) > 0) {
                // Il y a des erreurs, on réaffiche le formulaire
                $this->show('user/login', [
                    'userEmail' => $email,
                    'errors' => $tabErreurs
                ]);
            } else {
                // l'utilisateur est bien dans la base et le mot de passe saisi est correct
                // Enregistrement en session du user id et du user object

                $_SESSION['userId'] = $user->getId();
                $_SESSION['userObject'] = $user;

                $tabSuccess = [];
                $tabSuccess[] = "Vous êtes connecté";

                // dump($_SESSION['userObject']);

                $this->show('user/login_out_success_msg', [
                    'user' => $user,
                    'success' => $tabSuccess
                ]);
            }
        }
    }

    /**
     * se déconnecter
     *
     * @return void
     */
    public function logout()
    {
        $user = $_SESSION['userObject'];

        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);

        $tabSuccess = [];
        $tabSuccess[] = "Vous êtes bien déconnecté";

        $this->show('user/login_out_success_msg', [
            'user' => $user,
            'success' => $tabSuccess
        ]);
    }

    /**
     * lister l'ensemble des utilisateurs enregistrés
     *
     * @return void
     */
    public function usersList()
    {
         $this->show('user/users_list', [
            'users' => AppUser::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    /**
     * ajout d'un utilisateur (affichage)
     *
     * @return void
     */
    public function addUser()
    {
        $this->show('user/user-add_edit', [
            'title' => "Ajouter un utilisateur",
            'user'  => new AppUser(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addUserPost()
    {

        $tabErreurs = [];
        // Récupération des données du formulaire (POST)
        $firstName = filter_input(INPUT_POST, 'firstname');
        $lastName  = filter_input(INPUT_POST, 'lastname');
        $email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password  = filter_input(INPUT_POST, 'password');
        $role      = filter_input(INPUT_POST, 'role');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }
        // Contrôles sur les champs du form
        if ($firstName === null || strlen($firstName) === 0) {
            $tabErreurs[] = "Le prénom n'est pas correct";
        }
        if ($lastName === null || strlen($lastName) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }
        if ($email === null || strlen($email) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }
        if ($password === null || strlen($password) < 4 || !$this->testPwd($password)) {
            $tabErreurs[] = "Le password n'est pas correct";
        }
        if ($role !== "admin" && $role !== "catalog-manager") {
            $tabErreurs[] = "Le role n'est pas correct";
        }

        // On a une contrainte d'unicité dans la base sur le champ email
        // on controle que cet email n'existe pas déjà
        if (AppUser::findUserByEmail($email) !== false) {
            $tabErreurs[] = "Cet email est déjà enregistré";
        }

        // Initialisation d'un objet AppUser
        $user = new AppUser();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPassword($email);
        $user->setRole($role);

        if (count($tabErreurs) === 0) {
            // Il n'y a pas d'erreur -> hash password et sauvegard en database
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            if ($user->save() === false) {
                $tabErreurs[] = "Echec de la sauvegarde";
            };
        }

        if (count($tabErreurs) === 0) {
            header("Location: /user/users-list");
        } else {
            // Il y a des erreurs -> affichage du formulaire avec les données saisies
            $this->show('user/user-add_edit', [
                'title' => "Ajouter un utilisateur",
                'user'  => $user,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }

    public function deleteUser($id)
    {
        $user = AppUser::find($id);

        // On récupère le token Csrf passé dans la route sous la forme
        // /user/delete/id?tokenCsrf=ziuefchieuhefiefzuhezfiuh

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        


        if ($user == null || $user === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $user->delete();
            header("Location: /user/users-list");
        }
    }







    /* --- --- */

    /**
     * Fonction de test password
     *
     * @param string $password  le password à tester
     * @param integer $minLength la longueur min du password (default = 8)
     * @param boolean $noMinus true si on ne doit pas tester les minuscules
     * @param boolean $noMajus true si on ne doit pas tester les majuscules
     * @param boolean $noSpecial true si on ne doit pas tester les cars spéciaux
     * @param boolean $noNum true si on ne doit pas tester les chiffres
     * @return void
     */
    function testPwd($password, $minLength = 8, $noMinus = false, $noMajus = false, $noSpecial = false, $noNum = false)
    {

        if (true) {     // Pour executer une seule des deux alternatives (true : regexp, false: algo php)
            return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_$!%*#?&])[A-Za-z\d@$!%_*#?&]{8,}$/", $password);
        } else {

            if (strlen($password) < $minLength) {
            // Longueur pas bonne -> erreur
                return false;
            }

            // On splite le password caractère par caractère dans un tableau
            // ou parcours le password caractère par caractère
            foreach (str_split($password) as $c) {
                // Test des minuscules
                // Le 1er test (!noMinus) permet de ne plus faire le strpos si on a deja trouvé
                // une minuscule
                if (!$noMinus   && strpos("abcdefghijklmnopqrstuvwxyz", $c) !== false) {
                    // Le flag $noMinus est mis a true signalant que c'est bon pour les minuscules
                    $noMinus = true;
                }
                // Le 1er test (!noMajus) permet de ne plus faire le strpos si on a deja trouvé
                // une majuscule
                if (!$noMajus   && strpos("ABCDEFGHIJKLMNOPQRSTUVWXYZ", $c) !== false) {
                    // Le flag $noMajus est mis a true signalant que c'est bon pour les majuscules
                    $noMajus = true;
                }
                if (!$noSpecial && strpos("_-|%&*=@$]", $c) !== false) {
                    $noSpecial = true;
                }
                if (!$noNum     && strpos("0123456789", $c) !== false) {
                    $noNum = true;
                }
            }
            // pour retourner 'true', il faut que les 4 flags soient egalement à true
            return $noMinus && $noMajus && $noSpecial && $noNum;
        }
    }
}