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
use Parsedown;

class MarkdownServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Markdown service
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $app['markdown'] = $app->share(function () {
             $parsedown = Parsedown::instance();
             $parsedown->setMarkupEscaped(true);

             return $parsedown;
        });
    }

    /**
     * Boot the Markdown service
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
    }
}
