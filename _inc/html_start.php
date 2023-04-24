<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/user.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">-->
    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <!-- MDB -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="<?php echo get_server_address() . '/style/style.css' ?>">
    <title>
        <?php echo $html_title ?? 'Title' ?>
    </title>
</head>
<body>
<?php

if (is_logged_in()) {
    $user = getUserById($_SESSION['user']['id']);
    if (!empty($user)) {
        if (empty($user['activatedAt']))
            echo '<p class="alert alert-warning">Please activate your account via the link sent to your E-mail.</p>';
    }
}