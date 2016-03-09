<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Boardy\Services\Config\Config;

class TwigGlobalFunctionsProvider implements ServiceProviderInterface
{
    /**
     * Register the Twig Global Functions
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $app->extend('twig', function(\Twig_Environment $twig, Application $app) {
            $twig->addFunction(new \Twig_SimpleFunction('asset', function($path) use ($app) {
                return $app['assets']->get($path);
            }));

            $twig->addFunction(new \Twig_SimpleFunction('config', function($key, $default = null) use ($app) {
                return Config::get($key, $default);
            }));

            return $twig;
        });
    }

    /**
     * Boot the Twig Global Functions
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
        $app->extend('twig', function(\Twig_Environment $twig, Application $app) {
            $twig->addGlobal('app', null);
            $twig->addGlobal('forum_name', Config::get('forum_name', 'Boardy Forums'));
            $twig->addGlobal('request_uri', $app['request']->getRequestUri());
            $twig->addGlobal('request_route', $app['request']->get('_route'));

            if (isset($app['flashbag'])) {
                $twig->addGlobal('flashbag', $app['flashbag']);
            }

            return $twig;
        });
    }
}