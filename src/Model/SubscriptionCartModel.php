<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class SubscriptionCartModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new DbConnect)->connect();
    }

    public function getAll()
    {
        $params = [];
        if (isset($_GET['params'])) {
            foreach ($_GET['params'] as $param => $value) {
                $params[$param] = $value;
            }
        }
        $request = "SELECT * FROM AbonnementPanier";
        $firstLoop = false;
        foreach ($params as $param => $value) {
            if ($firstLoop == true) {
                $request = $request . " AND ";
            } else {
                $request = $request . " WHERE ";
            }
            $request = $request . $param . " = :" . $param;
            $firstLoop = true;
        }
        $stmt = $this->pdo->prepare($request);
        foreach ($params as $param => $value) {
            $stmt->bindParam(":" . $param, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function insert($data)
    // {
    //     $request = "INSERT INTO AbonnementPanier (id_panier, id_utilisateur, dateDebut, dateFin) VALUES (:id_panier, :id_utilisateur, :dateDebut, :dateFin)";
    //     $stmt = $this->pdo->prepare($request);
    //     $stmt->bindParam(':id_panier', $data->id_panier, PDO::PARAM_STR);
    //     $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_STR);
    //     $stmt->bindParam(":dateDebut" , $data->dateDebut, PDO::PARAM_STR);
    //     $stmt->bindParam(":dateFin" , $data->dateFin, PDO::PARAM_STR);
    //     return $stmt->execute([$data->id_panier, $data->id_utilisateur, $data->dateDebut, $data->dateFin]);
    // }
}
