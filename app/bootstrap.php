<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Debug;
use Silex\Application;
use Silex\Provider;
use Boardy\Providers;
use Boardy\Services;
use Boardy\Services\Service;
use Boardy\Services\Config;
use Boardy\Services\Extension\ExtensionLoader;

class Boardy extends Application {
    use Application\FormTrait;
    use Application\UrlGeneratorTrait;

    const VERSION = '1.0.0';
}

$app = new Boardy();

$app->register(new Provider\TwigServiceProvider());
$app->register(new Provider\FormServiceProvider());
$app->register(new Provider\SessionServiceProvider());
$app->register(new Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array()
));

require ROOT . 'config/app.php';

error_reporting(0);

Debug\ErrorHandler::register();
Debug\ExceptionHandler::register(
    $app['debug']
);

$app['theme.path'] = ROOT . 'resources/themes/' . $app['theme.name'];

$app->register(new Providers\IlluminateDatabaseServiceProvider());
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

$app['session.storage.handler'] = $app->share(function () use ($app) {
    return new Services\Session\IlluminateDatabaseSessionHandler(
        $app['database'],
        $app['session.storage.handler.options']
    );
});

$app['flashbag'] = $app->share(function () use ($app) {
    return $app['session']->getFlashBag();
});

$app->register(new Providers\TwigGlobalFunctionsProvider());

$app['twig.loader.filesystem']->addPath(APP . 'Views', 'main');
$app['twig.loader.filesystem']->addPath($app['theme.path'] . '/views', 'theme');

Service::setApp($app);
Config::load();

require 'routes.php';
require 'helpers.php';

ExtensionLoader::load();

return $app;
