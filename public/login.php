<?php

use App\Helpers\DirectoryHelper;

require '../src/start.php';
include('includes/header.php');
session_start();
$emailError = $passwordError = null;
if (isset($_SESSION)) {
    if (isset($_SESSION['verifiedLogin'])) {
        $redirect = DirectoryHelper::getPublicPath() . "dashboard.php";
        header("Location: {$redirect}");
    }
    if (isset($_SESSION['emailError'])) {
        $emailError = $_SESSION['emailError'];
        unset($_SESSION['emailError']);
    }
    if (isset($_SESSION['passwordError'])) {
        $passwordError = $_SESSION['passwordError'];
        unset($_SESSION['passwordError']);
    }
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        unset($_SESSION['email']);
    }
    if (isset($_SESSION['type'])) {
        $type = $_SESSION['type'];
        unset($_SESSION['type']);
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
?>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b></a>
    </div>
    <?php
    $registerLink = DirectoryHelper::getPublicPath() . "register.php";
    ?>
    <div class="login-box-body">
        <p class="login-box-msg">Login</p>
        <?php if (isset($type)): ?>
            <div class="callout <?php echo "callout-{$type}" ?>">
                <p><?php echo isset($message) ? $message : null ?></p>
            </div>
        <?php endif; ?>
        <form action="checkLogin.php" method="post">
            <div class="form-group has-feedback <?php echo isset($emailError) ? 'has-error' : '' ?>">
                <input type="email" class="form-control" placeholder="Email" name="email"
                       value="<?php echo isset($email) ? $email : null ?>">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?php
                if (isset($emailError)) {
                    echo "<span class='help-block'>{$emailError}</span>";
                }
                ?>
            </div>
            <div class="form-group has-feedback <?php echo isset($passwordError) ? 'has-error' : '' ?>">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php
                if (isset($passwordError)) {
                    echo "<span class='help-block'>{$passwordError}</span>";
                }
                ?>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck login-checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>
        <a href="<?= $registerLink ?>" class="text-center">Register an account.</a>
    </div>
</div>

<?php
include('includes/footer.php');
?>
</body>
