<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/_src/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/utils.php';

function login($username , $password) {
    $conn = db_connect();
    $prp = $conn->prepare("SELECT * FROM users u WHERE u.email like ?");
    $prp->execute([$username]);
    $result = $prp->fetch(PDO::FETCH_ASSOC);
    if (empty($result)) return false;
    if ($result['passwd'] != $password) return false;
    return $result;
}

function createUser($email, $password, $firstname, $lastname, $role = 'USER') {
    $conn = db_connect();
    $prp = $conn->prepare(
        "INSET INTO users (firstname, lastname, email, passwd, roles) VALUES (?,?,?,?,?)"
    );
    try {
        $prp->execute([$firstname, $lastname, $email, $password, $role]);
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

function getUserByEmail($email) {

}


function checkEmail() {
    if (empty($_POST['email'])) return ['code' => 400, 'message' => 'Email is missing', 'pass' => false];
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return ['code' => 400, 'message' => 'Invalid Email format', 'pass' => false];
    // Check if unique
    $conn = db_connect();
    $prp = $conn->prepare("SELECT * FROM users u WHERE u.email like ?");
    $prp->execute([$email]);
    $result = $prp->fetch(PDO::FETCH_ASSOC);
    if (!empty($result)) return ['code' => 400, 'message' => 'Email already exists', 'pass' => false];
    return ['code' => 200, 'message' => 'Email valid', 'pass' => true];
}

function checkName($key, $max_length = 100, $min_length = 0, $numbers_allowed = false) {
    // first or last name
    if (empty($_POST[$key])) return ['code' => 400, 'message' =>  $key.' is missing', 'valid' => false];
    $key_val = $_POST[$key];
    if (!$numbers_allowed && contains_numbers($key_val)) return ['code' => 400, 'message' =>  "$key is numeric", 'valid' => false];
    if (count($key_val) < $min_length) return ['code' => 400, 'message' =>  "$key length less than $min_length", 'valid' => false];
    if (count($key_val) > $max_length) return ['code' => 400, 'message' =>  "$key length greater than $max_length", 'valid' => false];
    return ['code' => 200, 'message' =>  "$key is valid", 'valid' => true];
}