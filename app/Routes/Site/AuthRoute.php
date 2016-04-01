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
use Boardy\Controllers\Site\AuthController;

class AuthRoute implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        
        $controller->match('/login',    [AuthController::class, 'login'])->bind('auth.login');
        $controller->get  ('/logout',   [AuthController::class, 'logout'])->bind('auth.logout');
        $controller->match('/register', [AuthController::class, 'register'])->bind('auth.register');

        if ($app['https']) {
            $controller->requireHttps();
        }
        
        return $controller;
    }
}
