<?php
require '../src/start.php';
$user = new \App\Controllers\UserController();
$user->create($_POST, $_SERVER);