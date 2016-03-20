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

$app->register(new Providers\TwigGlobalFunctionsProvider());
$app->register(new Providers\FlashBagServiceProvider());

$app['twig.loader.filesystem']->addPath(APP . 'Views', 'main');
$app['twig.loader.filesystem']->addPath($app['theme.path'] . '/views', 'theme');

Services\Service::setApp($app);
Services\Config::load();

require 'routes.php';
require 'helpers.php';

return $app;
