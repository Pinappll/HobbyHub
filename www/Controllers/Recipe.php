<?php

namespace App\Controllers;

use App\Core\View;

class Recipe
{

    public function createRecipe(): void
    {
        $myView = new View("Recipe/createRecipe", "front");
    }
    public function readRecipe(): void
    {
        $myView = new View("Recipe/readRecipe", "front");
    }
    public function updateRecipe(): void
    {
        $myView = new View("Recipe/updateRecipe", "front");
    }
    public function deleteRecipe(): void
    {
        $myView = new View("Recipe/deleteRecipe", "front");
    }
    public function recipes(): void
    {
        $myView = new View("Recipe/recipes", "front");
    }
    public function singleRecipe(): void
    {
        $myView = new View("Recipe/single-recipe", "front");
    }
    public function showRecipies(): void
    {
        $myView = new View("Admin/recipies", "back");
    }
}