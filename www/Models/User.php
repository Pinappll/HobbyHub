<?php

namespace App\Models;

use App\Core\DB;

class User extends DB
{
    private ?int $id = null;
    protected string $firstname_user;
    protected string $lastname_user;
    protected string $email_user;
    protected string $password_user;
    protected string $type_user = "viewer";
    protected string $token_user = '';
    protected bool $is_deleted;
    protected bool $is_verified_user;


    public function __construct()
    {
        parent::__construct();
    }

    public function __toString()
    {
        return $this->getFirstname_user() . " " . $this->getLastname_user();
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of firstname_user
     */
    public function getFirstname_user()
    {
        return $this->firstname_user;
    }

    /**
     * Set the value of firstname_user
     *
     * @return  self
     */
    public function setFirstname_user($firstname_user)
    {
        $this->firstname_user = $firstname_user;

        return $this;
    }

    /**
     * Get the value of lastname_user
     */
    public function getLastname_user()
    {
        return $this->lastname_user;
    }

    /**
     * Set the value of lastname_user
     *
     * @return  self
     */
    public function setLastname_user($lastname_user)
    {
        $this->lastname_user = $lastname_user;

        return $this;
    }

    /**
     * Get the value of email_user
     */
    public function getEmail_user()
    {
        return $this->email_user;
    }

    /**
     * Set the value of email_user
     *
     * @return  self
     */
    public function setEmail_user($email_user)
    {
        $this->email_user = $email_user;

        return $this;
    }

    /**
     * Get the value of password_user
     */
    public function getPassword_user()
    {
        return $this->password_user;
    }

    /**
     * Set the value of password_user
     *
     * @return  self
     */
    public function setPassword_user($password_user)
    {
        $password_user = password_hash($password_user, PASSWORD_DEFAULT);
        $this->password_user = $password_user;

        return $this;
    }

    /**
     * Get the value of typer_user
     */
    public function getType_user()
    {
        return $this->type_user;
    }

    /**
     * Set the value of typer_user
     *
     * @return  self
     */
    public function setType_user($type_user)
    {
        $this->type_user = $type_user;

        return $this;
    }

    /**
     * Get the value of isDeleted
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set the value of isDeleted
     *
     * @return  self
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        return $this;
    }

    /**
     * Get the value of token_user
     */
    public function getToken_user()
    {
        return $this->token_user;
    }

    /**
     * Set the value of token_user
     *
     * @return  self
     */
    public function setToken_user($token_user)
    {
        $this->token_user = $token_user;

        return $this;
    }



    /**
     * Get the value of isverified_user
     */
    public function getIsverified_user()
    {
        return $this->is_verified_user;
    }

    /**
     * Set the value of isverified_user
     *
     * @return  self
     */
    public function setIsverified_user($isverified_user)
    {
        $this->is_verified_user = $isverified_user;

        return $this;
    }

    public function countUsers(): int
    {
        return $this->countRows();
    }

    public function findAllAdmins(): array
    {
        return $this->findAllBy(['type_user' => 'admin'], 'object');
    }

    public function delete(): bool
    {
        // Soft delete : mettre à jour is_deleted à true
        $this->setIsDeleted(true);

        // Sauvegarder les modifications (soft delete)
        return $this->save();
    }

     /**
     * Get the number of users grouped by month based on the inserted_at field.
     */
    public function getUserRegistrationsByMonth(): array
    {
        return $this->getCountByMonth('inserted_at');
    }

    public function countUsersByRole(): array
{
    $sql = "SELECT type_user, COUNT(*) as count FROM " . $this->getTable() . " WHERE is_deleted = false GROUP BY type_user";
    $queryPrepared = $this->pdo->prepare($sql);
    $queryPrepared->execute();
    return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
}

// anonymize a user
public function anonymize(): bool
{
    $this->setFirstname_user("Anonyme");
    $this->setLastname_user("Anonyme");
    $this->setEmail_user("anonyme" . $this->getId() . "@anonyme.com");
    $this->setIsverified_user(false);
    $this->setType_user("viewer");

    return $this->save();

}


}


