<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Config;

use Boardy\Services\Config\Sources\SourceInterface;

class Config implements SourceInterface
{
    /**
     * @var Boardy\Services\Config\Sources\SourceInterface Config source to use
     */
    private $source;

    /**
     * Constructs Config
     *
     * @param Boardy\Services\Config\Sources\SourceInterface $source Config source to use
     */
    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    /**
     * {@inheritdoc}
     */
    public function open()
    {
        return $this->source->open();
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return $this->source->close();
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $this->source->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        return $this->source->set($key, $value);
    }
}
