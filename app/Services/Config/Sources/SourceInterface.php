<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Config\Sources;

interface SourceInterface
{
    /**
     * Open connection to source
     */
    public function open();

    /**
     * Close connection to source
     */
    public function close();
    
    /**
     * Get entry by key
     *
     * @param string $key Entry key
     * @param mixed $default Default value when config entry does not exist
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Set entry by key
     *
     * @param string $key Entry key
     * @param mixed $value Entry value
     */
    public function set($key, $value);
}
