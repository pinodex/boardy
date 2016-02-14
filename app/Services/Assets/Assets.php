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

class Assets
{
    /**
     * @var string Assets base directory
     */
    private $base;

    /**
     * Constructs Assets
     *
     * @param string $base Assets base directory
     */
    public function __construct($base)
    {
        $this->base = $base;
    }

    /**
     * Get File object from path
     *
     * @param string $path Path to file
     *
     * @return Symfony\Component\HttpFoundation\File\File
     */
    public function getFile($path)
    {
        return new File($this->base . $path, true);
    }
}
