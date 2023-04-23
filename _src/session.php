<?php

function flash_session_add($key,  $obj)
{
    $_SESSION['flash'][$key] = $obj;
}

function flash_session_read($key) {
    $obj = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $obj;
}