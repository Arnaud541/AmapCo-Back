<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class GrowerModel
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
        $request = "SELECT * FROM Producteur";
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
        $request = "INSERT INTO Producteur (email, nom, prenom, avatar, region, adresse, codePostal) VALUES (:email,:nom,:prenom,:avatar,:region,:adresse,:codePostal)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':email', $data->email, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $data->nom, PDO::PARAM_STR);
        $stmt->bindParam(":prenom" , $data->prenom, PDO::PARAM_STR);
        $stmt->bindParam(":avatar" , $data->avatar, PDO::PARAM_STR);
        $stmt->bindParam(":region" , $data->region, PDO::PARAM_STR);
        $stmt->bindParam(":adresse" , $data->adresse, PDO::PARAM_STR);
        $stmt->bindParam(":codePostal" , $data->codePostal, PDO::PARAM_STR);
        return $stmt->execute([$data->email, $data->nom, $data->prenom, $data->avatar,$data->region,$data->adresse,$data->codePostal]);
    }
}
