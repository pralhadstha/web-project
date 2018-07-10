<?php
use App\Helpers\DirectoryHelper;

require '../src/start.php';
session_start();

$transactions = new \App\Controllers\TransactionController();
if (isset($_SESSION)) {
    if (!isset($_SESSION['verifiedLogin'])) {
        $redirect = DirectoryHelper::getPublicPath() . "login.php";
        header("Location: {$redirect}");
    }
}
if (isset($_GET['trans'])) {
    $transactionId = $_GET['trans'];
    echo $transactions->verifyTransaction($transactionId);
}
?>