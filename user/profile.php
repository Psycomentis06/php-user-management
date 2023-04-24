<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/_src/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/form.php';

$html_title = 'User profile'; // HTML title
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_start.php'; // insert html

?>

<section>
<?php
// check session for flash form register
$register_flash = flash_session_read('form_register');
if (!empty($register_flash)) {
    $alert_type_classname = '';
    if ($register_flash['valid']) {
        // echo bootstrap alert
        $alert_type_classname = 'alert-success';
    } else {
        $alert_type_classname = 'alert-danger';
    }
    echo '
          <div class="alert '. $alert_type_classname .' alert-dismissible fade show">
            '.$register_flash['message'].'
          </div>';
}
?>
</section>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_end.php';
?>

