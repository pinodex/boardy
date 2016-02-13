<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Silex\Application;
use Silex\Provider;
use Boardy\Providers;
use Boardy\Services;

$app = new Application();

$app->register(new Provider\TwigServiceProvider());
$app->register(new Provider\UrlGeneratorServiceProvider());
$app->register(new Provider\SessionServiceProvider());

require ROOT . 'config/app.php';

$app['theme.path'] = ROOT . 'resources/themes/' . $app['theme.name'];

$app->register(new Providers\IlluminateDatabaseServiceProvider());
$app->register(new Providers\ThemeServiceProvider());
$app->register(new Providers\AssetsServiceProvider());

if ($app['debug']) {
    $app->register(new Provider\HttpFragmentServiceProvider());
    $app->register(new Provider\ServiceControllerServiceProvider());
    $app->register(new Provider\WebProfilerServiceProvider());
}

/*
 * Initialize connection to database.
 */
$app['database'];

$app['session.storage.handler'] = $app->share(function() use ($app) {
    return new Services\Sessions\IlluminateDatabaseSessionHandler(
        $app['database'],
        $app['session.storage.handler.options']
    );
});

$app->register(new Providers\DbConfigServiceProvider());

$app['twig.loader.filesystem']->addPath(APP . 'Views', 'main');
$app['twig.loader.filesystem']->addPath($app['theme.path'] . '/views', 'theme');

$app['twig'] = $app->share($app->extend('twig', function(\Twig_Environment $twig, Application $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function($path) use ($app) {
        return $app['assets']->get($path);
    }));

    return $twig;
}));

require 'routes.php';
return $app;
