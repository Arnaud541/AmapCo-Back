<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class ProductModel
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
        $request = "SELECT * FROM Produit";
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

    public function insert($data)
    {
        $request = "INSERT INTO Produit (id_ingredient, quantite) VALUES (:id_utilisateur,:quantite)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_ingredient', $data->id_ingredient, PDO::PARAM_INT);
        $stmt->bindParam(':quantite', $data->quantite, PDO::PARAM_STR);
        return $stmt->execute([$data->id_ingredient, $data->quantite]);
    }
}
