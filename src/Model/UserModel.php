<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;
use AMAP\Exceptions\AuthentificationException;

class UserModel
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
        $stmt = $this->pdo->prepare($request);
        foreach ($params as $param => $value) {
            $stmt->bindParam(":" . $param, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $email = $data->email;
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            return false;
        } else {
            $request = "INSERT INTO Utilisateur (email, nom, prenom, avatar, regimeAlimentaire, password) VALUES (:email, :nom, :prenom, :avatar, :regimeAlimentaire, :password)";
            $stmt = $this->pdo->prepare($request);
            $stmt->bindParam(':email', $data->email, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $data->nom, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $data->prenom, PDO::PARAM_STR);
            $stmt->bindParam(":avatar", $data->avatar, PDO::PARAM_STR);
            $stmt->bindParam(":regimeAlimentaire", $data->regimeAlimentaire, PDO::PARAM_STR);
            $stmt->bindParam(":password", $data->password, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
    }

    public function getById($id)
    {
        $request = "SELECT id, CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS nom, avatar, created_at, regimeAlimentaire FROM Utilisateur WHERE id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : null;
    }
}
