<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use AMAP\Controller\AuthenticationController;
use AMAP\Controller\UserController;
use AMAP\Controller\StepsController;
use AMAP\Controller\GrowerController;
use AMAP\Controller\RecipeController;
use AMAP\Controller\ProductController;
use AMAP\Controller\CommentsController;
use AMAP\Controller\UstensilsController;
use AMAP\Controller\GrowerNoteController;
use AMAP\Controller\IngredientController;
use AMAP\Controller\RecipeNoteController;
use AMAP\Controller\ProducerCartController;
use AMAP\Controller\ResponseCommentsController;
use AMAP\Controller\SubscriptionCartController;

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
                    (new RecipeController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new RecipeController)->insert($data);
                    break;
            }
            break;
        case 'allIngredients':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new IngredientController)->get();
                    break;
            }
            break;
        case 'allUstensils':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new UstensilsController)->get();
            }
        case 'recipeById':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getById();
                    break;
            }
            break;
        case 'recipeSearch':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getBySearch();
                    break;
            }
            break;
        case 'user':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new UserController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new UserController)->insert($data);
                    break;
            }
            break;
        case 'loginUser':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new UserController)->login();
                    break;
            }
            break;
        case 'grower':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new GrowerController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new GrowerController)->insert($data);
                    break;
            }
            break;
        case 'producerCart':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new ProducerCartController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new ProducerCartController)->insert($data);
                    break;
            }
            break;
        case 'signIn':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new AuthenticationController)->login($data);
                    break;
            }
            break;
        case 'signUp':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new AuthenticationController)->insert($data);
                    break;
            }
            break;
        case 'subscription':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new SubscriptionCartController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    // (new SubscriptionCartController)->insert($data);
                    break;
            }
            break;
        case 'comments':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getComments();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new CommentsController)->insert($data);
                    break;
            }
            break;
        case 'responseComments':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new ResponseCommentsController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new ResponseCommentsController)->insert($data);
                    break;
            }
            break;
        case 'growerNote':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new GrowerNoteController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new GrowerNoteController)->insert($data);
                    break;
            }
            break;
        case 'recipeNote':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getNote();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new RecipeNoteController)->insert($data);
                    break;
            }
            break;
        case 'product':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new ProductController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new ProductController)->insert($data);
                    break;
            }
            break;
        case 'ingredient':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getIngredients();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new IngredientController)->insert($data);
                    break;
            }
            break;

        case 'steps':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getSteps();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new StepsController)->insert($data);
                    break;
            }
            break;

        case 'ustensils':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeController)->getUstensils();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new UstensilsController)->insert($data);
                    break;
            }
            break;
        case 'growerbyid':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new GrowerController)->getById();
                    break;
            }
            break;
        case 'growercart':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new GrowerController)->getGrowerCart();
                    break;
            }
            break;
        case 'growerNoteById':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new GrowerNoteController)->getNote($_GET["id_producteur"]);
                    break;
            }
            break;
    }
} else {
    $response = ['status' => 200, 'message' => 'Erreur d\'accès à l\'API'];
    echo json_encode($response);
}
