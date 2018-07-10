<?php

namespace App\Controllers;

use App\Helpers\DirectoryHelper;
use App\Helpers\PasswordHelper;
use App\Helpers\SessionHelper;
use App\Models\UserAccount;

/**
 * Class LoginController
 * @package App\Controllers
 */
class LoginController
{
    public $formErrors = null;
    public $formItems = null;

    /**
     * @param $data
     * @param $server
     */
    public function validator($data, $server)
    {
        $response = null;
        if ($server["REQUEST_METHOD"] == "POST") {
            if (empty($data["email"])) {
                $this->formErrors['emailError'] = 'Email cannot be empty.';
            } else {
                $this->formItems['email'] = self::testInput($data["email"]);
            }
            if (empty($data["password"])) {
                $this->formErrors['passwordError'] = 'Password cannot be empty.';
            } else {
                $this->formItems['password'] = self::testInput($data["password"]);
            }
        }
        if (isset($this->formErrors)) {
            $response = $this->formErrors;
            if (isset($this->formItems)) {
                $response = array_merge($this->formErrors, $this->formItems);
            }
        } else {
            $user = new UserAccount();
            $result = $user->selectWhere("email = '{$this->formItems['email']}'");
            $userId = $user->first($result)['account_no'];
            if (!$result) {
                $response = [
                    'type' => 'warning',
                    'message' => 'There is no user associated with the email.',
                ];
            } else {
                $passwordHelper = new PasswordHelper();
                $matchPassword = $passwordHelper->check($this->formItems['password'], $user->first($result)['password']);
                if ($matchPassword) {
                    $redirect = DirectoryHelper::getPublicPath() . "dashboard.php";
                    if (isset($data["remember"])) {
                        $remember = true;
                    } else {
                        $remember = false;
                    }
                    $response = [
                        'type' => 'success',
                        'message' => 'You have logged in to the system.',
                        'usrHash' => $user->first($result)['account_no'],
                        'rememberSession' => $remember,
                        'verifiedLogin' => true,
                    ];
                    SessionHelper::setSessionData($response);
                    return header("Location: {$redirect}");
                }
                $response = [
                    'type' => 'danger',
                    'message' => 'Email and Password doesn\'t match.',
                ];
            }
        }
        SessionHelper::setSessionData($response);

        return header("Location: {$server["HTTP_REFERER"]}");
    }

    /**
     * @param $data
     * @return string
     */
    public static function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}