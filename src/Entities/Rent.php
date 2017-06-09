<?php

namespace JamesMiranda\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Class Rent
 * Class for Rent Doctrine Entity
 * @author James Miranda <james.miranda@riosoft.com>
 * @package JamesMiranda\Entities
 * @Entity @Table(name="rents")
 */
class Rent
{
    /**
     * @var Fantasy $Fantasy
     * @Id
     * @ManyToOne(targetEntity="Fantasy")
     * @JoinColumn(name="FantasyId", referencedColumnName="Id")
     */
    protected $Fantasy;

    /**
     * @var Client $Client
     * @Id
     * @ManyToOne(targetEntity="Client")
     * @JoinColumn(name="ClientId", referencedColumnName="Id")
     */
    protected $Client;   

    /**
     * @var \DateTime $RentDate
     * @Column(type="datetime")
     */
    protected $RentDate;

    /**
     * @var string $TotalPrice
     * @Column(type="decimal", precision=7, scale=2)
     */
    protected $TotalPrice;

    /**
     * @return Fantasy
     */
    public function getFantasy()
    {
        return $this->Fantasy;
    }

    /**
     * @param Fantasy $Fantasy
     */
    public function setFantasy($Fantasy)
    {
        $this->Fantasy = $Fantasy;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->Client;
    }

    /**
     * @param Client $Client
     */
    public function setClient($Client)
    {
        $this->Client = $Client;
    }

    /**
     * @return \DateTime
     */
    public function getRentDate()
    {
        return $this->RentDate;
    }

    /**
     * @param \DateTime $RentDate
     */
    public function setRentDate($RentDate)
    {
        $this->RentDate = $RentDate;
    }

    /**
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->TotalPrice;
    }

    /**
     * @param string $TotalPrice
     */
    public function setTotalPrice($TotalPrice)
    {
        $this->TotalPrice = $TotalPrice;
    }
}