<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use AMAP\Controller\RecipeController;

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Content-type:application/json");

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case 'recipe':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getAll();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new RecipeController)->insertRecipe($data);
                    break;
            }
            break;
    }
} else {
    $response = ['status' => 200, 'message' => 'Erreur d\'accès à l\'API'];
    echo json_encode($response);
}
