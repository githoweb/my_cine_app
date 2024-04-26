<?php

namespace App\Controllers;

class CoreController
{
    public function __construct()
    {
        global $match;

        // On récupère la variable match initialisée par altorouter
        // ou y trouve sous la clé ['target']['acl'] la liste des droits requis
        // pour l'accès à la page
        if (isset($match['target']['acl'])) {

            // On teste si l'utilisateur a les droits
            $this->checkAuthorization($match['target']['acl']);
        }

    }

    /**
     * Génère un token CSRF, le mémorise codé en session et le retourne
     *
     * @return string
     */
    public static function setCsrf()
    {
        $_SESSION['tokenCsrf'] = bin2hex(random_bytes(32));
        return $_SESSION['tokenCsrf'];        
    }

    /**
     * Vérifie que le token recu en POST après soumission est bien celui stocké en session
     *
     * @param $tokenCsrf
     * @return void
     */
    public static function checkCsrf($tokenCsrf)
    {
        $test = $tokenCsrf === $_SESSION['tokenCsrf'];
        unset($_SESSION['tokenCsrf']);
        return $test;
    }

    /**
     * vérifie que l'utilisateur connecté dispose bien d'un rôle requis pour l'accès a cette page
     * 
     * @param array $roles
     * @return bool
     */
    public function checkAuthorization($roles = [])
    {
        if (!isset($_SESSION['userId'])) {
            // Utilisateur non connécté :  on renvoit à la page de login
            header("Location: /login");
            exit;
        } else {
            $user = $_SESSION['userObject'];
            $userRole = $user->getRole();

            // Le role de l'utilisateur est il présent dans la liste passée en paramètre
            $hasRole = in_array($userRole, $roles);

            if ($hasRole === true) {
                return true;
            } else {
                // non : erreur 403 : forbidden access
                $this->show("error/err403");
                exit;
            }
        }
    }

    /**
     * affiche du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router pour le récupérer depuis le frontController
        global $router;

        // $viewData est déclarée comme paramètre de la méthode show()
        // toutes les vues y ont accès
        $viewData['currentPage'] = $viewName;

        // définit l'url absolue pour les assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site (le répertoire public) != racine projet
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // La fonction extract permet de créer une variable pour chaque élément du tableau $viewData
        extract($viewData);

        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}