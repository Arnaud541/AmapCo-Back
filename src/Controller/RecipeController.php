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

    public function insert($data)
    {
        if ((new RecipeModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Arnaud je te chies dessus compris"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la recette a échoué"];
        }
        echo json_encode($response);
    }
}
