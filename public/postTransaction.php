<?php
require '../src/start.php';
$user = new \App\Controllers\TransactionController();
$user->create($_POST, $_SERVER);