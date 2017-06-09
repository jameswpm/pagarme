<?php

namespace JamesMiranda\Controllers;

use Doctrine\ORM\EntityManager;
use Exception;
use JamesMiranda\Entities\Rent;
use JamesMiranda\Entities\Vendor;
use JamesMiranda\Services\PagarMeService;
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
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var PagarMe
     */
    protected $pagarMe;

    /**
     * Payment constructor.
     * @param EntityManager $em
     * @param PagarMeService $pagarMe
     * @internal param String $key
     */
    public function __construct(EntityManager $em, PagarMeService $pagarMe)
    {
        $this->pagarMe = $pagarMe->getApi();

        $this->em = $em;
    }

    /**
     * @param string $token
     * @param string $amount
     * @return bool
     */
    public function getTransaction($token, $amount)
    {
        $amountToCapture = $amount;
        $transaction = $this->pagarMe->transaction()->get($token);
        $this->transaction = $this->pagarMe->transaction()->capture(
            $transaction,
            $amountToCapture
        );
        
        //check status to see if the transaction was paid
        if ($this->transaction->getStatus() == 'paid') {
            return true;
        }
        return false;
    }

    /**
     * @param array $fantasies
     * @throws Exception
     */
    public function saveInfo(Array $fantasies)
    {
        try{
            //for each fantasy, a new rent is created and the payment is done with API
            foreach ($fantasies as $fantasy) {
                $fantasyDB = $this->em->find('JamesMiranda\Entities\Fantasy', $fantasy['fantasie_id']);
                if($fantasyDB === null){
                    throw new Exception('Problems to get the fantasies in database.');
                }

                //region mock Client - this region should be in a specific ClientController
                $client = $this->em->find('JamesMiranda\Entities\Client', 1);
                //endregion

                $totalPrice = $fantasyDB->getPrice() * $fantasy['qtd'];
                $now = new \DateTime();

                $rent = new Rent();
                $rent->setClient($client);
                $rent->setFantasy($fantasyDB);
                $rent->setRentDate($now);
                $rent->setTotalPrice($totalPrice);

                $this->em->persist($rent);
                $this->em->flush();

                $this->recipients($rent);
            }
        } catch (Exception $e) {
            throw $e;//up
        }
    }

    private function recipients(Rent $rent)
    {
        $fantasy = $rent->getFantasy();
        $vendor = $fantasy->getVendor();

        //calc the vendor's payment
        if ($vendor->isOwner()) {
            $money = $vendor->getMoney();
            $vendor->setMoney((string)((float)$rent->getTotalPrice() + (float)$money));
        } else {
            //get owner
            $query = $this->em->createQuery( 'SELECT Id FROM vendors WHERE Owner = 1 LIMIT 1' );

            $vendorO = new Vendor($query);

            $total = $rent->getTotalPrice();
            $totalForVendorO = ($total - 42) * 0.15;//15%
            $totalForVendor = $total - $totalForVendorO;//85% + 42

            $moneyVO = $vendorO->getMoney();
            $vendorO->setMoney((string)((float)$totalForVendorO + (float)$moneyVO));
            $money = $vendor->getMoney();
            $vendor->setMoney((string)((float)$totalForVendor + (float)$money));
        }

        $this->em->flush();

    }
}