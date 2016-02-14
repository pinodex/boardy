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
use Boardy\Services\Config\Sources\IlluminateDatabaseSource;

class DbConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Database configs service
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $app['config'] = $app->share(function() use ($app) {
            $config = new Config(new IlluminateDatabaseSource(
                $app['database'], 'configurations'
            ));

            $config->open();

            return $config;
        });
    }

    /**
     * Boot the Database configs service
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
        $app->finish(function() use ($app) {
            $app['config']->close();
        });
    }
}
