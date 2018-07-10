<?php
use App\Helpers\DirectoryHelper;

require '../src/start.php';
session_start();
include('includes/header.php');
if (isset($_SESSION)) {
    if (!isset($_SESSION['verifiedLogin'])) {
        $redirect = DirectoryHelper::getPublicPath() . "login.php";
        header("Location: {$redirect}");
    }
    if (isset($_SESSION['type'])) {
        $type = $_SESSION['type'];
        unset($_SESSION['type']);
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if(isset($_SESSION['usernameError'])) {
        $usernameError = $_SESSION['usernameError'];
        unset($_SESSION['usernameError']);
    }
    if(isset($_SESSION['nameError'])) {
        $nameError = $_SESSION['nameError'];
        unset($_SESSION['nameError']);
    }
    if(isset($_SESSION['emailError'])) {
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
    if (isset($_SESSION['$addressError'])) {
        $addressError = $_SESSION['$addressError'];
        unset($_SESSION['$addressError']);
    }
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        unset($_SESSION['username']);
    }
    if(isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
        unset($_SESSION['name']);
    }
    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        unset($_SESSION['email']);
    }
    if(isset($_SESSION['address'])) {
        $address = $_SESSION['address'];
        unset($_SESSION['address']);
    }
    if(isset($_SESSION['phone'])) {
        $phone = $_SESSION['phone'];
        unset($_SESSION['phone']);
    }
}
?>
<body class="hold-transition skin-blue fixed sidebar-mini">

<div class="wrapper">
    <?php
    include('includes/dashboard-menus.php');
    ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Users
                <small>account</small>
            </h1>
        </section>
        <section class="content">
            <div class="col-md-9">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Add Form</h3>
                    </div>
                    <form class="form-horizontal" action="postUser.php" method="post">
                        <div class="box-body">
                            <div class="form-group <?php echo isset($nameError) ? 'has-error' : '' ?>">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="Name" name="name"
                                           value="<?php echo isset($name) ? $name : null ?>">
                                    <?php
                                    if (isset($nameError)) {
                                        echo "<span class='help-block'>{$nameError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($usernameError) ? 'has-error' : '' ?>">
                                <label for="username" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" placeholder="Username"
                                           name="username" value="<?php echo isset($username) ? $username : null ?>">
                                    <?php
                                    if (isset($usernameError)) {
                                        echo "<span class='help-block'>{$usernameError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($emailError) ? 'has-error' : '' ?>">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" placeholder="Email"
                                           name="email" value="<?php echo isset($email) ? $email : null ?>">
                                    <?php
                                    if (isset($emailError)) {
                                        echo "<span class='help-block'>{$emailError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($passwordError) ? 'has-error' : '' ?>">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                           name="password">
                                    <?php
                                    if (isset($passwordError)) {
                                        echo "<span class='help-block'>{$passwordError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($confirmPasswordError) ? 'has-error' : '' ?>">
                                <label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="confirmPassword"
                                           placeholder="Password" name="confirmPassword">
                                    <?php
                                    if (isset($confirmPasswordError)) {
                                        echo "<span class='help-block'>{$confirmPasswordError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($addressError) ? 'has-error' : '' ?>">
                                <label for="address" class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address" placeholder="Address"
                                           name="address"  value="<?php echo isset($address) ? $address : null ?>">
                                    <?php
                                    if (isset($addressError)) {
                                        echo "<span class='help-block'>{$addressError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($phoneError) ? 'has-error' : '' ?>">
                                <label for="phone" class="col-sm-2 control-label">Mobile Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone"
                                           placeholder="Mobile Number" name="phone"
                                           value="<?php echo isset($phone) ? $phone : null ?>">
                                    <?php
                                    if (isset($phoneError)) {
                                        echo "<span class='help-block'>{$phoneError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <footer class="main-footer">
    </footer>
</div>

<?php
include('includes/footer.php');
?>
</body>

