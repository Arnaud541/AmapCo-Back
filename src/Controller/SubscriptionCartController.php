<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\SubscriptionCartModel;

class SubscriptionCartController
{
    public function get()
    {
        $data = (new SubscriptionCartModel)->getAll();
        $response = ['status' => 200, 'aboPanier' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new SubscriptionCartModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "L abonnement a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de l abonnement a échoué"];
        }
        echo json_encode($response);
    }
}
