<?php

require '../src/start.php';
$login = new \App\Controllers\LoginController();
$login->validator($_POST, $_SERVER);
