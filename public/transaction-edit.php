<?php
use App\Helpers\DirectoryHelper;

require '../src/start.php';
session_start();
include('includes/header.php');

$userId = $transactionId = 0;
$transactions = new \App\Controllers\TransactionController();
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
    if(isset($_SESSION['transactionTypeError'])) {
        $transactionTypeError = $_SESSION['transactionTypeError'];
        unset($_SESSION['transactionTypeError']);
    }
    if(isset($_SESSION['chequeNumberError'])) {
        $chequeNumberError = $_SESSION['chequeNumberError'];
        unset($_SESSION['chequeNumberError']);
    }
    if(isset($_SESSION['amountError'])) {
        $amountError = $_SESSION['amountError'];
        unset($_SESSION['amountError']);
    }
    if(isset($_SESSION['transactionType'])) {
        $transactionType = $_SESSION['transactionType'];
        unset($_SESSION['transactionType']);
    }
    if(isset($_SESSION['chequeNumber'])) {
        $chequeNumber = $_SESSION['chequeNumber'];
        unset($_SESSION['chequeNumber']);
    }
    if(isset($_SESSION['amount'])) {
        $amount = $_SESSION['amount'];
        unset($_SESSION['amount']);
    }
    if(isset($_SESSION['usrHash'])) {
        $userId = $_SESSION['usrHash'];
        unset($_SESSION['amount']);
    }
}
if (isset($_GET['trans'])) {
    $transactionId = $_GET['trans'];
    $transaction = $transactions->getTransaction($transactionId);
    $userId = $transaction['account_no'];
    $transactionType = $transaction['transaction_type'];
    $chequeNumber = $transaction['cheque_no'];
    $amount = $transaction['amount'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transactions->update($_POST, $_SERVER);
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
                Transaction
            </h1>
        </section>
        <section class="content">
            <div class="col-md-9">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Withdraw / Deposit Add Form</h3>
                    </div>
                    <form class="form-horizontal" action="transaction-edit.php" method="post">
                        <div class="box-body">
                            <div class="form-group <?php echo isset($transactionTypeError) ? 'has-error' : '' ?>">
                                <label for="transactionType" class="col-sm-4 control-label">Choose Transaction Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="transactionType" id="transactionType">
                                        <option value="deposit" <?php echo (isset($transactionType) && $transactionType == 'deposit') ? 'selected' : ''?>>Deposit</option>
                                        <option value="withdraw" <?php echo (isset($transactionType) && $transactionType == 'withdraw') ? 'selected' : ''?>>Withdraw</option>
                                    </select>
                                    <?php
                                    if (isset($transactionTypeError)) {
                                        echo "<span class='help-block'>{$transactionTypeError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($chequeNumberError) ? 'has-error' : '' ?>">
                                <label for="chequeNumber" class="col-sm-4 control-label">Cheque Number</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="chequeNumber" placeholder="Cheque Number"
                                           name="chequeNumber" value="<?php echo isset($chequeNumber) ? $chequeNumber : null ?>">
                                    <?php
                                    if (isset($chequeNumberError)) {
                                        echo "<span class='help-block'>{$chequeNumberError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
                            <input type="hidden" name="transactionId" id="transactionId" value="<?php echo $transactionId; ?>">
                            <div class="form-group <?php echo isset($amountError) ? 'has-error' : '' ?>">
                                <label for="amount" class="col-sm-4 control-label">Amount</label>
                                <div class="col-sm-8">
                                    <input type="amount" class="form-control" id="amount" placeholder="Amount"
                                           name="amount" value="<?php echo isset($amount) ? $amount : null ?>">
                                    <?php
                                    if (isset($amountError)) {
                                        echo "<span class='help-block'>{$amountError}</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Edit Transaction</button>
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

