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

class FlashBagServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Flash Bag service
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $app['flashbag'] = $app->share(function() use ($app) {
            return $app['session']->getFlashBag();
        });
    }

    /**
     * Boot the Flash Bag service
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
    }
}
