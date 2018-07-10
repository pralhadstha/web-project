<?php
require '../src/start.php';
$register = new \App\Controllers\RegisterController();
$register->validator($_POST, $_SERVER);
