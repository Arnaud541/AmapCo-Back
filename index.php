<?php

use AMAP\Database\DbConnect;
use AMAP\Recettes\Recettes;

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Content-type:application/json");

$db = new DbConnect();

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case 'recette':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    Recettes::getRecherche();
                    break;
                case 'POST':
                    Recettes::postRecherche();
                    break;
            }
            break;
    }
}
