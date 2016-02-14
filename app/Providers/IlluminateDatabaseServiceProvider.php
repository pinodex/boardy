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
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class IlluminateDatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Illuminate Database service
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $app['database'] = $app->share(function() use ($app) {
            $capsule = new Capsule();

            $capsule->addConnection($app['database.connection']);
            $capsule->setEventDispatcher(new Dispatcher(new Container()));

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        });
    }

    /**
     * Boot the Illuminate Database service
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
    }
}
