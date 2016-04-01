<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Routes\Site;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Boardy\Controllers\Site\MainController;

class MainRoute implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        $controller->get('/', [MainController::class, 'index'])->bind('site.index');
        
        return $controller;
    }
}
