<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\RecipeModel;

class RecipeController
{
    public function Get()
    {
        if (isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                case "regime":
                    $recipes = (new RecipeModel)->getByRegime($_GET['param']);
                    $response = ['status' => 200, 'recettes' => $recipes];
                    echo json_encode($response);
                    break;
                case "difficulty"
                    $recipes = (new RecipeModel)->getByDifficulty($_GET['param']);
                    $response = ['status' => 200, 'recettes' => $recipes];
                    echo json_encode($response);
                    break;
            }
        } else {
            $recipes = (new RecipeModel)->getAll();
            $response = ['status' => 200, 'recettes' => $recipes];
            echo json_encode($response);
        }
    }

    public function insertRecipe($data)
    {
        if ((new RecipeModel)->insertRecipe($data)) {
            $response = ['status' => 200, 'message' => "La recette à bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la recette a échoué"];
        }

        echo json_encode($response);
    }
}
