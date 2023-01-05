<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\UserModel;

class UserController
{
    public function get()
    {
        $data = (new UserModel)->getAll();
        $response = ['status' => 200, 'User' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new UserModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le user a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement du user a échoué"];
        }
        echo json_encode($response);
    }
}
