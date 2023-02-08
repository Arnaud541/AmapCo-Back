<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\AuthenticationModel;

class AuthenticationController
{
    public function insert($data)
    {
        if ((new AuthenticationModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "L'utilisateur a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement a échoué"];
        }
        echo json_encode($response);
    }
    public function login($data)
    {
        if ((new AuthenticationModel)->login($data)) {
            $response = ['status' => 200, 'message' => "Connexion réussie"];
        } else {
            $response = ['status' => 400, 'message' => "Connexion échouée"];
        }
        echo json_encode($response);
    }
}
