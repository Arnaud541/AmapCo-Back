<?php

namespace AMAP\Database;

use PDO;

class DbConnect
{
    private $host = "sql966.main-hosting.eu";
    private $dbname = "u560558504_amap";
    private $user = "u560558504_amap";
    private $password = "8Um05T&tdB";

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
