<?php

namespace JamesMiranda\Controllers;

use Doctrine\ORM\EntityManager;
use PagarMe\Sdk\PagarMe;

class Payment
{
    /**
     * @var string $apiKey;
     */
    private $apiKey;

    /**
     * @var Object $transaction
     */
    protected $transaction;

    /**
     * Payment constructor.
     * @param EntityManager $em
     * @param String $key
     */
    public function __construct(EntityManager $em, String $key)
    {
        $this->apiKey = $key;
    }

    /**
     * @param $token
     * @param $amount
     * @return bool
     */
    public function getTransaction($token, $amount)
    {
        $pagarMe =  new PagarMe($this->apiKey);

        $amountToCapture = $amount;
        $transaction = $pagarMe->transaction()->get($token);
        $this->transaction = $pagarMe->transaction()->capture(
            $transaction,
            $amountToCapture
        );
        
        //check status to see if the transaction was paid
        if ($this->transaction->getStatus() == 'paid') {
            return true;
        }
        return false;
    }
}