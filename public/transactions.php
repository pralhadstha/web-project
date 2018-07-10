<?php

use App\Helpers\DirectoryHelper;

require '../src/start.php';
session_start();
include('includes/header.php');
$userId = 0;
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
                Transactions
            </h1>
        </section>
        <section class="content">
            <?php include('includes/notification.php'); ?>
            <?php
            $userTransactions = \App\Helpers\TransactionHelper::getUsersTransactions($userId);
            if (isset($userTransactions)): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Users Transaction List</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        $transactionAddLink = DirectoryHelper::getPublicPath() . "transaction-add.php";
                        $transactionVerifyLink = DirectoryHelper::getPublicPath() . "transaction-verify.php";
                        ?>
                        <a href="<?php echo $transactionAddLink; ?>" type="button"
                           class="btn btn-primary pull-right btn-add">Add Transaction</a>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">S.no.</th>
                                <th>Transaction Type</th>
                                <th>Cheque Number</th>
                                <th>Amount</th>
                                <th>Verification Status</th>
                                <th></th>
                            </tr>
                            <?php foreach ($userTransactions as $transaction): ?>
                                <tr>
                                    <td><?php echo $transaction['transaction_id'] ?></td>
                                    <td><?php echo $transaction['transaction_type'] ?></td>
                                    <td><?php echo $transaction['cheque_no'] ?></td>
                                    <td><?php echo $transaction['amount'] ?></td>
                                    <td class="verify-name"><?php echo ($transaction['verified'] == 1) ? 'Verified' : 'Not Verified' ?></td>
                                    <td>
                                        <?php
                                        $transactionEditLink = DirectoryHelper::getPublicPath() . "transaction-edit.php?trans={$transaction['transaction_id']}";
                                        $transactionDeleteLink = DirectoryHelper::getPublicPath() . "transaction-delete.php?trans={$transaction['transaction_id']}";
                                        ?>
                                        <?php
                                        if (($transaction['verified'] == 0) || ($transaction['transaction_type'] == 'deposit')) :
                                            ?>
                                            <a href="<?php echo $transactionEditLink; ?>" type="button"
                                               class="btn btn-success edit">Edit</a>
                                        <?php endif; ?>
                                        <a href="<?php echo $transactionDeleteLink; ?>" type="button"
                                           class="btn btn-danger delete">Delete</a>
                                        <?php
                                        if ($transaction['verified'] == 0) :
                                            ?>
                                            <a href="#" type="button" data-trans="<?= $transaction['transaction_id'] ?>"
                                               class="btn btn-info verify-transaction">Verify</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </section>
        <span id="transaction-verification-link" data-url="<?= $transactionVerifyLink ?>">
    </div>

    <footer class="main-footer">
    </footer>
</div>

<?php
include('includes/footer.php');
?>
<script>
    $(document).ready(function () {
        $('.verify-transaction').click(function () {
            var that = $(this)
            var transId = that.data('trans');
            var url = $('#transaction-verification-link').data('url');
            url = url + '?trans=' + transId;
            var response = '';
            $.ajax({
                url: url, success: function (result) {
                    result = JSON.parse(result);
                    response = '<div class="alert alert-' + result.type + ' alert-dismissible">\n' +
                        '        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n' +
                        '        <p>' + result.message + '</p>\n' +
                        '    </div>';
                    $('.content').prepend(response);
                    if (result.type == 'success') {
                        var edit = that.siblings('.edit');
                        var parentMessage = that.parents('tr');
                        edit.remove();
                        that.remove();
                        parentMessage.find('.verify-name').html('Verified');
                        setTimeout(function(){
                            $('.alert-dismissible').remove();
                        }, 2000);
                    }
                }
            }, response, that);
        });
    });
</script>
</body>

