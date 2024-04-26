<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Director extends CoreModel
{

    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $birth;
    /**
     * @var string
     */
    private $poster;
    /**
     * @var string
     */
    private $biography;

    public static function find($directorId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM director
            WHERE id = ' . $directorId;

        $pdoStatement = $pdo->query($sql);

        $result = $pdoStatement->fetchObject('App\Models\Director');

        return $result;
    }

    /**
     * récupérer tous les enregistrements de la table director
     *
     * @return Director[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `director`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Director');

        return $results;
    }

    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO director (firstname, lastname, birth, poster, biography)
                VALUES (:firstname, :lastname, :birth, :poster, :biography)";
                
        $query = $pdo->prepare($sql);

        $query->bindValue(':firstname'        ,$this->firstname, PDO::PARAM_STR);
        $query->bindValue(':lastname' ,$this->lastname, PDO::PARAM_STR);
        $query->bindValue(':birth'     ,$this->birth, PDO::PARAM_STR);
        $query->bindValue(':poster'       ,$this->poster, PDO::PARAM_STR);
        $query->bindValue(':biography'        ,$this->biography, PDO::PARAM_INT);

        $nbLignesModifiees = $query->execute();

        if ($nbLignesModifiees > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE director
            SET 
                firstname = :firstname,
                lastname = :lastname,
                birth = :birth,
                poster = :poster,
                biography = :biography,
                updated_at = NOW()
                WHERE id = :id;
        ";

        $query = $pdo->prepare($sql);

        $query->bindValue(':firstname'        ,$this->firstname, PDO::PARAM_STR);
        $query->bindValue(':lastname' ,$this->lastname, PDO::PARAM_STR);
        $query->bindValue(':birth'     ,$this->birth, PDO::PARAM_STR);
        $query->bindValue(':poster'       ,$this->poster, PDO::PARAM_STR);
        $query->bindValue(':biography'        ,$this->biography, PDO::PARAM_INT);
        $query->bindValue(':id'          ,$this->id);

        $nbLignesModifiees = $query->execute();

        // Je teste que exec a bien ajouté 1 ligne 
        if ($nbLignesModifiees) {
            // Récupération de la valeur de l'id généré par la database
            // et mise à jour du champ id de l'instance courante
            return true;
        } else {
            // Erreur, la requête sql n'a pas fonctionné
            return false;
        }
    }

    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM director WHERE id = :id";

        $query = $pdo->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $query->execute() > 0;
    }
    
    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $title
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of birth
     *
     * @return  string $birth
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * Set the value of birth
     *
     * @param  string  $birth
     */
    public function setBirth(string $birth)
    {
        $this->birth = $birth;
    }

    /**
     * Get the value of poster
     *
     * @return  string $poster
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set the value of poster
     *
     * @param  string  $poster
     */
    public function setPoster(string $poster)
    {
        $this->poster = $poster;
    }

        /**
     * Get the value of biography
     *
     * @return  string $biography
     */
    public function getBiography()
    {
        return $this->biography;        
    }

    /**
     * Set the value of biography
     *
     * @param  string  $biography
     */
    public function setBiography(string $biography)
    {
        $this->biography = $biography;
    }

}
