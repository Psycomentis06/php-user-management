<?php

function pre_dump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function contains_numbers($str) {
    return preg_match('~[0-9]+~', $str);
}

function redirect_to($url) {
    echo '
        <script defer type="text/javascript">
            window.onload = () => {
                window.location.href =  "'. $url. '";
            }
        </script>
    ';
}

function get_server_address() {
    $url = '';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        // HTTPS protocol is being used
        $url = 'https://';
    } else {
        // HTTP protocol is being used
        $url = 'http://';
    }

    $url.= $_SERVER['SERVER_NAME']. ':' . $_SERVER['SERVER_PORT'];

    return $url;
}