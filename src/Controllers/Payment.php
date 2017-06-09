<?php

namespace JamesMiranda\Controllers;

use Doctrine\ORM\EntityManager;
use Exception;
use JamesMiranda\Entities\Rent;
use JamesMiranda\Services\PagarMeService;

class Payment
{
    /**
     * @var Object $transaction
     */
    protected $transaction;

    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var PagarMeService
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
        $this->pagarMe = $pagarMe;

        $this->em = $em;
    }

    /**
     * @param string $token
     * @param string $amount
     * @return bool
     */
    public function getTransaction($token, $amount)
    {
        $this->transaction = $this->pagarMe->getTransaction($token, $amount);

        
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

                $totalPrice = ($fantasyDB->getPrice() * $fantasy['qtd']) + 42;
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

            $this->em->flush();
            //use Pagarme to actually pay the vendor TODO: Did not work with fake bankaccount number
            /*if(!$this->pagarMe->payVendor($vendor, $money)) {
                throw new Exception("Pagamento gravado no banco, mas não enviado");
            }*/
        } else {
            //get owner
            $query = 'SELECT Id FROM vendors WHERE Owner = 1';

            $stmt = $this->em->getConnection()->prepare($query);
            $stmt->execute();
            $result =  $stmt->fetchAll();

            $total = $rent->getTotalPrice();
            $totalForVendorO = ($total - 42) * 0.15;//15%
            $totalForVendor = $total - $totalForVendorO;//85% + 42

            $vendorO = $this->em->find('JamesMiranda\Entities\Vendor', $result[0]['Id']);
            $moneyVO = $vendorO->getMoney();
            $vendorO->setMoney((string)((float)$totalForVendorO + (float)$moneyVO));
            $money = $vendor->getMoney();
            $vendor->setMoney((string)((float)$totalForVendor + (float)$money));

            $this->em->flush();

            /*$pay1 = $this->pagarMe->payVendor($vendor, $totalForVendor);
            $pay2 = $this->pagarMe->payVendor($vendorO, $totalForVendorO);

            if (!($pay1 && $pay2)) {
                //if any payment fails
                throw new Exception("Pagamentos gravados no banco, mas não enviados");
            }*/
        }
    }
}