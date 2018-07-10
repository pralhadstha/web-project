<?php
use App\Helpers\DirectoryHelper;

require '../src/start.php';
include('includes/header.php');
session_start();
$nameError = $emailError = $passwordError = $confirmPasswordError = $phoneError = null;
if (isset($_SESSION)) {
    if (isset($_SESSION['verifiedLogin'])) {
        $redirect = DirectoryHelper::getPublicPath() . "dashboard.php";
        header("Location: {$redirect}");
    }
    if (isset($_SESSION['usernameError'])) {
        $usernameError = $_SESSION['usernameError'];
        unset($_SESSION['usernameError']);
    }
    if (isset($_SESSION['nameError'])) {
        $nameError = $_SESSION['nameError'];
        unset($_SESSION['nameError']);
    }
    if (isset($_SESSION['emailError'])) {
        $emailError = $_SESSION['emailError'];
        unset($_SESSION['emailError']);
    }
    if (isset($_SESSION['passwordError'])) {
        $passwordError = $_SESSION['passwordError'];
        unset($_SESSION['passwordError']);
    }
    if (isset($_SESSION['confirmPasswordError'])) {
        $confirmPasswordError = $_SESSION['confirmPasswordError'];
        unset($_SESSION['confirmPasswordError']);
    }
    if (isset($_SESSION['phoneError'])) {
        $phoneError = $_SESSION['phoneError'];
        unset($_SESSION['phoneError']);
    }
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        unset($_SESSION['username']);
    }
    if (isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
        unset($_SESSION['name']);
    }
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        unset($_SESSION['email']);
    }
    if (isset($_SESSION['phone'])) {
        $phone = $_SESSION['phone'];
        unset($_SESSION['phone']);
    }
}
?>

<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Admin</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register</p>

        <form action="checkRegister.php" method="post">
            <div class="form-group has-feedback <?php echo isset($usernameError) ?  'has-error' : '' ?>">
                <input type="text" class="form-control" placeholder="Username" name="username"
                       value="<?php echo isset($username) ? $username : null?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <?php
                if (isset($usernameError)) {
                    echo "<span class='help-block'>{$usernameError}</span>";
                }
                ?>
            </div>
            <div class="form-group has-feedback <?php echo isset($nameError) ?  'has-error' : '' ?>">
                <input type="text" class="form-control" placeholder="Name" name="name"
                       value="<?php echo isset($name) ? $name : null?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <?php
                if (isset($nameError)) {
                    echo "<span class='help-block'>{$nameError}</span>";
                }
                ?>
            </div>
            <div class="form-group has-feedback <?php echo isset($emailError) ?  'has-error' : '' ?>">
                <input type="email" class="form-control" placeholder="Email" name="email"
                       value="<?php echo isset($email) ? $email : null?>">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?php
                if (isset($emailError)) {
                    echo "<span class='help-block'>{$emailError}</span>";
                }
                ?>
            </div>
            <div class="form-group has-feedback <?php echo isset($passwordError) ?  'has-error' : '' ?>">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php
                if (isset($passwordError)) {
                    echo "<span class='help-block'>{$passwordError}</span>";
                }
                ?>
            </div>
            <div class="form-group has-feedback <?php echo isset($confirmPasswordError) ?  'has-error' : '' ?>">
                <input type="password" class="form-control" placeholder="Confirm password" name="confirmPassword">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                <?php
                if (isset($confirmPasswordError)) {
                    echo "<span class='help-block'>{$confirmPasswordError}</span>";
                }
                ?>
            </div>
            <div class="form-group has-feedback <?php echo isset($phoneError) ?  'has-error' : '' ?>">
                <input type="text" class="form-control" placeholder="Phone number" name="phone"
                       value="<?php echo isset($phone) ? $phone : null?>">
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                <?php
                if (isset($phoneError)) {
                    echo "<span class='help-block'>{$phoneError}</span>";
                }
                ?>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </div>
        </form>

        <a href="login.php" class="text-center">Already a Member?</a>
    </div>
</div>
<?php
include('includes/footer.php');
?>
</body>
