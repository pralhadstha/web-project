<?php
use App\Helpers\DirectoryHelper;
use App\Helpers\SessionHelper;
use App\Models\UserAccount;

require '../src/start.php';
include('includes/header.php');
session_start();

$userId = 0;
if (isset($_SESSION)) {
    if (isset($_SESSION['verificationNumberError'])) {
        $verificationNumberError = $_SESSION['verificationNumberError'];
        unset($_SESSION['verificationNumberError']);
    }
    if (isset($_GET['u'])) {
        $userId = $_GET['u'];
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['userId'];
    $verificationNum = $_POST['verificationNumber'];
    $user = new UserAccount();
    $result = $user->selectWhere("account_no = '{$id}'");
    $userInfo = $user->first($result);
    if (!($userInfo['verification_code'] == $verificationNum)) {
        $response = [
            'verificationNumberError' => 'Verification Code doesn\'t match.',
            'verifiedLogin' => false,
        ];
        SessionHelper::setSessionData($response);
        return header("Location: {$_SERVER["HTTP_REFERER"]}");
    } else {
        $user->update([
            "verification_code = ''"
        ], "account_no = '{$id}'");
        $response = [
            'verifiedLogin' => true,
        ];
        $redirect = DirectoryHelper::getPublicPath() . "dashboard.php";
        SessionHelper::setSessionData($response);
        return header("Location: {$redirect}");
    }
}

?>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-box-body">
        <form action="login-verify.php" method="post">
            <div class="form-group has-feedback <?php echo isset($verificationNumberError) ? 'has-error' : '' ?>">
                <label for="verificationNumber" class="col-sm-12 control-label">
                    Enter Verification Code:
                </label>
                <input type="text" class="form-control" id="verificationNumber" placeholder="Verification Number"
                       name="verificationNumber"
                       value="<?php echo isset($verificationNumber) ? $verificationNumber : null ?>">
                <?php
                if (isset($verificationNumberError)) {
                    echo "<span class='help-block'>{$verificationNumberError}</span>";
                }
                ?>
            </div>
            <input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-info pull-right">Confirm</button>
    </div>
    </form>
</div>
</div>
</body>