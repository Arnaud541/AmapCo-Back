<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\IngredientModel;

class IngredientController
{
    public function get()
    {
        $data = (new IngredientModel)->getAll();
        $response = ['status' => 200, 'commentaires' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new IngredientModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le commentaire a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de le commentaire a échoué"];
        }
        echo json_encode($response);
    }
}
