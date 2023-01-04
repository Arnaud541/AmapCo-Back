<?php

namespace AMAP\Recettes;

use PDO;
use AMAP\Database\DbConnect;


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Content-type:application/json");



class Recettes
{

    public static function getRecherche()
    {
        $db = new DbConnect();
        $conn = $db->connect();

        if ($_GET["recherche"]["filtres"]) {
            $request = "SELECT * FROM recettes WHERE CONCAT(nom,description) LIKE '%" . $_GET["recherche"]["recherche"] . "%' AND ";
            $filtres = [];
            foreach ($_GET["recherche"]["filtres"] as $key => $values) {
                foreach ($values as $value) {
                    $t = $key . " = " . "'" . $value . "'";
                    array_push($filtres, $t);
                }
            }
            $t2 = implode(" AND ", $filtres);
            $request .= $t2;
            $stmt = $conn->query($request);
            $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $request = "SELECT * FROM recettes WHERE CONCAT(nom,description) LIKE '%" . $_GET["recherche"]["recherche"] . "%'";
            $stmt = $conn->query($request);
            $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $response = ['status' => 200, 'recettes' => $recettes];
        echo json_encode($response);
    }

    public static function postRecherche()
    {
        $db = new DbConnect();
        $conn = $db->connect();

        $data = json_decode(file_get_contents("php://input"));

        if ($data->filtres) {

            $request = "SELECT * FROM recettes WHERE CONCAT(nom,description) LIKE '%" . $data->recherche . "%' AND ";
            $filtres = [];
            foreach ($data->filtres as $key => $values) {
                foreach ($values as $value) {
                    $t = $key . " = " . "'" . $value . "'";
                    array_push($filtres, $t);
                }
            }
            $t2 = implode(" AND ", $filtres);
            $request .= $t2;
            $stmt = $conn->query($request);
            $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $request = "SELECT * FROM recettes WHERE CONCAT(nom,description) LIKE '%" . $data->recherche . "%'";
            $stmt = $conn->query($request);
            $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $response = ['status' => 200, 'recettes' => $recettes];
        echo json_encode($response);
    }
}
