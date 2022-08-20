<?php
require_once("database.php");
require_once("model.php");

header('Cache-Control: no-cache');
header('Content-Type: application/json; charset=utf-8');

$content = json_decode(file_get_contents('php://input'), true);

$model = new Point();
$model->username = $content['username'];
$model->latitude = $content['latitude'];
$model->longitude = $content['longitude'];
$model->accuracy = $content['accuracy'];

Database::init();

if (Database::save($model)) {
    http_response_code(200);
    echo json_encode(true);
} else {
    http_response_code(500);
}
