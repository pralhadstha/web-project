<?php

use App\Helpers\DirectoryHelper;

require '../src/start.php';

$transactions = new \App\Controllers\TransactionController();
if (isset($_GET['trans'])) {
    $transactionId = $_GET['trans'];
    $transaction = $transactions->deleteTransaction($transactionId);
    $redirect = DirectoryHelper::getPublicPath() . "transactions.php";
    header("Location: {$redirect}");
}
