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
    protected string $type_user = "customer";
    protected string $token_user;
    protected bool $isDeleted;
    protected bool $isverified_user;


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
    public function setType_user($typer_user)
    {
        $this->type_user = $typer_user;

        return $this;
    }

    /**
     * Get the value of isDeleted
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set the value of isDeleted
     *
     * @return  self
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

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
        return $this->isverified_user;
    }

    /**
     * Set the value of isverified_user
     *
     * @return  self
     */
    public function setIsverified_user($isverified_user)
    {
        $this->isverified_user = $isverified_user;

        return $this;
    }
}
