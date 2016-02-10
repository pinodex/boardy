<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Controllers\Main;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Boardy\Services\Themes\Theme;

class MainController
{
    public function index(Request $request, Application $app)
    {
        return Theme::view('index');
    }
}