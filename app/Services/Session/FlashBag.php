<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Session;

use Boardy\Services\Service;

class FlashBag extends Service
{
    public static function __callStatic($name, $args)
    {
        return call_user_func_array([self::$app['session']->getFlashBag(), $name], $args);
    }
}
