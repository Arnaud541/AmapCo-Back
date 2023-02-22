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

    public function getSimilarRecipe($recipe)
    {
        $recipes = (new RecipeModel)->getSimilarRecipe($recipe);
        $response = ['status' => 200, 'recettes' => $recipes];
        echo json_encode($response);
    }

    public function getSimilarRecipeCart($cart)
    {
        $recipes = (new RecipeModel)->getSimilarRecipeCart($cart);
        $response = ['status' => 200, 'recettes' => $recipes];
        echo json_encode($response);
    }

    public function deleteRecipeById($data)
    {
        $success = (new RecipeModel)->deleteRecipeById($data);
        if ($success) {
            $response = ['status' => 200, 'success' => $success, 'message' => 'La suppression à bien été effectuée'];
        } else {
            $response = ['status' => 400, 'success' => $success, 'message' => 'La suppression à échoué'];
        }
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

    public function update($data)
    {
        if ((new RecipeModel)->update($data)) {
            $response = ['status' => 200, 'message' => "La recette a bien été modifié"];
        } else {
            $response = ['status' => 400, 'message' => "La modification de la recette a échouée"];
        }
        echo json_encode($response);
    }

    public function getFavorite()
    {
        if (isset($_GET["id_recipe"]) && isset($_GET["id_user"])) {
            $data = (new RecipeModel)->getFavorite($_GET["id_recipe"], $_GET["id_user"]);
            $response = ['status' => 200, 'favorite' => $data];
            echo json_encode($response);
        }
    }

    public function getRecipeFavoriteByUser()
    {
        if (isset($_GET["id_user"])) {
            $data = (new RecipeModel)->getRecipeFavoriteByUser($_GET["id_user"]);
            $response = ['status' => 200, 'recipes' => $data];
            echo json_encode($response);
        }
    }

    public function deleteFavorite($data)
    {

        $data = (new RecipeModel)->deleteFavorite($data);
        if ($data) {
            $response = ['status' => 200, 'message' => "La recette a été enlevé de vos favoris."];
        } else {
            $response = ['status' => 400, 'message' => "La recette est toujours en favoris."];
        }

        echo json_encode($response);
    }

    public function insertFavorite($data)
    {
        $data = (new RecipeModel)->insertFavorite($data);
        if ($data) {
            $response = ['status' => 200, 'message' => "La recette a été ajouté à vos favoris."];
        } else {
            $response = ['status' => 400, 'message' => "L'ajout de la recette à vos favoris a échoué."];
        }

        echo json_encode($response);
    }
}
