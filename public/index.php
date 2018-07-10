<?php

use App\Helpers\DirectoryHelper;

require '../src/start.php';

$redirect = DirectoryHelper::getPublicPath() . "login.php";
header("Location: {$redirect}");
