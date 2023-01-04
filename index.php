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
                    $data = json_decode(file_get_contents("php://input"));
                    (new RecipeController)->get($data);
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new RecipeController)->insertRecipe($data);
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
                    (new UserController)->insertUser($data);
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
                    (new GrowerController)->insertGrower($data);
                    break;
            }
            break;
        case 'producercart':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new ProducerCartController)->getAll();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new ProducerCartController)->insertProducerCart($data);
                    break;
            }
            break;
        case 'subscriptioncart':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new SubscriptionCartController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new SubscriptionCartController)->insertSubscriptionCart($data);
                    break;
            }
            break;
        case 'comments':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new CommentsController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new CommentsController)->insertComments($data);
                    break;
            }
            break;
        case 'responsecomments':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new ResponseCommentsController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new ResponseCommentsController)->insertResponseComments($data);
                    break;
            }
            break;
        case 'growernote':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new GrowerNoteController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new GrowerNoteController)->insertGrowerNote($data);
                    break;
            }
            break;
        case 'recipenote':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new RecipeNoteController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new RecipeNoteController)->insertRecipeNote($data);
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
                    (new ProductController)->insertProduct($data);
                    break;
            }
            break;
        case 'ingredient':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new IngredientController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new IngredientController)->insertIngredient($data);
                    break;
            }
            break;   
        case 'steps':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new StepsController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new StepsController)->insertSteps($data);
                    break;
            }
            break;
        case 'ustensils':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    (new UstensilsController)->get();
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents("php://input"));
                    (new UstensilsController)->insertUstensils($data);
                    break;
            }
            break; 
    }
} 
else {
    $response = ['status' => 200, 'message' => 'Erreur d\'accès à l\'API'];
    echo json_encode($response);
}
