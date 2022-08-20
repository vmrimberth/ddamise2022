<?php
require_once("database.php");

header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache');
header('Content-Type: application/json; charset=utf-8');

Database::init();

switch ($_GET['type']) {
    case 'users': {
            $response = Database::listUsers();
            break;
        }
    case 'points': {
            $response = Database::listPoints($_GET['username']);
            break;
        }
    default: {
            $response = Database::list();
            break;
        }
}

http_response_code(200);
echo json_encode($response ?? []);
