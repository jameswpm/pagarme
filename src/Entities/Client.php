<?php

namespace JamesMiranda\Entities;

/**
 * Class Client
 * Class for Client Doctrine Entity
 * @author James Miranda <james.miranda@riosoft.com>
 * @package JamesMiranda\Entities
 * @Entity @Table(name="clients")
 */
class Client
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



}