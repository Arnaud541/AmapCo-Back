<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class AuthenticationModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new DbConnect)->connect();
    }

    public function login($data)
    {
        $password = md5($data->password);
        var_dump($data->password);
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email AND password = :pwd");
        $stmt->bindParam('email', $data->email, PDO::PARAM_STR);
        $stmt->bindParam('pwd', $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? true : false;
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
}
