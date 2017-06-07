<?php

namespace JamesMiranda\Entities;

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
}