<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Exceptions;

class ThemeNotFoundException extends \Exception
{
    public function __construct($theme, $code = null)
    {
        $this->message = sprintf('Theme [%s] not found.', $theme);
        $this->code = $code;
    }
}