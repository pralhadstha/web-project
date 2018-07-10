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
    if (isset($_SESSION['usrHash'])) {
        $userId = $_SESSION['usrHash'];
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
            <?php include('includes/notification.php'); ?>
            <?php
            $users = \App\Helpers\UserHelper::getAllUsers();
            if (isset($users)): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Users Details</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        $userAddLink = DirectoryHelper::getPublicPath() . "user-add.php";
                        ?>
                        <a href="<?php echo $userAddLink; ?>" type="button" class="btn btn-primary pull-right btn-add">Add
                            User</a>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">S.no.</th>
                                <th>User's Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>User's Registered IP</th>
                                <th></th>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['account_no'] ?></td>
                                    <td><?php echo $user['account_name'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><?php echo $user['mobile_number'] ?></td>
                                    <td><?php echo $user['users_ip'] ?></td>
                                    <td>
                                        <?php
                                        $userEditLink = DirectoryHelper::getPublicPath() . "user-edit.php?u={$user['account_no']}";
                                        $userDeleteLink = DirectoryHelper::getPublicPath() . "user-delete.php?u={$user['account_no']}";
                                        ?>
                                        <a href="<?php echo $userEditLink; ?>" type="button" class="btn btn-success">Edit</a>
                                        <?php if (!($user['account_no'] == $userId) && !(($user['account_no'] == 1))) : ?>
                                            <a href="<?php echo $userDeleteLink; ?>" type="button"
                                               class="btn btn-danger">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
    <footer class="main-footer">
    </footer>
</div>

<?php
include('includes/footer.php');
?>
</body>
