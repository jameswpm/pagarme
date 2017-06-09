<?php

namespace JamesMiranda\Services;

use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\PagarMe;
use PagarMe\Sdk\Recipient\Recipient;

class PagarMeService
{
    /**
     * @var PagarMe $pagarmeAPI
     */
    protected $pagarmeAPI;

    public function __construct($apiKey)
    {
        $this->pagarmeAPI =  new PagarMe($apiKey);
    }

    public function getApi()
    {
        return $this->pagarmeAPI;
    }

    private function createRecipient(BankAccount $bankAccount)
    {
        $recipient = $this->pagarmeAPI->recipient()->create(
            $bankAccount,
            'daily',
            0,
            true,
            true,
            42
        );

        return $recipient;
    }

    private function createBankAccount()
    {
        $bankAccount = $this->pagarmeAPI->bankAccount()->create(
            '341',
            '0932',
            '58054',
            '5',
            '26268738888',
            'API BANK ACCOUNT',
            '1'
        );

        return $bankAccount;
    }

    private function getBankAccount($id)
    {
        $bankAccount = $this->pagarmeAPI->bankAccount()->get($id);

        return $bankAccount;
    }

    private function Transfer(Recipient $recip, BankAccount $bank, string $amount)
    {
        $transfer = $this->pagarmeAPI->transfer()->create(
            $amount,
            $recip,
            $bank
        );
    }

    public function payVendor()
    {

    }
}