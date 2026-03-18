<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require_once __DIR__ . '/bootstrap.php';

$commands = [];

ConsoleRunner::run(
    new SingleManagerProvider($entityManager),
    $commands
);
//  mkdir -p -m=777 ./var/cache && php cli-config.php orm:generate-proxies ./var/cache