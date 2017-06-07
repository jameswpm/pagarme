<?php

namespace JamesMiranda\Entities;

/**
 * Class Fantasy
 * Class for Fantasy Doctrine Entity
 * @author James Miranda <james.miranda@riosoft.com>
 * @package JamesMiranda\Entities
 * @Entity @Table(name="fantasies")
 */
class Fantasy
{
    /**
     * @var int $Id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $Id;

    /**
     * @var string $Name
     * @Column(type="string")
     */
    protected $Name;

    /**
     * @var string $Price
     * @Column(type="decimal", precision=7, scale=2)
     */
    protected $Price;

    /**
     * @var Vendor $Vendor
     * @ManyToOne(targetEntity="Vendor")
     * @JoinColumn(name="VendorId", referencedColumnName="Id")
     */
    protected $Vendor;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->Price;
    }

    /**
     * @param string $Price
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;
    }

    /**
     * @return Vendor
     */
    public function getVendor()
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

}