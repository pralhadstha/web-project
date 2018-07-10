<?php

use App\Helpers\DirectoryHelper;

?>
<header class="main-header">
    <?php
    $dashboardLink = DirectoryHelper::getPublicPath() . "dashboard.php";
    ?>
    <a href="<?php echo $dashboardLink; ?>" class="logo">
        <span class="logo-mini"><b>AP</b></span>
        <span class="logo-lg"><b>Admin</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        $userImage = \App\Helpers\AssetsHelper::getAssets('images', 'user.png');
                        $user = \App\Helpers\UserHelper::getUser();
                        ?>
                        <img src="<?php echo $userImage; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user['account_name']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer">
                            <?php
                            $logout = DirectoryHelper::getPublicPath() . "logout.php";
                            ?>
                            <a href="<?php echo $logout; ?>" class="btn btn-default btn-flat">Sign out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <?php
            $userAccount = DirectoryHelper::getPublicPath() . "users.php";
            $transactions = DirectoryHelper::getPublicPath() . "transactions.php";
            ?>
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Transactions</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo $transactions; ?>"><i class="fa fa-money"></i>Deposit / Withdraw</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Users</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo $userAccount; ?>"><i class="fa fa-user-circle-o"></i>Users</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>