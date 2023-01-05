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

    public function insertRecipe($data)
    {
        if ((new RecipeModel)->insertRecipe($data)) {
            $response = ['status' => 200, 'message' => "La recette a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la recette a échoué"];
        }
        echo json_encode($response);
    }
}
