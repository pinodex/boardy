<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Event;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

class Event extends SymfonyEvent
{
    /**
     * @var mixed Event data
     */
    protected $data;

    /**
     * Constructs Event class
     *
     * @param mixed $data Event data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get Event data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
