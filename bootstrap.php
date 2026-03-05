<?php

use app\Containers\Container;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . '/vendor/autoload.php';

$shutdownFunction = function () {
    echo error_get_last()['message'] ?? 'Нет сообщения';
};

register_shutdown_function($shutdownFunction);

$proxyDir = __DIR__ . '/var/cache';

$config = ORMSetup::createAttributeMetadataConfig(
    paths: [__DIR__ . '/Entity'],
    isDevMode: true,
    cacheNamespaceSeed: $proxyDir
);

$config->setProxyDir($proxyDir);
$config->setAutoGenerateProxyClasses(true);
$config->setProxyNamespace('DoctrineORM\Proxy');

$dotenv = Dotenv::createImmutable('/opt/env/');
$dotenv->load();

$connectionParams = [
    'dbname' => $_ENV['dbname'],
    'user' => $_ENV['user'],
    'password' => $_ENV['password'],
    'host' => $_ENV['host'],
    'port' => $_ENV['port'],
    'driver' => $_ENV['driver'],
    'charset' => $_ENV['charset']
];

$connection = DriverManager::getConnection($connectionParams);

$entityManager = new EntityManager($connection, $config);
$entityManager->getConnection()->executeQuery("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

Container::set(EntityManager::class, $entityManager);

$logger = new Logger('logger');
$logger->pushHandler(new StreamHandler('/var/log/projects/test2/logs.txt'));
$logger->pushHandler(new FirePHPHandler());

Container::set(Logger::class, $logger);

/**
 * Возвращает строку, отформатированную, как имя собственное.
 *
 * @param string|null $word
 * @return string|null
 */
function formatProperNoun(?string $word): ?string
{
    if (is_null($word)) {
        return null;
    }

    $word = mb_strtolower(trim($word));
    $firstChar = mb_strtoupper(mb_substr($word, 0, 1));
    return $firstChar . mb_substr($word, 1);
}

/**
 * Выводит на фронт массив объектов.
 *
 * @param array $objects
 * @return void
 */
function echoJson(array $objects): void
{
    $new = array_map(function (object $object) {

        $objectProperties = [];

        foreach ($object as $key => $property) {
            $objectProperties[$key] = $property;
        }

        return $objectProperties;
    }, $objects);

    header("Content-type: application/json");
    echo json_encode($new);
}

/**
 * Выводит ошибку на фронт с кодом ответа.
 *
 * @param string $error
 * @param int $code
 * @return void
 */
function throwServerError(string $error, int $code = 500): void
{
    http_response_code($code);
    echo $error;
}