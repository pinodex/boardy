<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services;

use Silex\Application;

class Service
{
    /**
     * @var Silex\Application The application instance
     */
    protected static $app;

    /**
     * Set application container
     *
     * @param Silex\Application $app Application
     */
    public static function setApp(Application $app)
    {
        self::$app = $app;
    }
}
