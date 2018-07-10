<?php

namespace App\Controllers;

use App\Helpers\DirectoryHelper;
use App\Helpers\PasswordHelper;
use App\Helpers\SessionHelper;
use App\Models\UserAccount;

/**
 * Class RegisterController
 * @package App\Controllers
 */
class RegisterController extends BaseController
{
    public $formErrors = null;
    public $formItems = null;

    /**
     * @param $data
     * @param $server
     */
    public function validator($data, $server)
    {
        $passwordHelper = new PasswordHelper();
        if ($server["REQUEST_METHOD"] == "POST") {
            if (empty($data["name"])) {
                $this->formErrors['nameError'] = 'Name cannot be empty.';
            } else {
                $this->formItems['name'] = LoginController::testInput($data["name"]);
            }
            if (empty($data["username"])) {
                $this->formErrors['usernameError'] = 'Username cannot be empty.';
            } else {
                $this->formItems['username'] = LoginController::testInput($data["username"]);
            }
            if (empty($data["email"])) {
                $this->formErrors['emailError'] = 'Email cannot be empty.';
            } else {
                $email = LoginController::testInput($data["email"]);
                $user = new UserAccount();
                $result = $user->selectWhere("email = '{$email}'");
                if (count($result) > 0) {
                    $this->formErrors['emailError'] = 'Email Already Exists.';
                }
                $this->formItems['email'] = $email;
            }
            if (empty($data["password"])) {
                $this->formErrors['passwordError'] = 'Password cannot be empty.';
            } elseif (strlen($data["password"]) < 6) {
                $this->formErrors['passwordError'] = 'Password cannot be less than 6 character.';
            } else {
                $this->formItems['password'] = $passwordHelper->make(LoginController::testInput($data["password"]));
            }
            if (empty($data["confirmPassword"])) {
                $this->formErrors['confirmPasswordError'] = 'Confirm Password cannot be empty.';
            } elseif (strlen($data["confirmPassword"]) < 6) {
                $this->formErrors['confirmPasswordError'] = 'Confirm Password cannot be less than 6 character.';
            } elseif ($data["confirmPassword"] != $data['password']) {
                $this->formErrors['confirmPasswordError'] = 'Confirm Password doesn\'t match.';
            }
            if (empty($data["phone"])) {
                $this->formErrors['phoneError'] = 'Phone cannot be empty.';
            } elseif (!is_numeric($data["phone"])) {
                $this->formErrors['phoneError'] = 'Phone Number should be number.';
            } elseif (strlen($data["phone"]) < 9) {
                $this->formErrors['phoneError'] = 'Phone cannot be less than 9 character.';
            }
            $this->formItems['phone'] = LoginController::testInput($data["phone"]);
        }
        if (isset($this->formErrors)) {
            $error = $this->formErrors;
            if (isset($this->formItems)) {
                $error = array_merge($this->formErrors, $this->formItems);
            }
            SessionHelper::setSessionData($error);
            return header("Location: {$server["HTTP_REFERER"]}");
        } else {
            $user = new UserAccount();
            $result = $user->create([
                'username' => $this->formItems['username'],
                'password' => $this->formItems['password'],
                'email' => $this->formItems['email'],
                'account_name' => $this->formItems['name'],
                'address' => '',
                'mobile_number' => $this->formItems['phone'],
                'users_ip' => $server['REMOTE_ADDR'],
                'active' => 1,
                'verification_code' => '',
            ]);
            $response = null;
            if ($result) {
                $response = [
                    'type' => 'success',
                    'message' => 'Your registration have been done. Please Login to activate the account.',
                ];
            } else {
                $response = [
                    'type' => 'danger',
                    'message' => 'There was error in your registration. Please contact the administrator.',
                ];
            }
            SessionHelper::setSessionData($response);
            $redirect = DirectoryHelper::getPublicPath() . "login.php";
            return header("Location: {$redirect}");
        }
    }
}