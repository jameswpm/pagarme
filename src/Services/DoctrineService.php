<?php

namespace JamesMiranda\Services;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineService
 * @author James Miranda <james.miranda@riosoft.com>
 * @package JamesMiranda\Services
 */
class DoctrineService
{
    /**
     * @var \Doctrine\ORM\Configuration $configuration
     */
    protected $configuration;

    /**
     * @var array $connection
     */
    protected $connection;

    /**
     * DoctrineService constructor.
     */
    public function __construct()
    {
        $isDevMode = true;
        $this->configuration = Setup::createAnnotationMetadataConfiguration(
            [__DIR__.'/../Entities'],
            $isDevMode
        );

        $this->connection = [
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__.'/../../db/db.sqlite'
        ];


        $this->entityManager = EntityManager::create($this->connection, $this->configuration);
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->entityManager;
    }

}