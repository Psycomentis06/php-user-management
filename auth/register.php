<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/user.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/form.php';

$html_title = 'Register'; // HTML title
include_once '../_inc/html_start.php'; // insert html
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_start.php';

// PHP Logic

if (is_form_submitted()) {
    // validate form fields
    $chk_email = check_email();
    $chk_password = check_password();
    $chk_firstname = check_name('first_name');
    $chk_lastname = check_name('last_name');
    flash_session_add('email', $chk_email);
    flash_session_add('first_name', $chk_firstname);
    flash_session_add('last_name', $chk_lastname);
    flash_session_add('password', $chk_password);

    $form_valid = is_form_valid([$chk_email, $chk_password, $chk_firstname, $chk_lastname]);
    if ($form_valid) {
        die('register user');
        // create user
        create_user(
            $_POST['email'],
            $_POST['password'],
            $_POST['first_name'],
            $_POST['last_name']
        );
    }
}

?>
<!-- HTML Body -->
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                <form novalidate method="post" class="mx-1 mx-md-4">

                                    <div style="margin-bottom: 40px">
                                        <?php render_input('text', 'first_name', 'First Name', '', 'flex-fill mb-0'); ?>
                                    </div>

                                    <div style="margin-bottom: 40px">
                                        <?php render_input('text', 'last_name', 'Last Name', '', 'flex-fill mb-0'); ?>
                                    </div>

                                    <div style="margin-bottom: 40px">
                                        <?php render_input('text', 'email', 'Email', '', 'flex-fill mb-0'); ?>
                                    </div>

                                    <div style="margin-bottom: 40px">
                                        <?php render_input('password', 'password', 'Password', '', 'flex-fill mb-0'); ?>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                     class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_end.php';
?>
