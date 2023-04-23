<?php

function pre_dump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function contains_numbers($str) {
    return preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $str);
}
