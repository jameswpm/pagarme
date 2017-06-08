<?php
/**
 * Basic Bootstrap file for Doctrine
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$configuration = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/../src/Entities'],
    $isDevMode
);

// SQLite Config
$connection = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../db/db2.sqlite'
];


$entityManager = EntityManager::create($connection, $configuration);