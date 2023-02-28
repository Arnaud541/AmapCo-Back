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
}
