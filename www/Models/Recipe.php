<?php

namespace App\Models;

use App\Core\DB;

class Recipe extends DB
{
    private ?int $id = null;
    protected int $id_user_recipe;
    protected string $title_recipe;
    protected string $ingredient_recipe;
    protected string $instruction_recipe;
    protected string $image_url_recipe;
    protected bool $is_deleted;


    public function __construct()
    {
        parent::__construct();
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
     * Get the value of id_user_recipe
     */
    public function getId_user_recipe()
    {
        return $this->id_user_recipe;
    }

    /**
     * Set the value of id_user_recipe
     *
     * @return  self
     */
    public function setId_user_recipe($id_user_recipe)
    {
        $this->id_user_recipe = $id_user_recipe;

        return $this;
    }

    /**
     * Get the value of title_recipe
     */
    public function getTitle_recipe()
    {
        return $this->title_recipe;
    }

    /**
     * Set the value of title_recipe
     *
     * @return  self
     */
    public function setTitle_recipe($title_recipe)
    {
        $this->title_recipe = $title_recipe;

        return $this;
    }

    /**
     * Get the value of ingredient_recipe
     */
    public function getIngredient_recipe()
    {
        return $this->ingredient_recipe;
    }

    /**
     * Set the value of ingredient_recipe
     *
     * @return  self
     */
    public function setIngredient_recipe($ingredient_recipe)
    {
        $this->ingredient_recipe = $ingredient_recipe;

        return $this;
    }

    /**
     * Get the value of instruction_recipe
     */
    public function getInstruction_recipe()
    {
        return $this->instruction_recipe;
    }

    /**
     * Set the value of instruction_recipe
     *
     * @return  self
     */
    public function setInstruction_recipe($instruction_recipe)
    {
        $this->instruction_recipe = $instruction_recipe;

        return $this;
    }

    /**
     * Get the value of image_url_recipe
     */
    public function getImage_url_recipe()
    {
        return $this->image_url_recipe;
    }

    /**
     * Set the value of image_url_recipe
     *
     * @return  self
     */
    public function setImage_url_recipe($image_url_recipe)
    {
        $this->image_url_recipe = $image_url_recipe;

        return $this;
    }
    public function isDeleted()
    {
        return $this->is_deleted;
    }
    public function setDeleted(bool $isDeleted)
    {
        $this->is_deleted = $isDeleted;
    }
    // private function getRecipeByIdCategory(int $id_category)
    // {

    //     // $sql = "SELECT * FROM easycook_recipe inner join easycook_recipe_category on easycook_recipe.id = easycook_recipe_category.id where easycook_recipe_category.id = :id_category";
    //     // $queryPrepared = $this->pdo->prepare($sql);

    //     // $this->id = $this->pdo->lastInsertId();
    // }
    public function getRecipeByIdCategory(int $id_category)
    {
        $sql = "SELECT * FROM easycook_recipe inner join easycook_recipe_category on easycook_recipe.id = easycook_recipe_category.id where easycook_recipe_category.id = :id_category";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindValue(":id_category", $id_category, \PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }
}
