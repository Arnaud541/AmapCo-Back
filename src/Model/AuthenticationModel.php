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
        $stmt = $this->pdo->prepare("SELECT id, CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS nom, avatar, created_at, regimeAlimentaire, acces, password FROM Utilisateur WHERE email = :email");
        $stmt->bindParam('email', $data->user->email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && md5($data->user->password) === $user["password"]) {
            unset($user["password"]);
            return $user;
        }

        if (!$user) {

            $stmt2 = $this->pdo->prepare("SELECT id, CONCAT(Producteur.nom, ' ', Producteur.prenom) AS nom, avatar, created_at, description, acces, password FROM Producteur WHERE email = :email");
            $stmt2->bindParam(':email', $data->user->email, PDO::PARAM_STR);
            $stmt2->execute();
            $grower = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($grower && md5($data->user->password) === $grower["password"]) {
                unset($grower["password"]);
                return $grower;
            }
        }
    }

    public function insert($data)
    {
        $insert = false;
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email=:email");
        $stmt->bindParam(':email', $data->user->email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            $insert = false;
        } else {
            if (!$user && $data->user->password === $data->user->confirmPassword) {
                $password = md5($data->user->password);
                $request = "INSERT INTO Utilisateur (email, nom, prenom, description, password) VALUES (:email, :nom, :prenom, :description, :password)";
                $stmt = $this->pdo->prepare($request);
                $stmt->bindParam(':email', $data->user->email, PDO::PARAM_STR);
                $stmt->bindParam(':nom', $data->user->lastname, PDO::PARAM_STR);
                $stmt->bindParam(":prenom", $data->user->firstname, PDO::PARAM_STR);
                $stmt->bindParam(":description", $data->user->description, PDO::PARAM_STR);
                $stmt->bindParam(":password", $password, PDO::PARAM_STR);
                $insert = $stmt->execute();
            }
        }
        return $insert;
    }
}
