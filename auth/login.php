<?php
session_start();
ob_start(); // to solve header already sent caused by set_cookie function
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/user.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/form.php';
$html_title = 'Login'; // HTML title
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_start.php';

// login

if (is_form_submitted()) {
    $chk_email = ['valid' => true, 'message' => 'Email is valid', 'code' => 200];
    $chk_password = ['valid' => true,'message' => 'Password is valid', 'code' => 200];
    if (empty($_POST['email'])) {
        $chk_email = ['valid' => false, 'message' => 'Email is required', 'code' => 400];
    }

    if (empty($_POST['password'])) {
        $chk_password = ['valid' => false,'message' => 'Password is required', 'code' => 400];
    }
    flash_session_add('email', $chk_email);
    flash_session_add('password', $chk_password);

    $form_valid = is_form_valid([$chk_email, $chk_password]);
    if ($form_valid) {
        $user = login($_POST['email'], $_POST['password']);
        if (empty($user)) {
            // user not found
            flash_session_add('form_login', ['valid' => false, 'message' => 'User not found', 'code' => 404]);
        } else {
            if (!empty($_POST['remember_me'])) {
                //$_COOKIE['user_id'] = $user['id'];
                // set cookie for 30 days
                setcookie('user_id', $user['id'], time() + 86400 * 30, '/');
            }
            $_SESSION['user'] = $user;
            redirect_to( get_server_address(). '/user/profile.php');
        }
    }
}
ob_end_flush(); // closing the buffer
?>
<!-- Body -->
<section class="login-page">
    <div class="login-section text-center text-lg-start">
        <style>
            .rounded-t-5 {
                border-top-left-radius: 0.5rem;
                border-top-right-radius: 0.5rem;
            }

            @media (min-width: 992px) {
                .rounded-tr-lg-0 {
                    border-top-right-radius: 0;
                }

                .rounded-bl-lg-5 {
                    border-bottom-left-radius: 0.5rem;
                }
            }
        </style>
        <?php
            if (is_logged_in()) {
                $username = $_SESSION['user']['firstname'].' '. $_SESSION['user']['lastname'];;
                echo '<p class="lead text-center alert alert-success">You are now signed in as <a href="'. get_server_address() .'/user/profile.php"><b><u>'. $username .'</u></b></a></p>';
            }
        ?>
        <div class="card mb-3">
            <div class="row g-0 d-flex align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
                         class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                </div>
                <div class="col-lg-8">
                    <div class="card-body py-5 px-md-5">
                        <?php
                        // check session for flash form login
                        $register_flash = flash_session_read('form_login');
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
                                                    </div>                                                    
                                            ';
                        }
                        ?>
                        <h1 class="h3 text-center">Sign in to your account</h1>
                        <form method="post">
                            <!-- Email input -->
                            <div class="" style="margin-bottom:30px">
                                <?php render_input('text', 'email', 'Email'); ?>
                            </div>

                            <!-- Password input -->
                            <div class="mb-4">
                                <?php render_input('password', 'password', 'Password', ''); ?>
                            </div>
                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input name="remember_me" class="form-check-input" type="checkbox" value="1" id="form2Example31" checked />
                                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- Simple link -->
                                    <a href="#!">Forgot password?</a>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_inc/html_end.php';
?>