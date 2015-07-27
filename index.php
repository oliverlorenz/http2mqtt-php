<?php

require __DIR__ . '/vendor/autoload.php';


$app = new \Silex\Application();
$app['debug'] = true;
$app->post('{route}', function($route) {
    $config = include('config.php');
    $test = system('mosquitto_pub -h ' . $config['host'] . ' -m "' . file_get_contents('php://input') . '" -t ' . $route);
    return new \Symfony\Component\HttpFoundation\Response($test, 200);
})
->assert('route', '.+');
$app->run();
