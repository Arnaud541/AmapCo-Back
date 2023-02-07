<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\RecipeNoteModel;

class RecipeNoteController
{
    public function get()
    {
        $data = (new RecipeNoteModel)->getAll();
        $response = ['status' => 200, 'recipeNote' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new RecipeNoteModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "La note a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la note a échoué"];
        }
        echo json_encode($response);
    }
}
