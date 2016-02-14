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
use Boardy\Services\Themes\Theme;

class ThemeServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Theme service
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $app['theme'] = $app->share(function($theme) use ($app) {
            return new Theme($app);
        });
    }

    /**
     * Boot the Theme service
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
        $app->before(function() use ($app) {
            $app['theme'];
        }, Application::EARLY_EVENT);
    }
}
