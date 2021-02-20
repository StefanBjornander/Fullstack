<?php
use Bank\Core\Config;
use Bank\Core\Router;
use Bank\Core\Request;
use Bank\Utils\DependencyInjector;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__ . '/vendor/autoload.php';
$config = new Config();

$dbConfig = $config->get('db');
/*echo "DB " . $dbConfig['database'] . "<br>";
echo "User " . $dbConfig['user'] . "<br>";
echo "Pass " . $dbConfig['password'] . "<br>";*/
        
$db = new PDO(
    'mysql:host=' . $dbConfig['host'] .
    ';dbname=' . $dbConfig['database'],
    $dbConfig['user'],
    $dbConfig['password']
);
//echo "Hello2<br>";

$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$view = new Twig_Environment($loader);

$log = new Logger('bookstore');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
$di->set('Logger', $log);

echo <<< _END
<!DOCTYPE html>
<html>
<body>
_END;
//echo "Hello3<br>";
$router = new Router($di);
//echo "Hello4<br>";
$response = $router->route(new Request());
//echo "Hello5<br>";
echo $response . "</body>";
//echo "Hello6<br>";
?>