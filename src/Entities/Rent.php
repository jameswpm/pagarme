<?php

namespace JamesMiranda\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

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


}