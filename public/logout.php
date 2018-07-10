<?php

use App\Helpers\DirectoryHelper;
use App\Helpers\SessionHelper;

require '../src/start.php';
session_start();
if (isset($_SESSION)) {
    if (isset($_SESSION['verifiedLogin'])) {
        $response = [
            'type' => 'success',
            'message' => 'You have logged out of the system.',
            'verifiedLogin' => null,
            'rememberSession' => null,
        ];
        SessionHelper::setSessionData($response);
        $redirect = DirectoryHelper::getPublicPath() . "login.php";
        header("Location: {$redirect}");
    }
}
