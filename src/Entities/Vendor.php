<?php

namespace JamesMiranda\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

/**
 * Class Vendor
 * Class for Vendor Doctrine Entity
 * @author James Miranda <james.miranda@riosoft.com>
 * @package JamesMiranda\Entities
 * @Entity @Table(name="vendors")
 */
class Vendor
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
     * @var boolean $Owner
     * @Column(type="boolean")
     */
    protected $Owner;

    /**
     * @var string $Money
     * @Column(type="decimal", precision=7, scale=2)
     */
    protected $Money;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param int $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
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
     * @return boolean
     */
    public function isOwner()
    {
        return $this->Owner;
    }

    /**
     * @param boolean $Owner
     */
    public function setOwner($Owner)
    {
        $this->Owner = $Owner;
    }

    /**
     * @return string
     */
    public function getMoney()
    {
        return $this->Money;
    }

    /**
     * @param string $Money
     */
    public function setMoney($Money)
    {
        $this->Money = $Money;
    }
}