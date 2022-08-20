<?php
require_once("database.php");

header('Cache-Control: no-cache');
header('Content-Type: application/json; charset=utf-8');

Database::init();

http_response_code(200);
echo json_encode(Database::list());
