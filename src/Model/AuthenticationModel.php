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
        $email = $data->user->email;
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            return false;
        } else {
            $request = "INSERT INTO Utilisateur (email, nom, prenom, avatar, password) VALUES (:email, :nom, :prenom, :avatar, :password)";
            $stmt = $this->pdo->prepare($request);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $data->user->lastName, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $data->user->firstName, PDO::PARAM_STR);
            $stmt->bindParam(":avatar", $data->user->profilePicture, PDO::PARAM_STR);
            $stmt->bindParam(":password", $data->user->password, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
    }
}
