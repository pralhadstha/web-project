<?php
use App\Helpers\DirectoryHelper;

require '../src/start.php';

$users = new \App\Controllers\UserController();
if (isset($_GET['u'])) {
    $userId = $_GET['u'];
    $user = $users->deleteUser($userId);
    $redirect = DirectoryHelper::getPublicPath() . "users.php";
    header("Location: {$redirect}");
}