<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Assets;

class PublicAssets
{
    /**
     * @var string Public assets base directory
     */
    private $base;

    /**
     * Constructs PublicAssets
     *
     * @param string $base Public assets base directory
     */
    public function __construct($base)
    {
        $this->base = $base;
    }

    /**
     * Get public path from path
     *
     * @param string $path Path to file
     *
     * @return string
     */
    public function get($path)
    {
        return $this->base . '/' . ltrim($path, '/');
    }
}
