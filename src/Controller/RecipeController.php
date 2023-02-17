<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\RecipeModel;

class RecipeController
{
    public function get()
    {
        $recipes = (new RecipeModel)->getAll();
        $response = ['status' => 200, 'recettes' => $recipes];
        echo json_encode($response);
    }

    public function getById()
    {
        if (isset($_GET["id"])) {
            $recipe = (new RecipeModel)->getById($_GET["id"]);
            $response = ['status' => 200, 'recette' => $recipe];
            echo json_encode($response);
        }
    }

    public function getComments()
    {
        if (isset($_GET["id"])) {
            $data = (new RecipeModel)->getComments($_GET["id"]);
            $response = ['status' => 200, 'commentaires' => $data];
            echo json_encode($response);
        }
    }

    public function getUstensils()
    {
        if (isset($_GET["id"])) {
            $data = (new RecipeModel)->getUstensils($_GET["id"]);
            $response = ['status' => 200, 'ustensils' => $data];
            echo json_encode($response);
        }
    }

    public function getIngredients()
    {
        if (isset($_GET["id"])) {
            $data = (new RecipeModel)->getIngredients($_GET["id"]);
            $response = ['status' => 200, 'ingredients' => $data];
            echo json_encode($response);
        }
    }

    public function getSteps()
    {
        if (isset($_GET["id"])) {
            $data = (new RecipeModel)->getSteps($_GET["id"]);
            $response = ['status' => 200, 'steps' => $data];
            echo json_encode($response);
        }
    }

    public function getNote()
    {
        if (isset($_GET["id"])) {
            $data = (new RecipeModel)->getNote($_GET["id"]);
            $response = ['status' => 200, 'note' => $data];
            echo json_encode($response);
        }
    }

    public function getBySearch()
    {
        $recipes = (new RecipeModel)->getBySearch();
        $response = ['status' => 200, 'recettes' => $recipes];
        echo json_encode($response);
    }

    public function getRecipesByIdUser()
    {
        if (isset($_GET["id"])) {
            $recipes = (new RecipeModel)->getRecipesByIdUser($_GET["id"]);
            $response = ['status' => 200, 'recipes' => $recipes];
            echo json_encode($response);
        }
    }

    public function getAssociatedRecipes()
    {
        $recipes = (new RecipeModel)->getAssociatedRecipes();
        // $response = ['status' => 200, 'recipes' => $recipes];
        // echo json_encode($response);
    }

    public function getSimilarRecipe($recipe)
    {
        $recipes = (new RecipeModel)->getSimilarRecipe($recipe);
        $response = ['status' => 200, 'recettes' => $recipes];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new RecipeModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "La recette a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la recette a échouée"];
        }
        echo json_encode($response);
    }
}
