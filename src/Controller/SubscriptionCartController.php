<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\SubscriptionCartModel;

class SubscriptionCartController
{
    public function getSubVerification()
    {
        if (isset($_GET["id_panier"]) && isset($_GET["id_utilisateur"])) {
            $data = (new SubscriptionCartModel)->getSubVerification($_GET["id_panier"], $_GET["id_utilisateur"]);
            $response = ['status' => 200, 'sub' => $data];
            echo json_encode($response);
        }
    }

    public function insert($data)
    {
        if ((new SubscriptionCartModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "L'abonnement a bien été enregistré"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de l'abonnement a échoué"];
        }
        echo json_encode($response);
    }
}
