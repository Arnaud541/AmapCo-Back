<?php

namespace AMAP\Database;

use PDO;

class DbConnect
{
    private $host = "localhost";
    private $dbname = "amap";
    private $user = "root";
    private $password = "root";

    public function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8', $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            echo "Erreur de connexion à la base de données" . $e->getMessage();
        }
    }
}
