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
                Dashboard
                <small>Home</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">Home</li>
            </ol>
        </section>
        <section class="content">
            <?php include('includes/notification.php'); ?>
        </section>
    </div>

    <footer class="main-footer">
    </footer>
</div>

<?php
include('includes/footer.php');
?>
</body>
