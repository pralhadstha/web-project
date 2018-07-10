<?php
    $css = \App\Helpers\AssetsHelper::getAssets('css', 'app.css');
    $bootstrap = \App\Helpers\AssetsHelper::getAssets('css', 'bootstrap.css');
    $fontawesome = \App\Helpers\AssetsHelper::getAssets('css', 'fontawesome.css');
    $ionicons = \App\Helpers\AssetsHelper::getAssets('css', 'ionicons.min.css');
    $skins = \App\Helpers\AssetsHelper::getAssets('css', 'all-skins.css');

    $sessionHelper = new \App\Helpers\SessionHelper();
    //$sessionHelper->setSession();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="<?php echo $bootstrap ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $fontawesome ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $ionicons ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $css ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $skins ?>">
</head>