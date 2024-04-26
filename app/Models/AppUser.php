<?php

namespace App\Models;

use App\Utils\Database;
use Exception;
use PDO;

class AppUser extends CoreModel
{

  /**
   *
   * @var string
   */
  private $email;

  /**
   *
   * @var string
   */
  private $password;

  /**
   *
   * @var string
   */
  private $firstname;

  /**
   *
   * @var string
   */
  private $lastname;

  /**
   *
   * @var string
   */
  private $role;


      /**
     * Recherche un enregistrement d'utilisateur dans la database
     *
     * @param integer $id
     * @return false|AppUser
     */
    public static function find(int $id)
    {
        // Ici on peut se passer de faire une protection injection SQL
        // Du fait que le param $id est forcéement un entier

        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM app_user
            WHERE id = ' . $id;

        $pdoStatement = $pdo->query($sql);

        $user = $pdoStatement->fetchObject(AppUser::class);

        return $user;        
    }
    
    /**
     * récupere tous les enregistrements de la table app_user
     *
     * @return void
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `app_user`';

        $pdoStatement = $pdo->query($sql);

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);

        return $results;
    }

    /**
     * retrouve un utilisateur avec son adresse email
     *
     * @param string $email
     * @return false|AppUser
     */
    public static function findUserByEmail(string $email)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `app_user` WHERE email = :email';

        $query = $pdo->prepare($sql);

        $query->execute([
            ':email'     => $email
        ]);

        // récupération des données et stockage dans une instance de AppUser
        return $query->fetchObject(AppUser::class);
    }

  /**
   * Insere nouvel enregistrement en database
   *
   * @return bool
   */
  public function insert()
  {
    $pdo = Database::getPDO();

    $query = $pdo->prepare("
      INSERT INTO `app_user` (email, password, firstname, lastname, role)
      VALUES (
          :email,
          :password,
          :firstname,
          :lastname,
          :role
      )");

    $query->execute([
      ':email'     => $this->getEmail(),
      ':password'  => $this->getPassword(),
      ':firstname' => $this->getFirstname(),
      ':lastname'  => $this->getLastname(),
      ':role'      => $this->getRole(),
    ]);

    // renseigne l'id de l'objet avec le 'lastInsertId'
    if ($query->rowCount() > 0) {
        $this->id = $pdo->lastInsertId();
        return true;
    }
    // Signifie que l'insert n'à pas fonctionné pour une raison quelconque
    return false;
  }

  /**
   * Modifie un enregistrement en database
   *
   * @return bool
   */
  public function update()
  {
    $pdo = Database::getPDO();

    $sql = "
    UPDATE `app_user` set 
        email = :email,
        password = :password,
        firstname = :firstname,
        lastname = :lastname,
        role = :role,
        updated_at = now()
    where id = :id";

    $query = $pdo->prepare($sql);

    $query->execute([
      ':email'     => $this->getEmail(),
      ':password'  => $this->getPassword(),
      ':firstname' => $this->getFirstname(),
      ':lastname'  => $this->getLastname(),
      ':role'      => $this->getRole(),
      ':id'        => $this->getId()
    ]);

    return ($query->rowCount() > 0);
  }
  /**
   * Supprimer enregistrement en database
   *
   * @return bool
   */
  public function delete()
  {
    $pdo = Database::getPDO();

    $sql = "delete from app_user where id = :id";

    $query = $pdo->prepare($sql);

    $updatedRows = $query->execute([
      ':id' => $this->getId()
    ]);

    // On retourne VRAI, si au moins une ligne supprimée
    return ($updatedRows > 0);
  }

  /**
   * Get the value of role
   *
   * @return  string
   */
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @param  string  $role
   *
   * @return  self
   */
  public function setRole(string $role)
  {
    $this->role = $role;

    return $this;
  }

  /**
   * Get the value of email
   *
   * @return  string
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @param  string  $email
   *
   * @return  self
   */
  public function setEmail(string $email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   *
   * @return  string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @param  string  $password
   *
   * @return  self
   */
  public function setPassword(string $password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of lastname
   *
   * @return  string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @param  string  $lastname
   *
   * @return  self
   */
  public function setLastname(string $lastname)
  {
    $this->lastname = $lastname;

    return $this;
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
   * @param  string  $firstname
   *
   * @return  self
   */
  public function setFirstname(string $firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }
}