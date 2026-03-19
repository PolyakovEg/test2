<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require_once __DIR__ . '/bootstrap.php';

$commands = [];

ConsoleRunner::run(
    new SingleManagerProvider($entityManager),
    $commands
);