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

    public function getById()
    {
        if (isset($_GET["id"])) {
            $data = (new UserModel)->getById($_GET["id"]);
            $response = ['status' => 200, 'user' => $data];
            echo json_encode($response);
        }
    }

    public function insert($data)
    {
        if ((new UserModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "L'utilisateur a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement a échoué"];
        }
        echo json_encode($response);
    }
}
