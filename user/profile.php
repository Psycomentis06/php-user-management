<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/_src/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/form.php';

$html_title = 'User profile'; // HTML title
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_start.php'; // insert html

?>

<section class="profile-page">
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
// Set up profile params
if (is_logged_in()) {
    $profile_id = $_SESSION['user']['id'];
    $profile_editable = isset($_GET['edit']) && $_GET['edit'] == 1;
    // load profile component
    require_once $_SERVER['DOCUMENT_ROOT'] . '/_inc/profile.php';
} else {
    flash_session_add('form_login', ['message' => 'You must be signed to access your profile.', 'valid' => false, 'code' => 402]);
    redirect_to(get_server_address(). '/auth/login.php');
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_end.php';
?>

