<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Genre extends CoreModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * récupérer tous les enregistrements de la table genre
     *
     * @return Genre[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `genre`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Genre');

        return $results;
    }

    public static function find($genreId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM genre
            WHERE id = ' . $genreId;

        $pdoStatement = $pdo->query($sql);

        $result = $pdoStatement->fetchObject('App\Models\Genre');

        return $result;
    }

    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO genre (name)
                VALUES (:name)";
                
        $query = $pdo->prepare($sql);

        $query->bindValue(':name'        ,$this->name, PDO::PARAM_STR);

        $nbLignesModifiees = $query->execute();

        // Je teste que exec a bien ajouté 1 ligne 
        if ($nbLignesModifiees > 0) {
            // Récupération de la valeur de l'id généré par la database
            // et mise à jour du champ id de l'instance courante
            $this->id = $pdo->lastInsertId();
            return true;
        } else {
            // Erreur, la requête sql n'a pas fonctionné
            return false;
        }
    }

    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE genre
            SET 
                name = :name,
                updated_at = NOW()
                WHERE id = :id;
        ";

        $query = $pdo->prepare($sql);

        $query->bindValue(':name'        ,$this->name, PDO::PARAM_STR);
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

        $sql = "DELETE FROM genre WHERE id = :id";

        $query = $pdo->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $query->execute() > 0;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
