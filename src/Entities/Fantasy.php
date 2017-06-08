<?php

namespace JamesMiranda\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

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
}