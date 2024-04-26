<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Movie extends CoreModel
{

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $synopsis;
    /**
     * @var string
     */
    private $poster;
    /**
     * @var string
     */
    private $duration;
    /**
     * @var string
     */
    private $date;
    /**
     * @var int
     */
    protected $director_id;

    /**
     * @var int
     */
    protected $genre_id;

    /**
     * @var int
     */
    protected $id;

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `movie`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
    }

    public static function findAllFiltered($year = "all", $genre_id = "all", $director_id = "all", $actor_id = "all")
    {
        $pdo = Database::getPDO();

        $conditions = [];
        $parameters = [];

        $sql = "SELECT * FROM movie ";

        if ($genre_id != "all") {
            $conditions[] = "genre_id = " . $genre_id;
        }
        if ($director_id !== "all") {
            $conditions[] = "director_id = " . $director_id;
        }

        if ($year !== "all") {
            $conditions[] = "date = " . $year;
        }

        $actorCondition = "";

        if ($actor_id !== "all") {
            $actorCondition = "INNER JOIN actor_movie ON movie.id = actor_movie.movie_id";
            $conditions[] = "actor_id = " . $actor_id;
        }

        if (!empty($conditions)) {
            $sql .= $actorCondition . " WHERE " . implode(" AND ", $conditions);
        }

        // dump($sql);

        $pdoStatement = $pdo->query($sql);

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
    }


    public static function find($movieId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM movie
            WHERE id = ' . $movieId;

        $pdoStatement = $pdo->query($sql);

        $result = $pdoStatement->fetchObject('App\Models\Movie');

        return $result;
    }

    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO movie (title, synopsis, poster, duration, date, director_id, genre_id)
                VALUES (:title, :synopsis, :poster, :duration, :date, :director_id, :genre_id)";

        $query = $pdo->prepare($sql);

        $query->bindValue(':title', $this->title, PDO::PARAM_STR);
        $query->bindValue(':synopsis', $this->synopsis, PDO::PARAM_STR);
        $query->bindValue(':poster', $this->poster, PDO::PARAM_STR);
        $query->bindValue(':duration', $this->duration, PDO::PARAM_STR);
        $query->bindValue(':date', $this->date, PDO::PARAM_STR);
        $query->bindValue(':director_id', $this->director_id, PDO::PARAM_INT);
        $query->bindValue(':genre_id', $this->director_id, PDO::PARAM_INT);

        $nbLignesModifiees = $query->execute();

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
            UPDATE movie
            SET 
                title = :title,
                synopsis = :synopsis,
                poster = :poster,
                duration = :duration,
                date = :date,
                director_id = :director_id,
                genre_id = :genre_id,
                updated_at = NOW()
                WHERE id = :id;
        ";

        $query = $pdo->prepare($sql);

        $query->bindValue(':title', $this->title, PDO::PARAM_STR);
        $query->bindValue(':synopsis', $this->synopsis, PDO::PARAM_STR);
        $query->bindValue(':poster', $this->poster, PDO::PARAM_STR);
        $query->bindValue(':duration', $this->duration, PDO::PARAM_STR);
        $query->bindValue(':date', $this->date, PDO::PARAM_INT);
        $query->bindValue(':director_id', $this->director_id, PDO::PARAM_INT);
        $query->bindValue(':genre_id', $this->director_id, PDO::PARAM_INT);
        $query->bindValue(':id', $this->id);

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

        $sql = "DELETE FROM movie WHERE id = :id";

        $query = $pdo->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $query->execute() > 0;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Get the value of synopsis
     *
     * @return  string
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set the value of synopsis
     *
     * @param  string  $synopsis
     */
    public function setSynopsis(string $synopsis)
    {
        $this->synopsis = $synopsis;
    }

    /**
     * Get the value of poster
     *
     * @return  string
     */
    public function getPoster()
    {
        // return "https://image.tmdb.org/t/p/original" . $this->poster;
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
     * Get the value of duration
     *
     * @return  string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @param  string  $duration
     */
    public function setDuration(string $duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get the value of date
     *
     * @return  string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param  string  $date
     */
    public function setDate(string $date)
    {
        $this->date = $date;
    }

    /**
     * Get the value of date
     *
     * @return  string
     */
    public function getGenreId()
    {
        return $this->genre_id;
    }

    /**
     * Set the value of date
     *
     * @param  string  $date
     */
    public function setGenreId(string $genre_id)
    {
        $this->genre_id = $genre_id;
    }

        /**
     * Get the value of date
     *
     * @return  string
     */
    public function getDirectorId()
    {
        return $this->director_id;
    }

    /**
     * Set the value of date
     *
     * @param  string  $date
     */
    public function setDirectorId(string $director_id)
    {
        $this->director_id = $director_id;
    }
}
