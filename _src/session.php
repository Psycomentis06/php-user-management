<?php

function flash_session_add($key,  $obj)
{
    $_SESSION['flash'][$key] = $obj;
}

function flash_session_read($key) {
    if (!empty($_SESSION['flash']) && array_key_exists($key, $_SESSION['flash'])) {
        $flash_obj = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash_obj;
    }
    return  [];
}