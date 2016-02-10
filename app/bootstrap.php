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
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Boardy\Providers\IlluminateDatabaseServiceProvider;
use Boardy\Providers\ThemeServiceProvider;

$app = new Application();

require ROOT . 'config/app.php';

$app['theme.path'] = ROOT . 'resources/themes/' . $app['theme.name'];

$app->register(new IlluminateDatabaseServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new ThemeServiceProvider());
$app->register(new UrlGeneratorServiceProvider());

if ($app['debug']) {
    $app->register(new HttpFragmentServiceProvider());
    $app->register(new ServiceControllerServiceProvider());
    $app->register(new WebProfilerServiceProvider());
}

$app['twig.loader.filesystem']->addPath(APP . 'Views', 'main');
$app['twig.loader.filesystem']->addPath($app['theme.path'] . '/views', 'theme');

require 'routes.php';
return $app;