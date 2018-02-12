<?php

use Bookstore\Core\Config;
use Bookstore\Core\Router;
use Bookstore\Core\Request;
use Bookstore\Utils\DependencyInjector;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__ . '/vendor/autoload.php';

$config = new Config();
$dbConfig = $config->get('db');
$db = new PDO(
    'mysql:host=127.0.0.1;dbname=bookstore',
    $dbConfig['user'],
    $dbConfig['password']
);

$log = new Logger('bookstore');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$redisConfig = $config->get('redis');
$redis = [];
try {
    $redis = new Predis\Client(array(
        "scheme" => $redisConfig['scheme'],
        "host" => $redisConfig['host'],
        "port" => $redisConfig['port']
    ));
} catch (Exception $e) {
    $log->error($e->getMessage());
}

$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$view = new Twig_Environment($loader);

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
$di->set('Logger', $log);
$di->set('Redis', $redis);

// load env
$jsonEnv = file_get_contents(__DIR__ . '/config/env.json');
foreach (json_decode($jsonEnv) as $key => $value) {
    $_ENV[$key] = $value;
}

$router = new Router($di);
$response = $router->route(new Request());
session_start();

echo $response;
