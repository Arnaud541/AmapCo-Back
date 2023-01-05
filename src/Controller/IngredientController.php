<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\IngredientModel;

class IngredientController
{
    public function get()
    {
        $data = (new IngredientModel)->getAll();
        $response = ['status' => 200, 'ingredient' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new IngredientModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "L ingredient a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de l ingredient a échoué"];
        }
        echo json_encode($response);
    }
}
