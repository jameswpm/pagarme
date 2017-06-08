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
     * @var Vendor $Vendor
     * @OneToOne(targetEntity="Vendor")
     * @JoinColumn(name="VendorId", referencedColumnName="Id")
     */
    protected $Vendor;

    /**
     * @var \DateTime $RentDate
     * @Column(type="datetime")
     */
    protected $RentDate;

    /**
     * @var float $TotalPrice
     * @Column(type="float")
     */
    protected $TotalPrice;

    /**
     * @return Fantasy
     */
    public function getFantasy(): Fantasy
    {
        return $this->Fantasy;
    }

    /**
     * @param Fantasy $Fantasy
     */
    public function setFantasy(Fantasy $Fantasy)
    {
        $this->Fantasy = $Fantasy;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->Client;
    }

    /**
     * @param Client $Client
     */
    public function setClient(Client $Client)
    {
        $this->Client = $Client;
    }

    /**
     * @return Vendor
     */
    public function getVendor(): Vendor
    {
        return $this->Vendor;
    }

    /**
     * @param Vendor $Vendor
     */
    public function setVendor(Vendor $Vendor)
    {
        $this->Vendor = $Vendor;
    }

    /**
     * @return \DateTime
     */
    public function getRentDate(): \DateTime
    {
        return $this->RentDate;
    }

    /**
     * @param \DateTime $RentDate
     */
    public function setRentDate(\DateTime $RentDate)
    {
        $this->RentDate = $RentDate;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->TotalPrice;
    }

    /**
     * @param float $TotalPrice
     */
    public function setTotalPrice(float $TotalPrice)
    {
        $this->TotalPrice = $TotalPrice;
    }
}