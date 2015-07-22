<?php

require __DIR__ . '/vendor/autoload.php';

$config = include('config.php');
$app = new \Silex\Application();
$app->post('{route}', function($route) use ($config) {
    $loop = React\EventLoop\Factory::create();
    $body = file_get_contents('php://input');

    $dnsResolverFactory = new React\Dns\Resolver\Factory();
    $resolver = $dnsResolverFactory->createCached($config['dns'], $loop);

    $version = new oliverlorenz\reactphpmqtt\protocol\Version4();
    $connector = new oliverlorenz\reactphpmqtt\Connector($loop, $resolver, $version);

    $connector->create($config['server'], 1883);
    $connector->onConnected(function() use ($connector, $route, $body) {
        $i = 0;
        // for($i = 0; $i < 300; $i++)
        $connector->publish($route, $body);
        $connector->getLoop()->addPeriodicTimer(1, function(Timer $timer) use ($connector) {
            $connector->disconnect();
        });
    });
    $loop->run();
})
->assert('route', '.+');
$app->run();
