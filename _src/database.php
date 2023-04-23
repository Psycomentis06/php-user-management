<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/env_file.php';

$connection = null;

function db_connect() {
    global $connection;
    if ($connection != null) {
       return $connection;
    }
    $cred = loadConfig();
    if (empty($cred)) {
        die('Config file is missing');
    }
    $username = $cred['db_username'];
    $password = $cred['db_password'];
    $host = $cred['db_host'];
    $db_name = $cred['db_name'];
    try {
        $connection = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    return $connection;
}


