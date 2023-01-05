<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new DbConnect)->connect();
    }

    // public function getAll()
    // {
    //     $request = "SELECT * FROM Recipe";
    //     $stmt = $this->pdo->query($request);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getAll()
    {
        $params = [];
        if (isset($_GET['params'])) {
            foreach ($_GET['params'] as $param => $value) {
                $params[$param] = $value;
            }
        }
        $request = "SELECT * FROM Utilisateur";
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
        //echo $request;
        $stmt = $this->pdo->prepare($request);
        foreach ($params as $param => $value) {
            //echo "<br>".$param.":".$value;
            $stmt->bindParam(":" . $param, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $request = "INSERT INTO Recipe (title, description, photo) VALUES (?,?,?)";
        $stmt = $this->pdo->prepare($request);
        return $stmt->execute([$data->title, $data->description, $data->photo]);
    }
}
