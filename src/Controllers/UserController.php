<?php

namespace App\Controllers;

use App\Helpers\DirectoryHelper;
use App\Helpers\PasswordHelper;
use App\Helpers\SessionHelper;
use App\Models\UserAccount;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends BaseController
{
    public $formErrors = null;
    public $formItems = null;

    /**
     * @param $data
     * @param $server
     */
    public function create($data, $server)
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
            if (empty($data["address"])) {
                $this->formErrors['addressError'] = 'Address cannot be empty.';
            } else {
                $this->formItems['address'] = LoginController::testInput($data["address"]);
            }
            if (empty($data["phone"])) {
                $this->formErrors['phoneError'] = 'Phone cannot be empty.';
            } elseif (!is_numeric($data["phone"])) {
                $this->formErrors['phoneError'] = 'Phone Number should be number.';
            } elseif (strlen($data["phone"]) < 9) {
                $this->formErrors['phoneError'] = 'Phone cannot be less than 9 character.';
            }
            $this->formItems['phone'] = LoginController::testInput($data["phone"]);
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
                    'address' => $this->formItems['address'],
                    'mobile_number' => $this->formItems['phone'],
                    'users_ip' => $server['REMOTE_ADDR'],
                    'active' => 1,
                    'verification_code' => '',
                ]);
                $response = null;
                if ($result) {
                    $response = [
                        'type' => 'success',
                        'message' => 'User Added successfully.',
                    ];
                } else {
                    $response = [
                        'type' => 'danger',
                        'message' => 'There was error adding user.',
                    ];
                }
                SessionHelper::setSessionData($response);
                $redirect = DirectoryHelper::getPublicPath() . "users.php";

                return header("Location: {$redirect}");
            }
        }
    }

    /**
     * @param $data
     * @param $server
     */
    public function update($data, $server)
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
                $result = $user->selectWhere("(email = '{$email}' AND account_no <> '{$data['userId']}')");
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
            if (empty($data["address"])) {
                $this->formErrors['addressError'] = 'Address cannot be empty.';
            } else {
                $this->formItems['address'] = LoginController::testInput($data["address"]);
            }
            if (empty($data["phone"])) {
                $this->formErrors['phoneError'] = 'Phone cannot be empty.';
            } elseif (!is_numeric($data["phone"])) {
                $this->formErrors['phoneError'] = 'Phone Number should be number.';
            } elseif (strlen($data["phone"]) < 9) {
                $this->formErrors['phoneError'] = 'Phone cannot be less than 9 character.';
            }
            $this->formItems['phone'] = LoginController::testInput($data["phone"]);
            if (isset($this->formErrors)) {
                $error = $this->formErrors;
                if (isset($this->formItems)) {
                    $error = array_merge($this->formErrors, $this->formItems);
                }
                SessionHelper::setSessionData($error);

                return header("Location: {$server["HTTP_REFERER"]}");
            } else {
                $user = new UserAccount();
                $result = $user->update([
                    "username = '{$this->formItems['username']}'",
                    "password = '{$this->formItems['password']}'",
                    "email = '{$this->formItems['email']}'",
                    "account_name = '{$this->formItems['name']}'",
                    "address = '{$this->formItems['address']}'",
                    "mobile_number = '{$this->formItems['phone']}'",
                    "users_ip = '{$server['REMOTE_ADDR']}'",
                    "active = '1'",
                    "verification_code = ''",
                ], "account_no = '{$data['userId']}'");
                $response = null;
                if ($result) {
                    $response = [
                        'type' => 'success',
                        'message' => 'User updated successfully.',
                    ];
                } else {
                    $response = [
                        'type' => 'danger',
                        'message' => 'There was error updating user.',
                    ];
                }
                SessionHelper::setSessionData($response);
                $redirect = DirectoryHelper::getPublicPath() . "users.php";

                return header("Location: {$redirect}");
            }
        }
    }

    /**
     * @param null $userId
     * @return mixed
     */
    public function getUser($userId = null)
    {
        if (isset($userId)) {
            $user = new UserAccount();
            $usersInfo = $user->selectWhere("account_no = '{$userId}'");

            return $user->first($usersInfo);
        }
    }

    /**
     * @param null $userId
     * @return mixed
     */
    public function deleteUser($userId = null)
    {
        $response = null;
        if (isset($userId)) {
            $user = new UserAccount();
            $deletedUser = $user->deleteWhere("account_no", '=', $userId);
            if ($deletedUser) {
                $response = [
                    'type' => 'success',
                    'message' => 'User deleted successfully.',
                ];
            } else {
                $response = [
                    'type' => 'danger',
                    'message' => 'There was error deleting user.',
                ];
            }
            SessionHelper::setSessionData($response);

            return $deletedUser;
        }
    }
}
