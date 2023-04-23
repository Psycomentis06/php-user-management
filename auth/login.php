<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/user.php';
$html_title = 'Login'; // HTML title
include_once '../_inc/html_start.php'; // insert html
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_start.php';

login('user@u.com', '1234');
?>
<!-- Body -->
    <h1>Login page</h1>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_end.php';
?>