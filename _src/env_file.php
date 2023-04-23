<?php


function loadConfig(): false|array
{
    return parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/.env');
}