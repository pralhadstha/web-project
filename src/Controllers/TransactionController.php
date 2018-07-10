<?php

namespace App\Controllers;

use App\Helpers\DirectoryHelper;
use App\Helpers\SessionHelper;
use App\Helpers\TransactionHelper;
use App\Models\DepositeWithdraw;

/**
 * Class TransactionController
 * @package App\Controllers
 */
class TransactionController extends BaseController
{
    public $formErrors = null;
    public $formItems = null;

    /**
     * @param $data
     * @param $server
     */
    public function create($data, $server)
    {
        if ($server["REQUEST_METHOD"] == "POST") {
            if (empty($data["transactionType"])) {
                $this->formErrors['transactionTypeError'] = 'Choose the transaction type from the list.';
            } else {
                $this->formItems['transactionType'] = LoginController::testInput($data["transactionType"]);
            }
            if (!empty($data['chequeNumber']) && strlen($data['chequeNumber']) < 15) {
                $this->formErrors['chequeNumberError'] = 'Cheque Number cannot be less than 15 digit.';
            } else {
                $this->formItems['chequeNumber'] = LoginController::testInput($data["chequeNumber"]);
            }
            if (empty($data["amount"])) {
                $this->formErrors['amountError'] = 'Cheque Number cannot be empty.';
            } elseif (!is_numeric($data['amount'])) {
                $this->formErrors['amountError'] = 'Cheque Number can only be numeric.';
            } else {
                $this->formItems['amount'] = LoginController::testInput($data["amount"]);
            }
            if (isset($this->formErrors)) {
                $error = $this->formErrors;
                if (isset($this->formItems)) {
                    $error = array_merge($this->formErrors, $this->formItems);
                }
                SessionHelper::setSessionData($error);

                return header("Location: {$server["HTTP_REFERER"]}");
            } else {
                $code = '';
                $transaction = new DepositeWithdraw();
                $verified = 1;
                if ($this->formItems['transactionType'] == 'withdraw') {
                    $code = TransactionHelper::generateRandomCode();
                    $verified = 0;
                }
                $result = $transaction->create([
                    'account_no' => $data['userId'],
                    'transaction_type' => $this->formItems['transactionType'],
                    'cheque_no' => $this->formItems['chequeNumber'],
                    'amount' => $this->formItems['amount'],
                    'verification_code' => $code,
                    'verified' => $verified,
                ]);
                $response = null;
                $redirect = DirectoryHelper::getPublicPath() . "transactions.php";
                if ($result) {
                    if (!empty($code)) {
                        $transactionResult = $transaction->selectWhere(
                            "account_no = '{$data['userId']}' AND transaction_type = '{$this->formItems['transactionType']}' AND cheque_no = '{$this->formItems['chequeNumber']}' AND verification_code = '{$code}'"
                        );
                        $trans = $transaction->first($transactionResult);
                        $redirect = DirectoryHelper::getPublicPath() . "transactions.php";
                    }
                    $response = [
                        'type' => 'success',
                        'message' => "{$this->formItems['transactionType']} performed successfully.",
                    ];
                } else {
                    $response = [
                        'type' => 'danger',
                        'message' => "There was error performing {$this->formItems['transactionType']}.",
                    ];
                }
                SessionHelper::setSessionData($response);

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
        if ($server["REQUEST_METHOD"] == "POST") {
            if (empty($data["transactionType"])) {
                $this->formErrors['transactionTypeError'] = 'Choose the transaction type from the list.';
            } else {
                $this->formItems['transactionType'] = LoginController::testInput($data["transactionType"]);
            }
            if (!empty($data['chequeNumber']) && strlen($data['chequeNumber']) < 15) {
                $this->formErrors['chequeNumberError'] = 'Cheque Number cannot be less than 15 digit.';
            } else {
                $this->formItems['chequeNumber'] = LoginController::testInput($data["chequeNumber"]);
            }
            if (empty($data["amount"])) {
                $this->formErrors['amountError'] = 'Cheque Number cannot be empty.';
            } elseif (!is_numeric($data['amount'])) {
                $this->formErrors['amountError'] = 'Cheque Number can only be numeric.';
            } else {
                $this->formItems['amount'] = LoginController::testInput($data["amount"]);
            }
            if (isset($this->formErrors)) {
                $error = $this->formErrors;
                if (isset($this->formItems)) {
                    $error = array_merge($this->formErrors, $this->formItems);
                }
                SessionHelper::setSessionData($error);

                return header("Location: {$server["HTTP_REFERER"]}");
            } else {
                $code = '';
                $transaction = new DepositeWithdraw();
                $verified = 1;
                if ($this->formItems['transactionType'] == 'withdraw') {
                    $code = TransactionHelper::generateRandomCode();
                    $verified = 0;
                }
                $result = $transaction->update([
                    "account_no = '{$data['userId']}'",
                    "transaction_type = '{$this->formItems['transactionType']}'",
                    "cheque_no = '{$this->formItems['chequeNumber']}'",
                    "amount = '{$this->formItems['amount']}'",
                    "verification_code = '{$code}'",
                    "verified = '{$verified}'",
                ], "transaction_id = '{$data['transactionId']}'");
                $response = null;
                $redirect = DirectoryHelper::getPublicPath() . "transactions.php";
                if ($result) {
                    if (!empty($code)) {
                        $transactionResult = $transaction->selectWhere(
                            "account_no = '{$data['userId']}' AND transaction_type = '{$this->formItems['transactionType']}' AND cheque_no = '{$this->formItems['chequeNumber']}' AND verification_code = '{$code}'"
                        );
                        $trans = $transaction->first($transactionResult);
                        $redirect = DirectoryHelper::getPublicPath() . "transaction.php";
                    }
                    $response = [
                        'type' => 'success',
                        'message' => "{$this->formItems['transactionType']} updated successfully.",
                    ];
                } else {
                    $response = [
                        'type' => 'danger',
                        'message' => "There was error updating {$this->formItems['transactionType']}.",
                    ];
                }
                SessionHelper::setSessionData($response);

                return header("Location: {$redirect}");
            }
        }
    }

    /**
     * @param null $transactionId
     * @return mixed
     */
    public function getTransaction($transactionId = null)
    {
        if (isset($transactionId)) {
            $transaction = new DepositeWithdraw();
            $transactionInfo = $transaction->selectWhere("transaction_id = '{$transactionId}'");

            return $transaction->first($transactionInfo);
        }
    }

    /**
     * @param null $transactionId
     * @return mixed
     */
    public function deleteTransaction($transactionId = null)
    {
        if (isset($transactionId)) {
            $transaction = new DepositeWithdraw();

            return $transaction->deleteWhere("transaction_id", '=', $transactionId);
        }
    }

    public function verifyTransaction($transactionId)
    {
        if (!empty($transactionId)) {
            $transaction = new DepositeWithdraw();
            $transactionResult = $transaction->selectWhere("transaction_id = '{$transactionId}'");
            $trans = $transaction->first($transactionResult);
            $response = null;
            if ($trans) {
                $transaction->update([
                    "verification_code = ''",
                    "verified = '1'",
                ], "transaction_id = '{$transactionId}'");
                $response = [
                    'type' => 'success',
                    'message' => "Withdraw updated successfully.",
                ];
            } else {
                $response = [
                    'type' => 'danger',
                    'message' => "There was error updating Withdraw.",
                ];
            }

            return json_encode($response);
        }
    }
}
