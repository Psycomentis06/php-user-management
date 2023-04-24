<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/_src/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/utils.php';

function login($username , $password) {
    $user = getUserByEmail($username);
    if (empty($user)) return false;
    if ($user['passwd'] != $password) return false;
    return $user;
}

function logout() {
    unset($_SESSION['user']);
    unset($_COOKIE['user']);
}

function is_logged_in()
{
    if (isset($_SESSION['user']))
        return true;
    else {
        if (isset($_COOKIE['user'])) {
            $user = getUserById($_COOKIE['user']);
            if (!empty($user)) {
                $_SESSION['user'] = $user;
                return true;
            }
        }
    }
    return false;
}

function create_user($email, $password, $firstname, $lastname, $role = 'USER') {
    $conn = db_connect();
    $prp = $conn->prepare(
        "INSERT INTO users (firstname, lastname, email, passwd, roles) VALUES (?,?,?,?,?)"
    );
    try {
        $prp->execute([$firstname, $lastname, $email, $password, $role]);
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

function getUserByEmail($email) {
    $conn = db_connect();
    $prp = $conn->prepare("SELECT id, passwd, firstname, lastname, email, roles, activatedAt FROM users u WHERE u.email like ?");
    $prp->execute([$email]);
    return $prp->fetch(PDO::FETCH_ASSOC);
}

function getUserById($id) {
    $conn = db_connect();
    $prp = $conn->prepare("SELECT id, passwd, firstname, lastname, email, roles, activatedAt FROM users u WHERE u.id = ?");
    $prp->execute([$id]);
    return $prp->fetch(PDO::FETCH_ASSOC);
}



function check_email() {
    if (empty($_POST['email'])) return ['code' => 400, 'message' => 'Email is missing', 'valid' => false];
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return ['code' => 400, 'message' => 'Invalid Email format', 'valid' => false];
    // Check if unique
    $conn = db_connect();
    $prp = $conn->prepare("SELECT * FROM users u WHERE u.email like ?");
    $prp->execute([$email]);
    $result = $prp->fetch(PDO::FETCH_ASSOC);
    if (!empty($result)) return ['code' => 400, 'message' => 'Email already exists', 'valid' => false];
    return ['code' => 200, 'message' => 'Email valid', 'valid' => true];
}

function check_name($key, $max_length = 100, $min_length = 3, $numbers_allowed = false) {
    // first or last name
    if (empty($_POST[$key])) return ['code' => 400, 'message' =>  $key.' is missing', 'valid' => false];
    $key_val = $_POST[$key];
    if (!$numbers_allowed && contains_numbers($key_val)) {
        return ['code' => 400, 'message' =>  "$key is numeric", 'valid' => false];
    }
    if (strlen($key_val) < $min_length) return ['code' => 400, 'message' =>  "$key length less than $min_length", 'valid' => false];
    if (strlen($key_val) > $max_length) return ['code' => 400, 'message' =>  "$key length greater than $max_length", 'valid' => false];
    return ['code' => 200, 'message' =>  "$key is valid", 'valid' => true];
}

function check_password() {
    $chk_name = check_name('password', 16, 8, true);
    if (!$chk_name['valid']) return $chk_name;
    return  ['code' => 200,'message' =>  "password is valid", 'valid' => true];
}