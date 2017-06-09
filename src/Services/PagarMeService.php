<?php

namespace JamesMiranda\Services;

use JamesMiranda\Entities\Vendor;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\PagarMe;
use PagarMe\Sdk\Recipient\Recipient;

class PagarMeService
{
    /**
     * @var PagarMe $pagarmeAPI
     */
    protected $pagarMeAPI;

    public function __construct($apiKey)
    {
        $this->pagarMeAPI =  new PagarMe($apiKey);
    }

    public function getApi()
    {
        return $this->pagarMeAPI;
    }

    public function getTransaction($token, $amountToCapture)
    {
        $transaction = $this->pagarMeAPI->transaction()->get($token);
        $transaction = $this->pagarMeAPI->transaction()->capture(
            $transaction,
            $amountToCapture
        );

        return $transaction;
    }

    private function createRecipient(BankAccount $bankAccount)
    {
        $recipient = $this->pagarMeAPI->recipient()->create(
            $bankAccount,
            'daily',
            0,
            true,
            true,
            42
        );

        return $recipient;
    }

    private function createBankAccount($bankCode, $officeNumber, $accountNumber, $accountDigit, $documentNumber, $legalName, $officeDigit = null)
    {
        $bankAccount = $this->pagarMeAPI->bankAccount()->create(
            $bankCode,
            $officeNumber,
            $accountNumber,
            $accountDigit,
            $documentNumber,
            $legalName,
            $officeDigit
        );

        return $bankAccount;
    }

    /**
     * @param $recipientId
     * @return Recipient
     */
    private function getRecipient($recipientId)
    {
        $recipient = $this->pagarMeAPI->recipient()->get($recipientId);
        return $recipient;
    }

    private function transfer(Recipient $recip, BankAccount $bank, string $amount)
    {
        $transfer = $this->pagarMeAPI->transfer()->create(
            $amount,
            $recip,
            $bank
        );

        if ($transfer->getStatus() == 'transferred') {
            //successful transference
            return true;
        } else {
            return false;
        }
    }

    public function payVendor(Vendor $vendor, $amount)
    {
        $recipientId = $vendor->getRecipientId();
        if ($recipientId == 0) {
            //create a new bank account and a new vendor
            $bankAccount = $this->createBankAccount('341', '0932', '58054', '5', '26268738888', 'API BANK ACCOUNT','1');
            $recipient = $this->createRecipient($bankAccount);
        } else {
            //get recipient by Id
            $recipient = $this->getRecipient($recipientId);
            $ba = $recipient->getBankAccount();
            if (empty($ba)) {
                $bankAccount = $this->createBankAccount('341', '0932', '58054', '5', '26268738888', 'API BANK ACCOUNT','1');
            } else {
                $bankAccount = $ba;
            }
        }

        $transferCheck = $this->transfer($recipient, $bankAccount, $amount * 100);

        return $transferCheck;
    }
}