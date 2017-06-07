<?php
/**
 * CLI config for Doctrine
 */
require __DIR__.'/bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);